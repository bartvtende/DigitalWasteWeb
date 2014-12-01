@extends('data.data')

@section('data')

{{ HTML::image($data->path, $data->path,array('style' => 'width:100%;')) }}

@stop