angular.module('EnergyMonitor').controller('TableUserController', ['$scope', '$http', '$timeout', ($scope, $http, $timeout) => {

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

    $scope.users = [];

    $scope.$on('user-created', (data) => { $scope.load(); });

    $scope.load = () => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/users/list').then((response) => {
            $scope.setLoading(false);
            $scope.users = response.data;
            $scope.messages.errors = {};
            $scope.setSuccess('');
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

    $scope.changeAdministrator = (user) => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/users/administrator/' + user.id + '/change-state').then((response) => {
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.setSuccess(response.data.message, '');
                user.administrator = !user.administrator;
            } else $scope.setError(response.data.message, '');
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

    $scope.remove = (user) => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/users/remove/' + user.id, user).then((response) => {
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.setSuccess(response.data.message, '');
                $scope.load();
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
