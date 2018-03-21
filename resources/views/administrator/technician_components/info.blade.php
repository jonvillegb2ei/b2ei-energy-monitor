<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" style="max-width: 150px; height: auto" src="https://download.schneider-electric.com/files?p_Doc_Ref=PB110409&p_File_Type=rendition_288_png&default_image=DefaultProductImage.png" alt="Equipment picture">
        <h3 class="profile-username text-center">{{__($equipment->name)}}</h3>
        <p class="text-muted text-center">{{__($equipment->localisation)}}</p>
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item"><b>{{__('Product brand')}}</b> <a class="pull-right">{{__($equipment->product->brand)}}</a></li>
            <li class="list-group-item"><b>{{__('Product reference')}}</b> <a class="pull-right">{{__($equipment->product->reference)}}</a></li>
            <li class="list-group-item"><b>{{__('Address Ip')}}</b> <a class="pull-right">{{__($equipment->address_ip)}}':'{{__($equipment->port)}}</a></li>
            <li class="list-group-item"><b>{{__('Slave id')}}</b> <a class="pull-right">{{__($equipment->slave)}}</a></li>
            @foreach($equipment->widgetVariables as $variable)
                <li class="list-group-item"><b>{{__($variable->printable_name)}}</b> <a class="pull-right">{{__($variable->printable_value)}}</a></li>
            @endforeach
        </ul>
        <div class="row">
            <div class="col-md-12">
                @if(session('remove-error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>{{__(session('remove-error')['message'])}}</h5>
                    </div>
                @endif
                @if(session('remove-success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>{{__(session('remove-success')['message'])}}</h5>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <form action="{{route('technician.equipment.remove', ['equipment' => $equipment])}}" onsubmit="return confirm('{{__('Do you really want to remove this equipment and all data associated?')}}');">
                    @csrf
                    <button type="submit" class="btn btn-flat btn-danger" style="width: 100%">{{__('Remove this equipment*')}}</button>
                </form>
            </div>
            <div class="col-md-12 text-warning">
                {{__('*This action will remove equipment and all data associated.')}}
            </div>
        </div>
    </div>
</div>