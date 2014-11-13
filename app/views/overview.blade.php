@extends('layout.master')

@section('content')

@foreach($data as $item)
<div class="col-md-4">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Item {{ $item->id }}</h3>
		</div>

		<div class="panel-body">
			Path: {{ HTML::link(URL::route('overviewData', $item->id), $item->path) }}

			<hr>

			Rating: {{ round($item->rating, 2) }}, {{ $item->amount }} ratings 
		</div>
	</div>
</div>
@endforeach

@stop