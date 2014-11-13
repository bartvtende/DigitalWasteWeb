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

			{{ HTML::image('http://placehold.it/400x250', null, ['class' => 'img-responsive img-rounded']) }}

			
			@for ($i=1; $i <= 5 ; $i++)
		      <span class="stars fa fa-star{{ ($i <= $item->rating) ? '' : '-o' }}"></span>
		    @endfor

		    - {{ round($item->rating, 1) }} sterren, {{ $item->amount }} beoordelingen
		</div>
	</div>
</div>
@endforeach

@stop