@extends('layout.master')

@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Item {{ $data->id }}</h3>
		</div>

		<div class="panel-body">
			Path: {{ $data->path }}

			<hr>

			Rating: {{ round($data->rating, 2) }}, {{ $data->amount }} ratings
		</div>
	</div>
</div>
@stop