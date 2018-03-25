angular.module('EnergyMonitor').controller('ExportController', ['$scope', '$http', '$timeout', '$window', 'Blob', ($scope, $http, $timeout, $window, Blob) => {

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

    $scope.data = {variables: [], date: {startDate: null, endDate: null}};

    $scope.init = (id) => {
        $scope.equipment_id = id;
    };

    $scope.export = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/equipments/export/' + $scope.equipment_id, $scope.data).then((response) => {
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.setSuccess(response.data.messages, '');
                $window.location.href = response.data.url;
            } else {
                $scope.setError(response.data.messages, '');
            }
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined') $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined') $scope.messages.errors = response.data.errors;
        });
    };

}]);

