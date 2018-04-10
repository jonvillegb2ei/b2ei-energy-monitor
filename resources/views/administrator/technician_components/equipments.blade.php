
@component('components.panel', ['title' => 'Equipments', 'overlay' => true, 'body_class' => 'no-padding', 'controller' => 'EquipmentsController'])


    @slot('tools')
        <button ng-click="loading = true; load()" class="btn btn-info btn-sm" title="Refresh" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
    @endslot

    <div style="padding-right: 15px; padding-left: 15px">
        @component('components.angular-messages', ['loading' => false])
        @endcomponent
    </div>

    <table class="table">
        <tbody>
        <tr>
            <th style="width: 10px">{{trans('technician.table.id')}}</th>
            <th>{{trans('technician.table.name')}}</th>
            <th>{{trans('technician.table.localisation')}}</th>
            <th>{{trans('technician.table.brand')}}</th>
            <th>{{trans('technician.table.reference')}}</th>
            <th>{{trans('technician.table.ip-address')}}</th>
            <th>{{trans('technician.table.slave')}}</th>
            <th>&nbsp;</th>
        </tr>
            <tr ng-repeat="equipment in equipments">
                <td>[{equipment.id}].</td>
                <td>[{equipment.name}]</td>
                <td>[{equipment.localisation}]</td>
                <td>[{equipment.brand}]</td>
                <td>[{equipment.reference}]</td>
                <td>[{equipment.address_ip}]:[{equipment.port}]</td>
                <td>[{equipment.slave}]</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">{{trans('technician.table.action.title')}}</button>
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">{{trans('app.toggle-dropdown')}}</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" ng-click="ping(equipment.id)">{{trans('technician.table.action.ping')}}</a></li>
                            <li><a href="#" ng-click="test(equipment.id)">{{trans('technician.table.action.test')}}</a></li>
                            <li class="divider"></li>
                            <li><a href="#" ng-click="detail(equipment.id)">{{trans('technician.table.action.advanced')}}</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-12">
            <ul uib-pagination
                boundary-links="true" total-items="total"
                ng-model="page" style="padding-right: 15px"
                class="pagination-sm pull-right"
                previous-text="&lsaquo;" next-text="&rsaquo;"
                first-text="&laquo;" last-text="&raquo;"></ul>
        </div>
    </div>
@endcomponent