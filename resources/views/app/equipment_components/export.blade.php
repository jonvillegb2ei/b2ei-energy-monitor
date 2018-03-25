@component('components.panel', ['class' => 'box-primary', 'controller' => 'ExportController', 'init' =>'init('.$equipment->id.')'])

    @slot('title')
        {{__('Export data')}}
    @endslot

    @component('components.angular-messages')

    @endcomponent

    <div class="form-group">
        <label for="export_date_rage_picker">{{__('Export period')}}</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input date-range-picker class="form-control date-picker" type="text" ng-model="data.date" id="export_date_rage_picker">
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">{{__('Element to export')}}</label>
        <select class="form-control" ng-model="data.variables" multiple>
            @foreach($equipment->variables as $variable)
                <option value="{{$variable->id}}">{{$variable->printable_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button ng-click="export()" class="btn btn-primary pull-right">{{__('Export')}}</button>
        </div>
    </div>

@endcomponent