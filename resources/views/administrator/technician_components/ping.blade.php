
@component('components.panel', ['title' => __('Ping tool')])
    @if(session('ping-error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('ping-error')['message'])}}</h5>
            <small style="max-height: 200px; overflow-y: scroll">{!!nl2br(e(session('ping-error')['output']))!!}</small>
        </div>
    @endif
    @if(session('ping-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5>{{__(session('ping-success')['message'])}}</h5>
            <small style="max-height: 200px; overflow-y: scroll">{!!nl2br(e(session('ping-success')['output']))!!}</small>
        </div>
    @endif
    <form action="{{route('technician.ping')}}" method="POST" role="form">
        @csrf
        <div class="form-group">
            <label for="ping_address_ip">Address Ip</label>
            <input type="text" name="address_ip" id="ping_address_ip" class="form-control" value="{{old('address_ip')}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">Ping</button>
            </div>
        </div>
    </form>
@endcomponent