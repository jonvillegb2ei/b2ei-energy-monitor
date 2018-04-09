
@component('components.panel', ['title' => trans('settings.backup.title')])
    <div class="row">
        <div class="col-md-12">
            <button style="width: 100%" class="btn btn-primary">{{trans('settings.backup.create-download')}}</button>
            <span class="text-warning pull-right">{{trans('settings.backup.take-a-while')}}</span>
        </div>
    </div>
@endcomponent