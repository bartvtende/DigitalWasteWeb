@foreach($data as $item)
	<b>Item</b>
	Path: {{ $item->path }}

	<hr>

	Rating: {{ round($item->rating, 2) }}, {{ $item->amount }} ratings 

	<hr>
@endforeach