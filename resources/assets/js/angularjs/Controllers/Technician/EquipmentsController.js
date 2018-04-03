
angular.module('EnergyMonitor').controller('EquipmentsController', ['$scope', '$http', '$timeout', '$window', ($scope, $http, $timeout, $window) => {

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


    $scope.page = 1;
    $scope.total = 0;
    $scope.load = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/technician/equipments', {page: $scope.page}).then((response) => {
            $scope.setLoading(false);
            $scope.equipments = response.data.data;
            $scope.page = response.data.page;
            $scope.total = response.data.total;
        }, (response) => {
            $scope.setLoading(false);
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };
    $scope.load();

    $scope.ping = (equipment_id) => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/technician/ping/' + equipment_id).then((response) => {
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

    $scope.test = (equipment_id) => {
        $scope.setLoading(true);
        $http.get(base_url + '/admin/technician/test/' + equipment_id).then((response) => {
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

    $scope.detail = (equipment_id) => {
        $window.location.href = base_url + '/admin/technician/detail/' + equipment_id;
    };

}]);

