@extends('layouts.app')

@section('header')

    @component('components.page-header')
        {{ __('Settings') }}
    @endcomponent

@endsection

@section('script')
    <?php $config = App\Libraries\SystemUtils::getConfig(); $isStatic = $config['type'] == 'static'; ?>
    <script>
        function staticIp(value) {
            if (value) {
                window.$('#form-address-ip').show();
                window.$('#form-net-mask').show();
                window.$('#form-gateway').show();
                window.$('#form-dns').show();
                window.$('#static-checkbox').prop('checked', true);
                window.$('#dhcp-checkbox').prop('checked', false);
            } else {
                window.$('#form-address-ip').hide();
                window.$('#form-net-mask').hide();
                window.$('#form-gateway').hide();
                window.$('#form-dns').hide();
                window.$('#static-checkbox').prop('checked', false);
                window.$('#dhcp-checkbox').prop('checked', true);
            }
        }
        $(function() {
            @if($isStatic)
                staticIp(true);
            @else
                staticIp(false);
            @endif
        });
    </script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            @include('administrator.settings_components.ip-config')
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    @include('administrator.settings_components.system')
                </div>
                <div class="col-md-12">
                    @include('administrator.settings_components.backup')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('administrator.settings_components.logs')
    </div>

@endsection