angular.module('EnergyMonitor').controller('ChartController', ['$scope', '$http', '$timeout', '$uibModal', 'FileSaver', 'Blob', ($scope, $http, $timeout, $uibModal, FileSaver, Blob) => {

    $scope.equipment_id = 0;

    let base_url = document.head.querySelector('meta[name="base-url"]').content;
    $scope.messages = {'error': '', 'success': '', 'detail':'', 'errors': {}, loading: false};

    $scope.setSuccess = (message, detail) => {
        $scope.messages.error = '';
        $scope.messages.detail = '';
        $scope.messages.success = message;
        $scope.messages.detail = detail;
        $timeout(() => {
            $scope.messages.success = '';
            $scope.messages.detail = '';
        }, 3000);
    };

    $scope.setError = (message, detail) => {
        $scope.messages.success = '';
        $scope.messages.detail = '';
        $scope.messages.error = message;
        $scope.messages.detail = detail;
        $timeout(() => {
            $scope.messages.error = '';
            $scope.messages.detail = '';
        }, 3000);
    };

    $scope.setLoading = (state) => {
        $scope.messages.loading = state;
    };


    $scope.chart = {variables: [], date: {startDate: new Date(), endDate: new Date()}};
    $scope.chart.date.startDate.setFullYear( $scope.chart.date.startDate.getFullYear() - 1 );

    $scope.init = (id, chart_variables) => {
        $scope.equipment_id = id;

        $scope.chart.variables = chart_variables;
        for (let i = 0; i < $scope.chart.variables.length;i++)
            $scope.chart.variables[i] = $scope.chart.variables[i] + '';

        $scope.loadChart();
    };


    $scope.options = {};
    $scope.series = [];
    $scope.chart_data = [];

    $scope.options = {
        responsive: true,
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    displayFormats: {
                        quarter: 'MMM YYYY'
                    }
                }
            }]
        }
    };
    $scope.series = ['a'];

    $scope.loadChart = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/equipments/chart/' + $scope.equipment_id, $scope.chart).then((response) => {
            $scope.setLoading(false);
            $scope.series = response.data.series;
            $scope.chart_data = response.data.chart_data;
            for(let i = 0; i < $scope.chart_data.length; i++) {
                for(let j = 0; j < $scope.chart_data[i].length; j++) {
                    $scope.chart_data[i][j].x = new Date($scope.chart_data[i][j].x);
                }
            }
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined') $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined') $scope.messages.errors = response.data.errors;
        });
    };


    $scope.openModal = () => {
        let modalInstance = $uibModal.open({
            templateUrl: 'ChartConfigModal.html',
            controller: 'ChartConfigController',
            resolve: {
                chart: () => {
                    return $scope.chart;
                }
            }
        });
        modalInstance.result.then((config) => {
            $scope.chart = config;
            $scope.loadChart();
        });
    };

    $scope.export = () => {
        document.getElementById("advanced-chart").toBlob((blob) => {
            FileSaver.saveAs(blob, "chart.png");
        });
    };
}]);

