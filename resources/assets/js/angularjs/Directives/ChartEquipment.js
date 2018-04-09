angular.module('EnergyMonitor').directive('chartEquipment',[ () => {
    return {
        restrict: 'E',
        replace: true,
        transclude: false,
        controller: "ChartEquipmentController",
        scope: {
            equipment: '=equipmentId',
            id: '=chartId',
            title: '=chartTitle',
            type: '=chartType',
            date_widget: '=dateWidget',
            options: '=chartOptions',
        },
        template: require('./ChartEquipmentTemplate.html'),
    };
}]);