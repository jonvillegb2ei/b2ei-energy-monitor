<div class="box {{$class or ''}}" @isset($controller)ng-controller="{{$controller}}"@endisset @isset($init)ng-init="{{$init}}"@endisset ng-cloak>
    <div class="box-header {{$header_class or 'with-border'}}">
        @isset($title)
        <h3 class="box-title">{{$title}}</h3>
        @endisset
        @isset($tools)
        <div class="box-tools pull-right">{{$tools}}</div>
        @endisset
    </div>
    <div class="box-body {{$body_class or ''}}">
        {{$slot}}
    </div>
    @isset($overlay)
    @if($overlay)
    <div class="overlay" ng-if="messages.loading">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    @endif
    @endisset
</div>