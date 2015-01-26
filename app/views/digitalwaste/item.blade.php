@extends('digitalwaste.master')

@section('content')
    <div class="col-md-9 text-center">
        @if($file['category'] == 'document')
            <iframe src="https://docs.google.com/gview?url={{asset($file['write_path'])}}&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>
        @endif

        @if($file['category'] == 'image')
            <img src="{{asset($file['write_path'])}}" class="img-responsive"/>
        @endif

        @if($file['category'] == 'video')
            <video width="100%" height="500" controls>
                @if($file['extension'] == mp4)
                    <source src="{{asset($file['write_path'])}}" type="video/mp4">
                @elseif($file['extension'] == ogg)
                    <source src="{{asset($file['write_path'])}}" type="video/ogg">
                @else
                    <source src="{{asset($file['write_path'])}}" type="video/webm">
                @endif
                Your browser does not support the video tag.
            </video>
        @endif

        @if(is_null($file['category']))
            <h2>Dit bestand wordt helaas niet ondersteund, ga naar het volgende bestand.</h2>
        @endif

        <form method="post">
            <div class="form-group" action="{{ route('rate-dropbox', $file->user_id) }}">
                <div class="starrr" data-connected-input="rating"></div>
                <input type="hidden" name="rating" />

                <!-- Error message handling -->
                @if(isset($message))
                    <p>{{ $message }}</p>
                @endif
            </div>

            <br />

            <button class="btn btn-lg btn-info">Volgende <i class="fa fa-angle-right"></i> </button>
        </form>
    </div>

    <div class="col-md-3 right-panel">
        <h3 class="text-info">Bestandsnaam</h3>
        <p>{{ $file['filename'] }}</p>

        <h3 class="text-info">Extensie</h3>
        <p>{{ $file['extension'] }}</p>

        <h3 class="text-info">Bestandsgrootte</h3>
        <p>{{ $file['size'] }}</p>

        <h3 class="text-info">Maplocatie</h3>
        <p>{{ $file['folder'] }}</p>

        <h3 class="text-info">Type bestand</h3>
        <p>{{ $file['category'] }}</p>

        <h3 class="text-info">Aangemaakt op</h3>
        <p>{{ date("d-m-Y H:i", strtotime($file['created'])) }}</p>

        <h3 class="text-info">Laatst gewijzigd op</h3>
        <p>{{ date("d-m-Y H:i", strtotime($file['updated'])) }}</p>
    </div>
@endsection

@section('scripts')
    {{ HTML::script('https://code.jquery.com/jquery-1.11.1.min.js') }}
    {{ HTML::script('honours-digitalwaste/js/starrr.min.js') }}
@endsection