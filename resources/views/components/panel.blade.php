<div class="box {{$class or ''}}">
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
</div>