angular.module('EnergyMonitor').controller('ChartController', ['$scope', '$http', '$timeout', '$window', 'Blob', ($scope, $http, $timeout, $window, Blob) => {

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

    $scope.chart = {variables: [], date: {startDate: null, endDate: null}};

    $scope.init = (id, chart_variables) => {
        $scope.equipment_id = id;
        $scope.chart.variables = chart_variables;
        $scope.loadChart();
    };


    $scope.labels = [];
    $scope.series = [];
    $scope.chart_data = [];

    $scope.loadChart = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/equipments/chart/' + $scope.equipment_id, $scope.chart).then((response) => {
            $scope.setLoading(false);
            $scope.labels = response.data.labels;
            $scope.series = response.data.series;
            $scope.chart_data = response.data.chart_data;
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined') $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined') $scope.messages.errors = response.data.errors;
        });
    };


    $uibModal.open({
        templateUrl: 'ChartConfigModal.html',
        controller: 'ModalInstanceCtrl',
        resolve: {
            items: function () {
                return $ctrl.items;
            }
        }
    });


}]);

