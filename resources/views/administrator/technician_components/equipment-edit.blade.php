
@component('components.panel', ['title' => __('Parameters')])
    @if(session('edit-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('edit-error')['message'])}}</h5>
        </div>
    @endif
    @if(session('edit-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('edit-success')['message'])}}</h5>
        </div>
    @endif
    <form action="{{route('technician.equipment.edit', ['equipment' => $equipment])}}" method="POST" role="form">
        @csrf
        <div class="form-group">
            <label for="name">{{__('Name')}}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{$equipment->name}}">
        </div>
        <div class="form-group">
            <label for="address_ip">{{__('Address Ip')}}</label>
            <input type="text" name="address_ip" id="address_ip" class="form-control" value="{{$equipment->address_ip}}">
        </div>
        <div class="form-group">
            <label for="port">{{__('Port')}}</label>
            <input type="number" min="1" max="65535" name="port" id="port" class="form-control" value="{{$equipment->port}}">
        </div>
        <div class="form-group">
            <label for="port">{{__('Slave')}}</label>
            <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" value="{{$equipment->slave}}">
        </div>
        <div class="form-group">
            <label for="localisation">{{__('Localisation')}}</label>
            <input type="text" name="localisation" id="localisation" class="form-control" value="{{$equipment->localisation}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">{{__('Edit')}}</button>
            </div>
        </div>
    </form>
@endcomponent