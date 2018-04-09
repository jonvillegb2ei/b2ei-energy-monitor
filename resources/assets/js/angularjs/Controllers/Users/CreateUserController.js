angular.module('EnergyMonitor').controller('CreateUserController', ['$scope', '$http', '$timeout', '$rootScope', ($scope, $http, $timeout, $rootScope) => {

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

    $scope.data = { firstname: '', lastname: '', email: '', password: '', password_confirmation: '' };

    $scope.create = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/users/create', $scope.data).then((response) => {
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.setSuccess(response.data.message, '');
                $scope.messages.errors = {};
                $rootScope.$broadcast('user-created', $scope.data);
                $scope.data = { firstname: '', lastname: '', email: '', password: '', password_confirmation: '' };
            } else $scope.setError(response.data.message, '');
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

}]);
