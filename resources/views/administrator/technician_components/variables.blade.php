
@component('components.panel', ['title' => __('Variables'), 'overlay' => true, 'controller' => 'VariablesController', 'init' => 'init('.$equipment->id.')'])

    @component('components.angular-messages', ['loading' => false])

    @endcomponent


    @slot('tools')
        <button ng-click="load()" class="btn btn-info btn-sm" title="Refresh" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
    @endslot

    <table class="table">
        <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Value</th>
            <th>Unite</th>
            <th>Last update</th>
            <th>Log interval</th>
            <th>Log expiration</th>
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
                    <span class="input-group-addon input-sm">min</span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input class="form-control input-sm" ng-model="variable.log_expiration" type="number">
                    <span class="input-group-addon input-sm">min</span>
                </div>
            </td>
            <td>
                <button class="btn btn-primary btn-sm" ng-click="edit(variable)"><i class="fa fa-save"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
@endcomponent