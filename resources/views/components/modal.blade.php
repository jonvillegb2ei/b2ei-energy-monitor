<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            @isset($header)
            {{$header}}
            @endisset
            @isset($title)
            <h4 class="modal-title">{{$title}}</h4>
            @endisset
        </div>
        <div class="modal-body">
            {{$slot}}
        </div>
        @isset($footer)
        <div class="modal-footer">
            {{$footer}}
        </div>
        @endisset
    </div>
</div>