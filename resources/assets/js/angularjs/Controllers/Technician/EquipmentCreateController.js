
angular.module('EnergyMonitor').controller('EquipmentCreateController', ['$scope', '$http', '$timeout', '$window', ($scope, $http, $timeout, $window) => {

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

    $scope.data = {
        'product_id': 1,
        'name': '',
        'address_ip': '',
        'port': 502,
        'slave': 1,
        'localisation': '',
    };
    $scope.create = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/technician/add/', $scope.data).then((response) => {
            $scope.setLoading(false);
            if (response.data.return)
                $scope.setSuccess(response.data.message, response.data.output);
            else
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
