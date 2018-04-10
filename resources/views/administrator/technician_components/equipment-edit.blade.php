
@component('components.panel', ['title' => trans('technician.equipment-edit.title'), 'controller' => 'EquipmentEditController', 'init' => 'init('.$equipment->id.')'])

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group" ng-class="messages.errors.name.length > 0 ? 'has-error' : ''">
        <label for="name">{{trans('technician.equipment-edit.name.name')}}</label>
        <input type="text" name="name" id="name" class="form-control" ng-model="data.name" placeholder="{{trans('technician.equipment-edit.name.help')}}">
        <span class="help-block" ng-show="messages.errors.name.length > 0">[{messages.errors.name[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
        <label for="address_ip">{{trans('technician.equipment-edit.ip-address.name')}}</label>
        <input type="text" name="address_ip" id="address_ip" class="form-control" ng-model="data.address_ip" placeholder="{{trans('technician.equipment-edit.ip-address.help')}}">
        <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.port.length > 0 ? 'has-error' : ''">
        <label for="port">{{trans('technician.equipment-edit.port.name')}}</label>
        <input type="number" min="0" max="65535" name="port" id="port" class="form-control" ng-model="data.port" placeholder="{{trans('technician.equipment-edit.port.help')}}">
        <span class="help-block" ng-show="messages.errors.port.length > 0">[{messages.errors.port[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.slave.length > 0 ? 'has-error' : ''">
        <label for="slave">{{trans('technician.equipment-edit.slave.name')}}</label>
        <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" ng-model="data.slave" placeholder="{{trans('technician.equipment-edit.slave.help')}}">
        <span class="help-block" ng-show="messages.errors.slave.length > 0">[{messages.errors.slave[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.localisation.length > 0 ? 'has-error' : ''">
        <label for="localisation">{{trans('technician.equipment-edit.localisation.name')}}</label>
        <input type="text" name="localisation" id="localisation" class="form-control" ng-model="data.localisation" placeholder="{{trans('technician.equipment-edit.localisation.help')}}">
        <span class="help-block" ng-show="messages.errors.localisation.length > 0">[{messages.errors.localisation[0]}]</span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button ng-click="edit()" class="btn btn-primary pull-right">{{trans('technician.equipment-edit.button')}}</button>
        </div>
    </div>


@endcomponent