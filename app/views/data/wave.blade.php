@extends('data.data')

@section('data')

<audio controls autoplay>
   <source src="{{ URL::asset($data->path)}}" type="audio/wav">
   Your browser does not support the audio element.
</audio>

@stop