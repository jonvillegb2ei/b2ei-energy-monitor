
angular.module('EnergyMonitor').controller('ModbusClientController', ['$scope', '$http', '$timeout', ($scope, $http, $timeout) => {

    let base_url = document.head.querySelector('meta[name="base-url"]').content;
    $scope.messages = {'error': '', 'success': '', 'detail':'', 'errors': {}, loading: false};

    $scope.setSuccess = (message, detail) => {
        $scope.messages.error = '';
        $scope.messages.detail = '';
        $scope.messages.success = message;
        $scope.messages.detail = detail;
        $scope.messages.errors = {};
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

    $scope.registers = [];
    $scope.registerCount = 60;

    $scope.client = {
        address_ip: '',
        port: 502,
        slave: 1,
        register: 1,
        length: 1,
    };

    $scope.resetRegisters = () => {
        for(let i = 0; i < $scope.registerCount; i++) {
            $scope.registers[i] = {index: (i+1), value: 0, class_name: ''};
        }
    };
    $scope.resetRegisters();

    $scope.execTest = () => {
        $scope.setLoading(true);
        $http.post(base_url + '/admin/technician/readRegisters', $scope.client).then((response) => {
            $scope.messages.errors = [];
            $scope.setLoading(false);
            if (response.data.return) {
                $scope.registers = response.data.registers;
                $scope.setSuccess(response.data.message, response.data.output);
            } else {
                $scope.resetRegisters();
                $scope.setError(response.data.message, response.data.output);
            }
        }, (response) => {
            $scope.setLoading(false);
            $scope.resetRegisters();
            if (typeof response.data.message !== 'undefined')
                $scope.setError(response.data.message);
            if (typeof response.data.errors !== 'undefined')
                $scope.messages.errors = response.data.errors;
        });
    };

}]);

