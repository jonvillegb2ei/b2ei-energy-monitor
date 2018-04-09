angular.module('EnergyMonitor').controller('ChartEquipmentController', ['$scope', '$http', '$timeout', ($scope, $http, $timeout) => {


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

    $scope.openDatePopup = () => {
        $scope.datepicker.opened = true;
    };

    $scope.datepicker = {
        opened: false,
        format: 'dd-MMMM-yyyy',
        date: new Date(),
        options: {
            dateDisabled: false,
            popupPlacement: "auto bottom-left",
            formatYear: 'yy',
            maxDate: new Date(),
            startingDay: 1
        }
    };

    $scope.loadChart = () => {
        $scope.setLoading(true);
        let data = { date: {startDate: $scope.datepicker.date, endDate: null }};
        $http.post(base_url + '/equipments/charts/' + $scope.equipment + '/' + $scope.id, data).then((response) => {
            $scope.setLoading(false);
            $scope.chart_data = response.data.data;
            $scope.series = response.data.series;
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
}]);