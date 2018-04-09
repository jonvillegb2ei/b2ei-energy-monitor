
<div ng-controller="ChartsEquipmentManagerController" ng-init="init({{$equipment->id}})">
    <div class="col-xs-12 col-md-8 col-xl-9" ng-repeat="chart in charts">
        <chart-equipment data-equipment-id="equipment"
                         data-chart-id="chart.id"
                         data-chart-title="chart.title"
                         data-chart-options='chart.options'
                         data-date-widget="chart.date_widget"
                         data-chart-type="chart.type"
                         data-chart-data="[]"></chart-equipment>
    </div>
</div>


<div class="col-md-12">
    @component('components.panel', ['class' => 'box-primary', 'controller' => 'ChartController', 'init' => 'init('.$equipment->id.','.$equipment->widgetVariables->pluck('id')->toJson().')'])

        <script type="text/ng-template" id="ChartConfigModal.html">
            @include('app.equipment_components.chart-modal')
        </script>

        @slot('title')
            {{__('Advanced chart')}}
        @endslot

        @slot('tools')
            <div class="btn-group">
                <button type="button" ng-click="export()" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-download"></i></button>
                <button type="button" ng-click="openModal()" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-gear"></i></button>
            </div>
        @endslot

        @component('components.angular-messages')

        @endcomponent


        <canvas id="advanced-chart" class="chart chart-line" chart-data="chart_data"
                chart-options="options" chart-series="series">
        </canvas>


    @endcomponent
</div>