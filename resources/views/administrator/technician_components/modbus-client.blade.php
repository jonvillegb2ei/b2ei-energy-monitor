
@component('components.panel', ['title' => 'Modbus client'])

    @if(session('modbus-client-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('modbus-client-error')['message'])}}</h5>
            <small style="max-height: 150px; overflow-y: scroll">{!!nl2br(e(session('modbus-client-error')['output']))!!}</small>
        </div>
    @endif
    @if(session('modbus-client-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('modbus-client-success')['message'])}}</h5>
            <small style="max-height: 150px; overflow-y: scroll">{!!nl2br(e(session('modbus-client-success')['output']))!!}</small>
        </div>
    @endif

    <form action="{{route('technician.read-registers')}}" method="POST" role="form">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="identify_address_ip">Address Ip</label>
                    <input type="text" name="address_ip" id="modbus_address_ip" class="form-control" value="{{old('address_ip')}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="identify_port">Port</label>
                    <input type="number" min="0" max="65535" name="port" id="modbus_port" class="form-control" value="{{old('port', '502')}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="identify_slave">Slave</label>
                    <input type="number" min="0" max="255" name="slave" id="modbus_slave" class="form-control" value="{{old('slave', '1')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="identify_mei_type">Register</label>
                    <input type="number" min="0" max="65535" name="register" id="modbus_register" class="form-control" value="{{old('register', '1')}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="identify_device_id">Length</label>
                    <input type="number" min="1" max="50" name="length" id="modbus_length" class="form-control" value="{{old('length', '1')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">{{__('Read registers')}}</button>
            </div>
        </div>
    </form>
    <div class="row" style="padding-right: 20px; padding-top: 20px;">
        @for($i=0;$i<50;$i++)
            <div class="col-md-1">
                <div class="input-group input-xs">
                    <span class="input-group-addon" style="padding: 6px 6px; min-width: 25px; font-size: 10px">{{$i}}</span>
                    <input type="text" class="form-control" id="register{{$i}}" name="register{{$i}}" value="{{session('register_'.$i , '0')}}" style="min-width: 60px; font-size: 12px">
                </div>
            </div>
        @endfor
    </div>
@endcomponent