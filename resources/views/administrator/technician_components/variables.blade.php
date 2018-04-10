
@component('components.panel', ['title' => trans('technician.variable.title'), 'overlay' => true, 'controller' => 'VariablesController', 'init' => 'init('.$equipment->id.')'])

    @component('components.angular-messages', ['loading' => false])

    @endcomponent

    @slot('tools')
        <button ng-click="load()" class="btn btn-info btn-sm" title="{{trans('app.refresh')}}" data-original-title="{{trans('app.refresh')}}"><i class="fa fa-refresh"></i></button>
    @endslot

    <table class="table">
        <tbody><tr>
            <th style="width: 10px">{{trans('technician.variable.id')}}</th>
            <th>{{trans('technician.variable.name')}}</th>
            <th>{{trans('technician.variable.value')}}</th>
            <th>{{trans('technician.variable.unit')}}</th>
            <th>{{trans('technician.variable.last-update')}}</th>
            <th>{{trans('technician.variable.Log-interval')}}</th>
            <th>{{trans('technician.variable.Log-expiration')}}</th>
        </tr>
        <tr ng-repeat="variable in variables">
            <td>[{variable.id}].</td>
            <td>[{variable.name}]</td>
            <td>[{variable.value}]</td>
            <td>[{variable.unit}]</td>
            <td>[{variable.updated_since}]</td>
            <td>
                <div class="input-group">
                    <input class="form-control input-sm" ng-model="variable.log_interval" type="number">
                    <span class="input-group-addon input-sm">{{trans('technician.variable.minute')}}</span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input class="form-control input-sm" ng-model="variable.log_expiration" type="number">
                    <span class="input-group-addon input-sm">{{trans('technician.variable.minute')}}</span>
                </div>
            </td>
            <td>
                <button class="btn btn-primary btn-sm" ng-click="edit(variable)" title="{{trans('technician.variable.title')}}"><i class="fa fa-save"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
@endcomponent