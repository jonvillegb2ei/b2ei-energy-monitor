@component('components.panel', ['class' => 'box-primary'])
    @slot('title')
        {{__('Add an user')}}
    @endslot

    @if(session('create-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('create-error')['message'])}}</h5>
        </div>
    @endif
    @if(session('create-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('create-success')['message'])}}</h5>
        </div>
    @endif



    <form action="{{route('users.create')}}" method="POST" role="form">
        @csrf
        <div class="form-group">
            <label for="firstname">{{__('Firstname')}}</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="{{old('firstname')}}">
        </div>
        <div class="form-group">
            <label for="lastname">{{__('Lastname')}}</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="{{old('lastname')}}">
        </div>
        <div class="form-group">
            <label for="email">{{__('Email')}}</label>
            <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="password">{{__('Password')}}</label>
            <input type="password" name="password" id="password" class="form-control" value="">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{__('Password confirmation')}}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="">
        </div>
        <div class="form-group">
            <label for="administrator">{{__('Administrator')}}</label>
            <input type="checkbox" name="administrator" id="administrator" value="{{old('administrator')}}" style="padding-left: 10px">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Add user</button>
            </div>
        </div>
    </form>
@endcomponent