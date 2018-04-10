
angular.module('EnergyMonitor').controller('EquipmentEditController', ['$scope', '$http', '$timeout', '$rootScope', ($scope, $http, $timeout, $rootScope) => {

    let base_url = document.head.querySelector('meta[name="base-url"]').content;
    $scope.messages = {'error': '', 'success': '', 'detail': '', 'errors': {}, loading: false};

    $scope.setSuccess = (message, detail) => {
        $scope.messages.error = '';
        $scope.messages.detail = '';
        $scope.messages.success = message;
        $scope.messages.detail = detail;
        $scope.messages.errors = {};
        $timeout(() => {
            $scope.messages.success = '';
            $scope.messages.detail = '';
        }, 5000);
    };

    $scope.setError = (message, detail) => {
        $scope.messages.success = '';
        $scope.messages.detail = '';
        $scope.messages.error = message;
        $scope.messages.detail = detail;
        $timeout(() => {
            $scope.messages.error = '';
            $scope.messages.detail = '';
        }, 5000);
    };

    $scope.setLoading = (state) => {
        $scope.messages.loading = state;
    };


    $scope.init = (id) => {
        $scope.id = id;
        $scope.load();
    };

    $scope.data = {};

    $scope.load = () => {
        $http.get(base_url + '/admin/technician/view/' + $scope.id).then((response) => {
            $scope.data = response.data;
        }, (response) => {
            $scope.data = {};
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

    $scope.edit = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/technician/edit/' + $scope.id, $scope.data).then((response) => {
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.setSuccess(response.data.message, response.data.output);
                $scope.load();
            } else
                $scope.setError(response.data.message, response.data.output);
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

}]);