@component('components.panel', ['class' => 'box-primary', 'body_class' => 'no-padding', 'controller' => 'TableUserController', 'init' => 'load()', 'overlay' => true])

    <div style="padding-right: 15px; padding-left: 15px">
        @component('components.angular-messages', ['loading' => false])
        @endcomponent
    </div>

    @slot('tools')
        <button ng-click="load()" class="btn btn-info btn-sm" title="{{trans('app.refresh')}}" data-original-title="{{trans('app.refresh')}}"><i class="fa fa-refresh"></i></button>
    @endslot

    @slot('title')
        {{trans('users.table.title')}}
    @endslot

    <table class="table table-striped">
        <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>{{trans('users.table.firstname')}}</th>
                <th>{{trans('users.table.lastname')}}</th>
                <th>{{trans('users.table.email')}}</th>
                <th>{{trans('users.table.administrator')}}</th>
                <th>&nbsp;</th>
            </tr>
            <tr ng-repeat="user in users">
                <td>[{user.id}].</td>
                <td>[{user.firstname}]</td>
                <td>[{user.lastname}]</td>
                <td>[{user.email}]</td>
                <td>[{user.administrator ? 'YES' : 'NO'}]&nbsp;
                    <a ng-if="{{\Illuminate\Support\Facades\Auth::user()->id}} !== user.id" href="#" ng-click="changeAdministrator(user)">{{trans('users.table.change')}}</a>
                </td>
                <td>
                    <button ng-if="{{\Illuminate\Support\Facades\Auth::user()->id}} !== user.id" ng-click="remove(user)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>&nbsp;{{trans('users.table.remove')}}</button>
                </td>
            </tr>
        </tbody>
    </table>
@endcomponent