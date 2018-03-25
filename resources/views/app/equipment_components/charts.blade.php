
@foreach($equipment->getCharts() as $chart)
    <div class="{{$chart['size'] or 'col-xs-12 col-md-8 col-xl-9'}}">
        @component('components.panel', ['class' => 'box-primary'])
            @slot('title')
                {{__($chart['title'])}}
            @endslot
            {!! $chart['chart']->html() !!}
        @endcomponent
    </div>
@endforeach
<div class="col-md-12">
    @component('components.panel', ['class' => 'box-primary', 'controller' => 'ChartController', 'init' => 'init('.$equipment->id.','.$equipment->widgetVariables->pluck('id')->toJson().')'])
        @slot('title')
            {{__('Advanced chart')}}
        @endslot

        @component('components.angular-messages')

        @endcomponent


            <canvas id="line" class="chart chart-line" chart-data="chart_data"
                chart-labels="labels" chart-series="series"
                chart-dataset-override="datasetOverride">
        </canvas>


    @endcomponent
</div>