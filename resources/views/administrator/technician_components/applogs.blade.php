@component('components.panel', ['title' => trans('technician.app-log'), 'controller' => 'AppLogsController'])


    @component('components.angular-messages')

    @endcomponent

    @slot('tools')
        <button ng-click="refresh()" class="btn btn-info btn-sm" title="Refresh" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
    @endslot

    <pre id="applogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">[{content}]</pre>
@endcomponent