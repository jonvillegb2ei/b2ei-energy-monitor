@component('components.panel', ['class' => 'box-primary', 'body_class' => 'no-padding'])
    @slot('title')
        {{__('User list')}}
    @endslot

    @if(session('table-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('table-error')['message'])}}</h5>
        </div>
    @endif
    @if(session('table-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('table-success')['message'])}}</h5>
        </div>
    @endif

    <table class="table table-striped">
        <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>{{__('Firstname')}}</th>
            <th>{{__('Lastname')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Administrator')}}</th>
            <th>&nbsp;</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}.</td>
                <td>{{$user->firstname}}</td>
                <td>{{$user->lastname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->administrator ? 'YES' : 'NO'}}&nbsp;
                    @if ($user->id != \Illuminate\Support\Facades\Auth::user()->id)
                    <a href="{{route('users.change-administrator', ['user' => $user])}}">{{__('Change')}}</a>
                    @endif
                </td>
                <td>
                    <form action="{{route('users.remove', ['user' => $user])}}" method="POST" role="form">
                        @csrf
                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>&nbsp;{{__('Remove')}}</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endcomponent