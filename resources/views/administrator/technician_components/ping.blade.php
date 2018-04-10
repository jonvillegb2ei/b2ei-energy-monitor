
@component('components.panel', ['title' => trans('technician.ping.title'), 'controller' => 'PingController'])

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
        <label for="address_ip">{{trans('technician.ping.ip-address.name')}}</label>
        <input type="text" name="address_ip" id="address_ip" class="form-control" ng-model="data.address_ip" placeholder="{{trans('technician.ping.ip-address.help')}}">
        <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button ng-click="ping()" class="btn btn-primary pull-right">{{trans('technician.ping.button')}}</button>
        </div>
    </div>

@endcomponent