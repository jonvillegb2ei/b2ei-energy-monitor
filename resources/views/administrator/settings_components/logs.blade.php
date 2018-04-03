
<div class="col-md-12">
    @component('components.panel', ['title' => 'Application logs'])
        <pre id="applogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">{{$applogs}}</pre>
    @endcomponent
</div>
<div class="col-md-12">
    @component('components.panel', ['title' => 'System logs'])
        <div class="row">
            <div class="col-md-6">
                <pre id="syslogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">{{$syslogs}}</pre>
            </div>
            <div class="col-md-6">
                <pre id="syslogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">{{$dmesg}}</pre>
            </div>
        </div>
    @endcomponent
</div>