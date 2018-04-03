@component('components.panel', ['class' => 'box-primary'])

    @slot('title')
        {{__('Equipment detail')}}
    @endslot

    <ul class="list-group list-group-unbordered">
        @foreach($equipment->variables as $variable)
            <li class="list-group-item" title="{{__("Updated")}} {{__($variable->updated_since)}}">
                <b>{{__($variable->printable_name)}}</b> <a class="pull-right">{{__($variable->printable_value)}}</a>
            </li>
        @endforeach
    </ul>

@endcomponent