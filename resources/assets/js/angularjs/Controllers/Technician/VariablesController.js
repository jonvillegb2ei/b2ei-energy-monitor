
angular.module('EnergyMonitor').controller('VariablesController', ['$scope', '$http', '$timeout', ($scope, $http, $timeout) => {


    let base_url = document.head.querySelector('meta[name="base-url"]').content;
    $scope.messages = {'error': '', 'success': '', 'detail':'', 'errors': {}, loading: false};
    $scope.equipment = null;

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

    $scope.init = (equipment) => {
        $scope.equipment = equipment;
        $scope.load();
    };

    $scope.load = () => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/technician/variables/' + $scope.equipment).then((response) => {
            $scope.variables = response.data;
            $scope.setLoading(false);
        }, () => {
            $scope.variables = [];
            $scope.setLoading(false);
        });
    };


    $scope.edit = (variable) => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/technician/variable/edit/' + variable.id, variable).then((response) => {
            $scope.setLoading(false);
            if (response.data.return)
                $scope.setSuccess(response.data.message, '');
            else
                $scope.setError(response.data.message, '');
        }, () => {
            $scope.variables = [];
            $scope.setLoading(false);
        });
    };


}]);