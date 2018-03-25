angular.module('EnergyMonitor').controller('ChartConfigController', ['$scope', '$uibModalInstance', 'chart', ($scope, $uibModalInstance, chart) => {

    $scope.chart = chart;

    $scope.cancel = () => {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.validate = () => {
        $uibModalInstance.close($scope.chart);
    };

}]);

