@component('components.panel', ['title' => 'Application logs'])
    <pre id="applogs" style="width: 100%; max-height: 250px; overflow-y: scroll;">{{$applogs}}</pre>
@endcomponent