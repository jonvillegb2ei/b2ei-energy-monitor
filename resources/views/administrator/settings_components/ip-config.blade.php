@component('components.panel', ['title' => trans('settings.ip-config.title')])

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
            <b>{{trans('settings.ip-config.actual')}} : </b>{{$config['type'] == 'static' ? 'static ip' : 'DHCP'}}
        </div>
    </div>

    <form action="{{route('settings.ip-address')}}" method="POST" role="form">
        @csrf

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="dhcp-checkbox" onchange="staticIp(false)" id="dhcp-checkbox">
                    {{trans('settings.ip-config.dhcp')}}&nbsp;&nbsp;({{trans('settings.ip-config.mac-address')}} : {{__(strtoupper($mac_address))}})
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="static-checkbox" onchange="staticIp(true)" id="static-checkbox">
                    {{trans('settings.ip-config.static')}}
                </label>
            </div>
        </div>


        <div class="form-group" id="form-address-ip">
            <label for="address_ip">{{trans('settings.ip-config.ip-address.name')}}</label>
            <input type="text" name="address_ip" id="address_ip" class="form-control" placeholder="{{trans('settings.ip-config.ip-address.help')}}" value="{{$config['type'] == 'static' ? $config['address_ip'] : ''}}">
        </div>
        <div class="form-group" id="form-net-mask">
            <label for="netmask">{{trans('settings.ip-config.netmask.name')}}</label>
            <input type="text" name="netmask" id="netmask" class="form-control" placeholder="{{trans('settings.ip-config.netmask.help')}}" value="{{$config['type'] == 'static' ? $config['netmask'] : ''}}">
        </div>
        <div class="form-group" id="form-gateway">
            <label for="gateway">{{trans('settings.ip-config.gateway.name')}}</label>
            <input type="text" name="gateway" id="gateway" class="form-control" placeholder="{{trans('settings.ip-config.gateway.help')}}" value="{{$config['type'] == 'static' ? $config['gateway'] : ''}}">
        </div>
        <div class="form-group" id="form-dns">
            <label for="dns">{{trans('settings.ip-config.dns.name')}}</label>
            <input type="text" name="dns" id="dns" class="form-control" placeholder="{{trans('settings.ip-config.dns.help')}}" value="{{$config['type'] == 'static' ? $config['dns'] : ''}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">{{trans('settings.ip-config.button')}}</button>
            </div>
        </div>
    </form>


@endcomponent