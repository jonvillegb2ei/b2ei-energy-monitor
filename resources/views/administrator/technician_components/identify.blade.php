@component('components.panel', ['title' => trans('technician.identify.title'), 'controller' => 'IdentifyController'])

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
        <label for="address_ip">{{trans('technician.identify.ip-address.name')}}</label>
        <input type="text" name="address_ip" id="address_ip" class="form-control" ng-model="data.address_ip" placeholder="{{__('Put a valid IP V4 Address')}}">
        <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.port.length > 0 ? 'has-error' : ''">
        <label for="port">{{trans('technician.identify.port.name')}}</label>
        <input type="number" min="0" max="65535" name="port" id="port" class="form-control" ng-model="data.port" placeholder="{{trans('technician.identify.port.help')}}">
        <span class="help-block" ng-show="messages.errors.port.length > 0">[{messages.errors.port[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.slave.length > 0 ? 'has-error' : ''">
        <label for="slave">{{trans('technician.identify.slave.name')}}</label>
        <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" ng-model="data.slave" placeholder="{{trans('technician.identify.slave.help')}}">
        <span class="help-block" ng-show="messages.errors.slave.length > 0">[{messages.errors.slave[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.mei_type.length > 0 ? 'has-error' : ''">
        <label for="mei_type">{{trans('technician.identify.mei-type.name')}}</label>
        <input type="number" min="0" max="255" name="mei_type" id="mei_type" class="form-control" ng-model="data.mei_type" placeholder="{{trans('technician.identify.mei-type.help')}}">
        <span class="help-block" ng-show="messages.errors.mei_type.length > 0">[{messages.errors.mei_type[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.device_id.length > 0 ? 'has-error' : ''">
        <label for="device_id">{{trans('technician.identify.device-id.name')}}</label>
        <input type="number" min="0" max="255" name="device_id" id="device_id" class="form-control" ng-model="data.device_id" placeholder="{{trans('technician.identify.device-id.help')}}">
        <span class="help-block" ng-show="messages.errors.device_id.length > 0">[{messages.errors.device_id[0]}]</span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button ng-click="identify()" class="btn btn-primary pull-right">{{trans('technician.identify.button')}}</button>
        </div>
    </div>

@endcomponent