
@component('components.panel', ['title' => __('Update and system')])
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
            <b>{{__('System')}}</b>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.shutdown')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-default">{{__('Shutdown')}}</button>
            </form>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.reboot')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-default">{{__('Reboot')}}</button>
            </form>
        </div>
    </div>
    <div class="row" style="padding-top: 20px; padding-bottom: 10px">
        <div class="col-md-12" style="padding-bottom: 10px">
            <b>{{__('Application')}}</b>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.update')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-primary">{{__('Update application files')}}</button>
            </form>
        </div>
        <div class="col-md-6 text-center">
            <form action="{{route('settings.reset')}}" method="POST" role="form">
                @csrf
                <button type="submit" class="btn btn-warning">{{__('Reset to factory settings')}}</button>
            </form>
        </div>
    </div>
@endcomponent