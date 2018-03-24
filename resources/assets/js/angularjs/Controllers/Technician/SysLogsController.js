
angular.module('EnergyMonitor').controller('SysLogsController', ['$scope', '$http', '$timeout', ($scope, $http) => {

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


    $scope.syslogs = '';
    $scope.dmesg = '';
    $scope.refresh = () => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/technician/syslogs').then((response) => {
            $scope.setLoading(false);
            $scope.syslogs = response.data.syslogs;
            $scope.dmesg = response.data.dmesg;
        }, (response) => {
            $scope.setLoading(false);
            $scope.syslogs = '';
            $scope.dmesg = '';
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
        });
    };
    $scope.refresh();

}]);

