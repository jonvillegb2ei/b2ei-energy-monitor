
@component('components.panel', ['title' => trans('settings.system.title')])
    @if(session('system-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('system-error')['message'])}}</h5>
        </div>
    @endif
    @if(session('system-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('system-success')['message'])}}</h5>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12" style="padding-bottom: 10px">
            <b>{{__('System')}}</b>&nbsp;({{trans('settings.free-disk-space')}}: {{ round(disk_free_space("/") / (1024 * 1024 * 1024),2) }} Go / {{ round(disk_total_space("/") / (1024 * 1024 * 1024),2) }} Go)
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.shutdown')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-default">{{trans('settings.system.shutdown')}}</button>
            </form>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.reboot')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-default">{{trans('settings.system.reboot')}}</button>
            </form>
        </div>
    </div>
    <div class="row" style="padding-top: 20px; padding-bottom: 10px">
        <div class="col-md-12" style="padding-bottom: 10px">
            <b>{{trans('settings.system.application')}}</b>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.update')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-primary">{{trans('settings.system.update')}}</button>
            </form>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.reset')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-warning">{{trans('settings.system.reset')}}</button>
            </form>
        </div>
    </div>
@endcomponent