
@component('components.panel', ['title' => 'System logs', 'controller' => 'SysLogsController'])

    @component('components.angular-messages')

    @endcomponent

    @slot('tools')
        <button ng-click="refresh()" class="btn btn-info btn-sm" title="Refresh" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
    @endslot

    <div class="row">
        <div class="col-md-12">
            <pre id="syslogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">[{syslogs}]</pre>
        </div>
        <div class="col-md-12">
            <pre id="dmesg" style="width: 100%; max-height: 250px; overflow-y: scroll;">[{dmesg}]</pre>
        </div>
    </div>
@endcomponent
