@component('components.panel', ['class' => 'box-primary', 'controller' => 'CreateUserController'])

    @component('components.angular-messages')

    @endcomponent


    @slot('title')
        {{__('Add an user')}}
    @endslot


    <div class="form-group" ng-class="messages.errors.firstname.length > 0 ? 'has-error' : ''">
        <label for="firstname">{{__('Firstname')}}</label>
        <input type="text" name="firstname" id="firstname" class="form-control" ng-model="data.firstname" placeholder="{{__('Put user first name')}}">
        <span class="help-block" ng-show="messages.errors.firstname.length > 0">[{messages.errors.firstname[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.lastname.length > 0 ? 'has-error' : ''">
        <label for="lastname">{{__('Lastname')}}</label>
        <input type="text" name="lastname" id="lastname" class="form-control" ng-model="data.lastname" placeholder="{{__('Put user last name')}}">
        <span class="help-block" ng-show="messages.errors.lastname.length > 0">[{messages.errors.lastname[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.email.length > 0 ? 'has-error' : ''">
        <label for="email">{{__('Email')}}</label>
        <input type="text" name="email" id="email" class="form-control" ng-model="data.email" placeholder="{{__('Put user email address')}}">
        <span class="help-block" ng-show="messages.errors.email.length > 0">[{messages.errors.email[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.password.length > 0 ? 'has-error' : ''">
        <label for="password">{{__('Password')}}</label>
        <input type="password" name="password" id="password" class="form-control" ng-model="data.password" placeholder="{{__('Put user password')}}">
        <span class="help-block" ng-show="messages.errors.password.length > 0">[{messages.errors.password[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.password_confirmation.length > 0 ? 'has-error' : ''">
        <label for="password_confirmation">{{__('Password confirmation')}}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" ng-model="data.password_confirmation" placeholder="{{__('Confirm user password')}}">
        <span class="help-block" ng-show="messages.errors.password_confirmation.length > 0">[{messages.errors.password_confirmation[0]}]</span>
    </div>

    <div class="form-group" ng-class="messages.errors.administrator.length > 0 ? 'has-error' : ''">
        <label for="administrator">{{__('Administrator')}}</label>
        <input type="checkbox" name="administrator" id="administrator" class="pull-right" ng-model="data.administrator" ng-true-value="1" ng-false-value="0">
        <span class="help-block" ng-show="messages.errors.administrator.length > 0">[{messages.errors.administrator[0]}]</span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary pull-right" ng-click="create()">{{__('Add user')}}</button>
        </div>
    </div>

@endcomponent