
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('admin-lte');
require('moment');
require('bootstrap-daterangepicker');




let angular = require('angularjs');


let angular_ui_bootstrap = require('angular-ui-bootstrap');
let angular_loading_bar = require('angular-loading-bar');
let angular_animate = require('angular-animate');



angular.module('EnergyMonitor', [angular_ui_bootstrap, angular_loading_bar, angular_animate], ($interpolateProvider, $httpProvider) => {
    $interpolateProvider.startSymbol('[{');
    $interpolateProvider.endSymbol('}]');

    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        $httpProvider.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    }
});

require('./angularjs/Controllers/Technician/ModbusClientController.js');
require('./angularjs/Controllers/Technician/AppLogsController.js');
require('./angularjs/Controllers/Technician/SysLogsController.js');
require('./angularjs/Controllers/Technician/PingController.js');
require('./angularjs/Controllers/Technician/IdentifyController.js');
require('./angularjs/Controllers/Technician/EquipmentsController.js');
require('./angularjs/Controllers/Technician/EquipmentCreateController.js');




angular.module('EnergyMonitor').run();



