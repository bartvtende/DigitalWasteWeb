@extends('layout.master')

@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Item {{ $data->id }}</h3>
		</div>

		<div class="panel-body">
			Path: {{ $data->path }}

			{{ HTML::image('http://placehold.it/1024x600', null, ['class' => 'img-responsive img-rounded']) }}

			@for ($i=1; $i <= 5 ; $i++)
		      <span class="stars fa fa-star{{ (($i - 0.5) <= $data->rating) ? '' : '-o' }}"></span>
		    @endfor

		    - {{ round($data->rating, 1) }} sterren, {{ $data->amount }} beoordelingen
		</div>
	</div>
</div>
@stop