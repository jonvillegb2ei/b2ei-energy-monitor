
@component('components.panel', ['title' => __('Variables')])

    <table class="table">
        <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Value</th>
            <th>Unite</th>
            <th>Last update</th>
        </tr>
        @foreach($equipment->variables as $variable)
        <tr>
            <td>{{$variable->id}}.</td>
            <td>{{$variable->name}}</td>
            <td>{{$variable->value}}</td>
            <td>{{$variable->unite}}</td>
            <td>{{$variable->updated_since}}</td>
        </tr>
        @endforeach
        </tbody></table>
@endcomponent