@extends('data.data')

@section('data')
{{--Loop not working due to webserver incompatability (dev server doesnt accept partial content request)--}}
<video width="320" height="240" autoplay="autoplay" loop="loop">
  <source src="{{ URL::asset($data->path)}}" type="video/mp4">
Your browser does not support the video tag.
</video>

@stop