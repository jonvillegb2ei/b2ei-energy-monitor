
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
    @component('components.panel', ['class' => 'box-primary'])
        @slot('title')
            {{__('Advanced chart')}}
        @endslot



    @endcomponent
</div>