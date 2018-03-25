@component('components.modal', ['title' => __('Chart parameters')])


    <div class="form-group">
        <label for="export_date_rage_picker">{{__('Chart period')}}</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input date-range-picker class="form-control date-picker" type="text" ng-model="chart.date" id="export_date_rage_picker">
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">{{__('Element to display')}}</label>
        <select class="form-control" ng-model="chart.variables" multiple>
            @foreach($equipment->variables as $variable)
                <option value="{{$variable->id}}">{{$variable->printable_name}}</option>
            @endforeach
        </select>
    </div>

    @slot('footer')
        <button class="btn btn-default pull-left" ng-click="cancel()">{{__('Cancel')}}</button>
        <button class="btn btn-primary pull-right" ng-click="validate()">{{__('Load')}}</button>
    @endslot

@endcomponent