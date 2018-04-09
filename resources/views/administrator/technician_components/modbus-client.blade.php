
@component('components.panel', ['title' => 'Modbus client', 'controller' => 'ModbusClientController'])

    @component('components.angular-messages')

    @endcomponent

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
                <label for="address_ip">Address Ip</label>
                <input type="text" name="address_ip" id="modbus_address_ip" class="form-control" ng-model="client.address_ip" placeholder="{{__('Put a valid IP V4 Address')}}">
                <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group" ng-class="messages.errors.port.length > 0 ? 'has-error' : ''">
                <label for="port">Port</label>
                <input type="number" min="0" max="65535" name="port" id="port" class="form-control" ng-model="client.port" placeholder="{{__('Put a valid TCP port')}}">
                <span class="help-block" ng-show="messages.errors.port.length > 0">[{messages.errors.port[0]}]</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group" ng-class="messages.errors.slave.length > 0 ? 'has-error' : ''">
                <label for="slave">Slave</label>
                <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" ng-model="client.slave" placeholder="{{__('Put a valid slave identifier')}}">
                <span class="help-block" ng-show="messages.errors.slave.length > 0">[{messages.errors.slave[0]}]</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group" ng-class="messages.errors.register.length > 0 ? 'has-error' : ''">
                <label for="register">Register</label>
                <input type="number" min="0" max="65535" name="register" id="register" class="form-control" ng-model="client.register" placeholder="{{__('Put a valid register')}}">
                <span class="help-block" ng-show="messages.errors.register.length > 0">[{messages.errors.register[0]}]</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" ng-class="messages.errors.length.length > 0 ? 'has-error' : ''">
                <label for="length">Length</label>
                <input type="number" min="1" max="50" name="length" id="length" class="form-control" ng-model="client.length" placeholder="{{__('Put a valid data length')}}">
                <span class="help-block" ng-show="messages.errors.length.length > 0">[{messages.errors.length[0]}]</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary pull-right" ng-click="execTest()">{{__('Read registers')}}</button>
        </div>
    </div>

    <div class="row" style="padding-right: 20px; padding-top: 20px;">
        <div class="col-md-1 [{register.class_name}]" ng-repeat="register in registers" style="padding-top: 5px">
            <div class="input-group input-xs">
                <span class="input-group-addon" style="padding: 6px 6px; min-width: 25px; font-size: 10px">[{register.index}]</span>
                <input type="text" class="form-control" disabled="disabled" id="register[{register.index}]" name="register[{register.index}]" ng-model="register.value" style="min-width: 60px; font-size: 12px">
            </div>
        </div>
    </div>
@endcomponent