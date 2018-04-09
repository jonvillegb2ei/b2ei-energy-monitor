<div class="row">
    <div class="col-md-12">
        @if(!isset($loading) or $loading)
        <div class="alert alert-info" ng-show="messages.loading" ng-cloak>
            <h5><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;{{trans('app.loading')}}</h5>
        </div>
        @endif
        <div class="alert alert-danger" ng-show="messages.error.length > 0" ng-cloak>
            <h5>[{messages.error}]</h5>
            <small style="max-height: 150px; overflow-y: scroll; white-space: pre" ng-show="messages.detail.length > 0">[{messages.detail}]</small>
        </div>
        <div class="alert alert-success" ng-show="messages.success.length > 0" ng-cloak>
            <h5>[{messages.success}]</h5>
            <small style="max-height: 150px; overflow-y: scroll; white-space: pre" ng-show="messages.detail.length > 0">[{messages.detail}]</small>
        </div>
    </div>
</div>