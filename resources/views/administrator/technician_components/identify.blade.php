
@component('components.panel', ['title' => 'Identifying tool'])
    @if(session('identify-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('identify-error')['message'])}}</h5>
            <small style="max-height: 200px; overflow-y: scroll">{!!nl2br(e(session('identify-error')['output']))!!}</small>
        </div>
    @endif
    @if(session('identify-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('identify-success')['message'])}}</h5>
            <small style="max-height: 200px; overflow-y: scroll">{!!nl2br(e(session('identify-success')['output']))!!}</small>
        </div>
    @endif
    <form action="{{route('technician.identify')}}" method="POST" role="form">
        @csrf
        <div class="form-group">
            <label for="identify_address_ip">Address Ip</label>
            <input type="text" name="address_ip" id="identify_address_ip" class="form-control" value="{{old('address_ip')}}">
        </div>
        <div class="form-group">
            <label for="identify_port">Port</label>
            <input type="number" min="0" max="65535" name="port" id="identify_port" class="form-control" value="{{old('port', '502')}}">
        </div>
        <div class="form-group">
            <label for="identify_slave">Slave</label>
            <input type="number" min="0" max="255" name="slave" id="identify_slave" class="form-control" value="{{old('slave', '1')}}">
        </div>
        <div class="form-group">
            <label for="identify_mei_type">MEI type</label>
            <input type="number" min="0" max="255" name="mei_type" id="identify_mei_type" class="form-control" value="{{old('mei_type', '14')}}">
        </div>
        <div class="form-group">
            <label for="identify_device_id">Device ID</label>
            <input type="number" min="0" max="4" name="device_id" id="identify_device_id" class="form-control" value="{{old('device_id', '1')}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Identify</button>
            </div>
        </div>
    </form>
@endcomponent