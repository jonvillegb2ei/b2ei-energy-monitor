@component('components.panel', ['title' => __('IP configuration')])

    @if(session('set-ip-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('set-ip-error')['message'])}}</h5>
        </div>
    @endif
    @if(session('set-ip-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('set-ip-success')['message'])}}</h5>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <b>{{__('Actual: ')}}</b>{{$config['type'] == 'static' ? 'static ip' : 'DHCP'}}
        </div>
    </div>

    <form action="{{route('settings.ip-address')}}" method="POST" role="form">
        @csrf

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="dhcp-checkbox" onchange="staticIp(false)" id="dhcp-checkbox">
                    {{__('DHCP')}}&nbsp;&nbsp;({{__('mac address:')}} {{__($mac_address)}})
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="static-checkbox" onchange="staticIp(true)" id="static-checkbox">
                    {{__('STATIC IP')}}
                </label>
            </div>
        </div>


        <div class="form-group" id="form-address-ip">
            <label for="address_ip">Address Ip</label>
            <input type="text" name="address_ip" id="address_ip" class="form-control" value="{{$config['type'] == 'static' ? $config['address_ip'] : ''}}">
        </div>
        <div class="form-group" id="form-net-mask">
            <label for="netmask">Met mask</label>
            <input type="text" name="netmask" id="netmask" class="form-control" value="{{$config['type'] == 'static' ? $config['netmask'] : ''}}">
        </div>
        <div class="form-group" id="form-gateway">
            <label for="gateway">Gateway</label>
            <input type="text" name="gateway" id="gateway" class="form-control" value="{{$config['type'] == 'static' ? $config['gateway'] : ''}}">
        </div>
        <div class="form-group" id="form-dns">
            <label for="dns">DNS</label>
            <input type="text" name="dns" id="dns" class="form-control" value="{{$config['type'] == 'static' ? $config['dns'] : ''}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Change config</button>
            </div>
        </div>
    </form>


@endcomponent