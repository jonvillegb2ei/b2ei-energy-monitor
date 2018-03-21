
@component('components.panel', ['title' => __('Add an equipment')])
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
    <form action="{{route('technician.equipment.add')}}" method="POST" role="form">
        @csrf
        <div class="form-group">
            <label for="name">{{__('Type')}}</label>
            <select name="product_id" id="product_id" class="form-control" value="{{old('name')}}">
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->brand}} - {{$product->reference}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">{{__('Name')}}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="address_ip">{{__('Address Ip')}}</label>
            <input type="text" name="address_ip" id="address_ip" class="form-control" value="{{old('address_ip')}}">
        </div>
        <div class="form-group">
            <label for="port">{{__('Port')}}</label>
            <input type="number" min="1" max="65535" name="port" id="port" class="form-control" value="{{old('port', 502)}}">
        </div>
        <div class="form-group">
            <label for="port">{{__('Slave')}}</label>
            <input type="number" min="0" max="255" name="slave" id="slave" class="form-control" value="{{old('slave', 1)}}">
        </div>
        <div class="form-group">
            <label for="localisation">{{__('Localisation')}}</label>
            <input type="text" name="localisation" id="localisation" class="form-control" value="{{old('localisation')}}">
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary pull-right">{{__('Create')}}</button>
            </div>
        </div>
    </form>
@endcomponent