
@component('components.panel', ['title' => 'Equipments', 'body_class' => 'no-padding'])


    <div class="row" style="padding-right: 10px; padding-left: 10px">
        <div class="col-md-12">
            @if(session('equipment-error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>{{__(session('equipment-error')['message'])}}</h5>
                    <small style="max-height: 150px; overflow-y: scroll">{!!nl2br(e(session('equipment-error')['output']))!!}</small>
                </div>
            @endif
            @if(session('equipment-success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>{{__(session('equipment-success')['message'])}}</h5>
                    <small style="max-height: 150px; overflow-y: scroll">{!!nl2br(e(session('equipment-success')['output']))!!}</small>
                </div>
            @endif
        </div>
    </div>

    <table class="table">
        <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Localisation')}}</th>
            <th>{{__('Brand')}}</th>
            <th>{{__('Reference')}}</th>
            <th>{{__('Address IP')}}</th>
            <th>{{__('Slave')}}</th>
            <th>&nbsp;</th>
        </tr>
        @foreach($equipments as $equipment)
            <tr>
                <td>{{$equipment->id}}.</td>
                <td>{{$equipment->name}}</td>
                <td>{{$equipment->localisation}}</td>
                <td>{{$equipment->product->brand}}</td>
                <td>{{$equipment->product->reference}}</td>
                <td>{{$equipment->address_ip}}:{{$equipment->port}}</td>
                <td>{{$equipment->slave}}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">{{__('Action')}}</button>
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">{{__('Toggle Dropdown')}}</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('technician.equipment.ping', ['equipment' => $equipment])}}">{{__('Ping device IP')}}</a></li>
                            <li><a href="{{route('technician.equipment.test', ['equipment' => $equipment])}}">{{__('Test equipment')}}</a></li>
                            <li class="divider"></li>
                            <li><a href="{{route('technician.equipment.detail', ['equipment' => $equipment])}}">{{__('Advanced parameters')}}</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endcomponent