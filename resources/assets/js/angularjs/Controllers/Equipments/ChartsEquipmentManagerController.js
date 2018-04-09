angular.module('EnergyMonitor').controller('ChartsEquipmentManagerController', ['$scope', '$http', '$timeout', ($scope, $http, $timeout) => {

    $scope.equipment = null;


    $scope.charts = [];
    let base_url = document.head.querySelector('meta[name="base-url"]').content;

    $scope.init = (id) => {
        $scope.equipment = id;
        $scope.loadCharts();
    };

    $scope.loadCharts = () => {
        $http.get(base_url + '/equipments/charts/' + $scope.equipment).then( (response) => {
            $scope.charts = response.data;
        });
    };


}]);
