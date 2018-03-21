@component('components.panel', ['class' => 'box-primary'])

    @slot('title')
        {{__('Export data')}}
    @endslot

    <form role="form" action="{{route('equipment.export', ['equipment' => $equipment])}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputPassword1">{{__('Export period')}}</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" name="dateRange" type="text" id="exportDateRangePicker">
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">{{__('Element to export')}}</label>
            <select class="form-control" name="variables[]" multiple>
                @foreach($equipment->variables as $variable)
                    <option value="{{$variable->id}}">{{$variable->printable_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">{{__('Export')}}</button>
            </div>
        </div>
    </form>

@endcomponent