<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default settings for charts.
    |--------------------------------------------------------------------------
    */

    'default' => [
        'type' => 'line', // The default chart type.
        'library' => 'material', // The default chart library.
        'element_label' => 'Element', // The default chart element label.
        'empty_dataset_label' => 'No Data Set',
        'empty_dataset_value' => 0,
        'title' => 'My Cool Chart', // Default chart title.
        'height' => 400, // 0 Means it will take 100% of the division height.
        'width' => 0, // 0 Means it will take 100% of the division width.
        'responsive' => false, // Not recommended since all libraries have diferent sizes.
        'background_color' => 'inherit', // The chart division background color.
        'colors' => [], // Default chart colors if using no template is set.
        'one_color' => false, // Only use the first color in all values.
        'template' => 'material', // The default chart color template.
        'legend' => true, // Whether to enable the chart legend (where applicable).
        'x_axis_title' => false, // The title of the x-axis
        'y_axis_title' => null, // The title of the y-axis (When set to null will use element_label value).
        'loader' => [
            'active' => true, // Determines the if loader is active by default.
            'duration' => 500, // In milliseconds.
            'color' => '#000000', // Determines the default loader color.
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | All the color templates available for the charts.
    |--------------------------------------------------------------------------
    */
    'templates' => [

        'colors' => [],

        'material' => [
            '#2196F3', '#F44336', '#FFC107','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'red-material' => [
            '#B71C1C', '#F44336', '#E57373','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'indigo-material' => [
            '#1A237E', '#3F51B5', '#7986CB','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'blue-material' => [
            '#0D47A1', '#2196F3', '#64B5F6','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'teal-material' => [
            '#004D40', '#009688', '#4DB6AC','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'green-material' => [
            '#1B5E20', '#4CAF50', '#81C784','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'yellow-material' => [
            '#F57F17', '#FFEB3B', '#FFF176','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
        'orange-material' => [
            '#E65100', '#FF9800', '#FFB74D','#617881','#238176','#e9c46a','#f4a261','#e76f51'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Assets required by the libraries.
    |--------------------------------------------------------------------------
    */

    'assets' => [
        'global' => [
            'scripts' => [

            ],
        ],

        'canvas-gauges' => [
            'scripts' => [
                url('/js/chart-vendor/gauge.min.js'),
            ],
        ],

        'chartist' => [
            'scripts' => [
                url('/js/chart-vendor/chartist.min.js'),
            ],
            'styles' => [
                url('/css/chart-vendor/chartist.min.css'),
            ],
        ],

        'chartjs' => [
            'scripts' => [
                url('/js/chart-vendor/Chart.min.js'),
            ],
        ],

        'fusioncharts' => [
            'scripts' => [
                url('/js/chart-vendor/fusioncharts.js'),
                url('/js/chart-vendor/fusioncharts.theme.fint.js'),
            ],
        ],

        'google' => [
            'scripts' => [
                url('vendor/google/jsapi'),
                url('vendor/google/loader.js'),
                "google.charts.load('current', {'packages':['corechart', 'gauge', 'geochart', 'bar', 'line']})",
            ],
        ],

        'highcharts' => [
            'styles' => [
                // The following CSS is not added due to color compatibility errors.
                // 'https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/css/highcharts.css',
            ],
            'scripts' => [
                url('/js/chart-vendor/highcharts.js'),
                url('/js/chart-vendor/offline-exporting.js'),
                url('/js/chart-vendor/map.js'),
                url('/js/chart-vendor/data.js'),
                url('/js/chart-vendor/world.js'),
            ],
        ],

        'justgage' => [
            'scripts' => [
                url('vendor/justgage/raphael.min.js'),
                url('vendor/justgage/justgage.min.js'),
            ],
        ],

        'morris' => [
            'styles' => [
                url('vendor/morris/morris.css'),
            ],
            'scripts' => [
                url('vendor/morris/raphael.min.js'),
                url('vendor/morris/morris.min.js'),
            ],
        ],

        'plottablejs' => [
            'scripts' => [
                url('vendor/progressbarjs/d3.min.js'),
                url('vendor/progressbarjs/plottable.min.js'),
            ],
            'styles' => [
                url('vendor/progressbarjs/plottable.css'),
            ],
        ],

        'progressbarjs' => [
            'scripts' => [
                url('vendor/progressbarjs/progressbar.min.js'),
            ],
        ],

        'c3' => [
            'scripts' => [
                url('vendor/c3/d3.min.js'),
                url('vendor/c3/c3.min.js'),
            ],
            'styles' => [
                url('vendor/c3/c3.min.css'),
            ],
        ],

        'echarts' => [
            'scripts' => [
                url('vendor/echarts.min.js'),
            ],
        ],

        'amcharts' => [
            'scripts' => [
                url('vendor/amcharts/amcharts.js'),
                url('vendor/amcharts/serial.js'),
                url('vendor/amcharts/plugins/export/export.min.js'),
                url('vendor/amcharts/themes/light.js'),
            ],
            'styles' => [
                url('vendor/amcharts/plugins/export/export.css'),
            ],
        ],
    ],
];
