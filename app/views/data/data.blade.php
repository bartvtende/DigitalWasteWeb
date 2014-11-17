@extends('...layout.master')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Item {{ $data->id }}</h3>
		</div>

		<div class="panel-body"> 
			<div>
			@yield('data')
			</div>

			<form action="{{ URL::route('rateData') }}" method="post">
			<input type="text" class="form-control" name="rating">
			<input type="hidden" name="id" value="{{ $data->id }}">
			<input type="hidden" name="selectedId" value="{{ $selectedData->id }}">

			<button class="btn btn-primary" type="submit">Verstuur</button>
			</form>
		</div>
	</div>
</div>
@stop