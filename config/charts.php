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
                '/js/chart-vendor/gauge.min.js',
            ],
        ],

        'chartist' => [
            'scripts' => [
                '/js/chart-vendor/chartist.min.js',
            ],
            'styles' => [
                '/css/chart-vendor/chartist.min.css',
            ],
        ],

        'chartjs' => [
            'scripts' => [
                '/js/chart-vendor/Chart.min.js',
            ],
        ],

        'fusioncharts' => [
            'scripts' => [
                '/js/chart-vendor/fusioncharts.js',
                '/js/chart-vendor/fusioncharts.theme.fint.js',
            ],
        ],

        'google' => [
            'scripts' => [
                '/vendor/google/jsapi',
                '/vendor/google/loader.js',
                "google.charts.load('current', {'packages':['corechart', 'gauge', 'geochart', 'bar', 'line']})",
            ],
        ],

        'highcharts' => [
            'styles' => [
                // The following CSS is not added due to color compatibility errors.
                // 'https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/css/highcharts.css',
            ],
            'scripts' => [
                '/js/chart-vendor/highcharts.js',
                '/js/chart-vendor/offline-exporting.js',
                '/js/chart-vendor/map.js',
                '/js/chart-vendor/data.js',
                '/js/chart-vendor/world.js',
            ],
        ],

        'justgage' => [
            'scripts' => [
                '/vendor/justgage/raphael.min.js',
                '/vendor/justgage/justgage.min.js',
            ],
        ],

        'morris' => [
            'styles' => [
                '/vendor/morris/morris.css',
            ],
            'scripts' => [
                '/vendor/morris/raphael.min.js',
                '/vendor/morris/morris.min.js',
            ],
        ],

        'plottablejs' => [
            'scripts' => [
                '/vendor/progressbarjs/d3.min.js',
                '/vendor/progressbarjs/plottable.min.js',
            ],
            'styles' => [
                '/vendor/progressbarjs/plottable.css',
            ],
        ],

        'progressbarjs' => [
            'scripts' => [
                '/vendor/progressbarjs/progressbar.min.js',
            ],
        ],

        'c3' => [
            'scripts' => [
                '/vendor/c3/d3.min.js',
                '/vendor/c3/c3.min.js',
            ],
            'styles' => [
                '/vendor/c3/c3.min.css',
            ],
        ],

        'echarts' => [
            'scripts' => [
                '/vendor/echarts.min.js',
            ],
        ],

        'amcharts' => [
            'scripts' => [
                '/vendor/amcharts/amcharts.js',
                '/vendor/amcharts/serial.js',
                '/vendor/amcharts/plugins/export/export.min.js',
                '/vendor/amcharts/themes/light.js',
            ],
            'styles' => [
                '/vendor/amcharts/plugins/export/export.css',
            ],
        ],
    ],
];
