<h1>{{$slot}}
    @isset($subtitle)
        <small>{{$subtitle}}</small>
    @endisset
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa {{ $icon or 'fa-home'}}"></i> {{ __('App') }}</a></li>
    @if(isset($parent) and is_array($parent) and array_key_exists('name',$parent) and array_key_exists('url',$parent))
    <li><a href="{{$parent['url']}}"> {{$parent['name']}}</a></li>
    @endif
    <li class="active">{{$slot}}</li>
</ol>