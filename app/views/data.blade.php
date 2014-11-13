{{ $data->path }}

<form action="{{ URL::route('rateData') }}" method="post">
<input type="text" name="rating">
<input type="hidden" name="id" value="{{ $data->id }}">
<input type="hidden" name="selectedId" value="{{ $selectedData->id }}">

<button type="submit">Verstuur</button>
</form>