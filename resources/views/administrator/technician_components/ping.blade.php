
@component('components.panel', ['title' => __('Ping device'), 'controller' => 'PingController'])

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
        <label for="address_ip">Address Ip</label>
        <input type="text" name="address_ip" id="address_ip" class="form-control" ng-model="data.address_ip" placeholder="{{__('Put a valid IP V4 Address')}}">
        <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button ng-click="ping()" class="btn btn-primary pull-right">{{__('Ping')}}</button>
        </div>
    </div>

@endcomponent