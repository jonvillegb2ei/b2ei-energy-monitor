@component('components.panel', ['class' => 'box-primary', 'controller' => 'CreateUserController'])

    @component('components.angular-messages')

    @endcomponent


    @slot('title')
        {{trans('users.create.title')}}
    @endslot


    <div class="form-group" ng-class="messages.errors.firstname.length > 0 ? 'has-error' : ''">
        <label for="firstname">{{trans('users.create.firstname.name')}}</label>
        <input type="text" name="firstname" id="firstname" class="form-control" ng-model="data.firstname" placeholder="{{trans('users.create.firstname.help')}}">
        <span class="help-block" ng-show="messages.errors.firstname.length > 0">[{messages.errors.firstname[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.lastname.length > 0 ? 'has-error' : ''">
        <label for="lastname">{{trans('users.create.lastname.name')}}</label>
        <input type="text" name="lastname" id="lastname" class="form-control" ng-model="data.lastname" placeholder="{{trans('users.create.lastname.help')}}">
        <span class="help-block" ng-show="messages.errors.lastname.length > 0">[{messages.errors.lastname[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.email.length > 0 ? 'has-error' : ''">
        <label for="email">{{trans('users.create.email.name')}}</label>
        <input type="text" name="email" id="email" class="form-control" ng-model="data.email" placeholder="{{trans('users.create.email.help')}}">
        <span class="help-block" ng-show="messages.errors.email.length > 0">[{messages.errors.email[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.password.length > 0 ? 'has-error' : ''">
        <label for="password">{{trans('users.create.password.name')}}</label>
        <input type="password" name="password" id="password" class="form-control" ng-model="data.password" placeholder="{{trans('users.create.password.help')}}">
        <span class="help-block" ng-show="messages.errors.password.length > 0">[{messages.errors.password[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.password_confirmation.length > 0 ? 'has-error' : ''">
        <label for="password_confirmation">{{trans('users.create.password-confirmation.name')}}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" ng-model="data.password_confirmation" placeholder="{{trans('users.create.password-confirmation.help')}}">
        <span class="help-block" ng-show="messages.errors.password_confirmation.length > 0">[{messages.errors.password_confirmation[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.administrator.length > 0 ? 'has-error' : ''" title="{{trans('users.create.administrator.help')}}">
        <label for="administrator">{{trans('users.create.administrator.name')}}</label>
        <input type="checkbox" name="administrator" id="administrator" class="pull-right" ng-model="data.administrator" ng-true-value="1" ng-false-value="0">
        <span class="help-block" ng-show="messages.errors.administrator.length > 0">[{messages.errors.administrator[0]}]</span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary pull-right" ng-click="create()">{{trans('users.create.button')}}</button>
        </div>
    </div>

@endcomponent