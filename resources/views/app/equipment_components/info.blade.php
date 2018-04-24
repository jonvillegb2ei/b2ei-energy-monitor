<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" style="max-width: 150px; height: auto" src="{{$equipment->picture_url}}" alt="Equipment picture">
        <h3 class="profile-username text-center">{{__($equipment->name)}}</h3>
        <p class="text-muted text-center">{{__($equipment->localisation)}}</p>
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item"><b>{{__('Product brand')}}</b> <a class="pull-right">{{__($equipment->product->brand)}}</a></li>
            <li class="list-group-item"><b>{{__('Product reference')}}</b> <a class="pull-right">{{__($equipment->product->reference)}}</a></li>
            <li class="list-group-item"><b>{{__('Address Ip')}}</b> <a class="pull-right">{{__($equipment->address_ip)}}:{{__($equipment->port)}}</a></li>
            <li class="list-group-item"><b>{{__('Slave id')}}</b> <a class="pull-right">{{__($equipment->slave)}}</a></li>
            @foreach($equipment->widgetVariables as $variable)
                <li class="list-group-item"><b>{{__($variable->printable_name)}}</b> <a class="pull-right">{{__($variable->printable_value)}}</a></li>
            @endforeach
        </ul>
    </div>
</div>