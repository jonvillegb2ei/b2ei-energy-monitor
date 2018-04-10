
@component('components.panel', ['title' => trans('technician.equipment-create.title'), 'controller' => 'EquipmentCreateController'])

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group" ng-class="messages.errors.product_id.length > 0 ? 'has-error' : ''">
        <label for="name">{{trans('technician.equipment-create.type.name')}}</label>
        <select name="product_id" id="product_id" class="form-control" ng-model="data.product_id" placeholder="{{trans('technician.equipment-create.type.help')}}">
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->brand}} - {{$product->reference}}</option>
            @endforeach
        </select>
        <span class="help-block" ng-show="messages.errors.product_id.length > 0">[{messages.errors.product_id[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.name.length > 0 ? 'has-error' : ''">
        <label for="name">{{trans('technician.equipment-create.name.name')}}</label>
        <input type="text" name="name" id="name" class="form-control" ng-model="data.name" placeholder="{{trans('technician.equipment-create.name.help')}}">
        <span class="help-block" ng-show="messages.errors.name.length > 0">[{messages.errors.name[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.address_ip.length > 0 ? 'has-error' : ''">
        <label for="address_ip">{{trans('technician.equipment-create.ip-address.name')}}</label>
        <input type="text" name="address_ip" id="address_ip" class="form-control" ng-model="data.address_ip" placeholder="{{trans('technician.equipment-create.ip-address.help')}}">
        <span class="help-block" ng-show="messages.errors.address_ip.length > 0">[{messages.errors.address_ip[0]}]</span>
    </div>
    <div class="form-group" ng-class="messages.errors.port.length > 0 ? 'has-error' : ''">
        <label for="port">{{trans('technician.equipment-create.port.name')}}</label>
        <input type="number" min="0" max="65535" name="port" id="port" class="form-control" ng-model="data.port" placeholder="{{trans('technician.equipment-create.port.help')}}">
        <span class="help-block" ng-show="messages.errors.port.length > 0">[{messages.errors.port[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.slave.length > 0 ? 'has-error' : ''">
        <label for="slave">{{trans('technician.equipment-create.slave.name')}}</label>
        <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" ng-model="data.slave" placeholder="{{trans('technician.equipment-create.slave.help')}}">
        <span class="help-block" ng-show="messages.errors.slave.length > 0">[{messages.errors.slave[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.localisation.length > 0 ? 'has-error' : ''">
        <label for="localisation">{{trans('technician.equipment-create.localisation.name')}}</label>
        <input type="text" name="localisation" id="localisation" class="form-control" ng-model="data.localisation" placeholder="{{trans('technician.equipment-create.localisation.help')}}">
        <span class="help-block" ng-show="messages.errors.localisation.length > 0">[{messages.errors.localisation[0]}]</span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button ng-click="create()" class="btn btn-primary pull-right">{{trans('technician.equipment-create.button')}}</button>
        </div>
    </div>

@endcomponent