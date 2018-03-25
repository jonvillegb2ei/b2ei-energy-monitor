
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import "angular";
import "angular-loading-bar";
import "angular-animate";
import "angular-ui-bootstrap";
import "angular-file-saver";





window.viewport = require('responsive-toolkit');


require('chart.js');
require('angular-chart.js');

window.moment = window.momentjs = require('moment');
require('bootstrap-daterangepicker');
require('angular-daterangepicker');

require('bootstrap-ui-datetime-picker');



angular.module('EnergyMonitor', ['angular-loading-bar', 'ngAnimate', 'ui.bootstrap', 'daterangepicker', 'ngFileSaver', 'chart.js'], ($interpolateProvider, $httpProvider, ChartJsProvider) => {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');

    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        $httpProvider.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    }
    ChartJsProvider.setOptions({ colors : [ '#2196F3', '#F44336', '#FFC107','#617881','#238176','#e9c46a','#f4a261','#e76f51'] });

});

require('./angularjs/Controllers/Technician/ModbusClientController.js');
require('./angularjs/Controllers/Technician/AppLogsController.js');
require('./angularjs/Controllers/Technician/SysLogsController.js');
require('./angularjs/Controllers/Technician/PingController.js');
require('./angularjs/Controllers/Technician/IdentifyController.js');
require('./angularjs/Controllers/Technician/EquipmentsController.js');
require('./angularjs/Controllers/Technician/EquipmentCreateController.js');

require('./angularjs/Controllers/Equipments/ExportController.js');
require('./angularjs/Controllers/Equipments/ChartController.js');


angular.module('EnergyMonitor').run();



