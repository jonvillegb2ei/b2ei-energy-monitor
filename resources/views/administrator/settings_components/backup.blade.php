
@component('components.panel', ['title' => __('Backup')])
    <div class="row">
        <div class="col-md-12">
            <button style="width: 100%" class="btn btn-primary">{{__('Create and download a backup.*')}}</button>
            <span class="text-warning pull-right">{{__('*It can take a while.')}}</span>
        </div>
    </div>
@endcomponent