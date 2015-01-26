@extends('digitalwaste.master')

@section('content')
<div class="container">
    <h1>Digital Waste</h1>

    <p class="emphasize">Er is veel "loze data" op internet, data die niet meer gebruikt wordt. Dropbox is een bron waar veel van deze loze data wordt opgeslagen. Met dit onderzoek willen wij in kaart brengen of je Dropbox gegevens nog waarde hebben.</p>

    @if (Session::has('message'))
    <div class="alert alert-dismissable alert-info col-md-6 col-md-offset-3">
        {{ Session::get('message') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-4 col-md-offset-1">
            <p class="text-info emphasize"><strong>Wilt u meedoen met het onderzoek?</strong></p>

            <i class="fa fa-dropbox fa-5x icon"></i>

            <p>Log simpelweg in met uw Dropbox account. Wij doorzoeken een fractie van jou gegevens en pakken daar een aantal bestanden uit. Deze bestanden schotelen wij aan jou voor, waarna jij een hier een waarde van 1 t/m 5 aan geeft. Uiteindelijk krijg jij een persoonlijk overzicht van de uitkomst van het onderzoek, die je kunt vergelijken met de andere deelnemers.</p>

            <a href="{{ route('auth-dropbox') }}" class="btn btn-lg btn-info">Doe mee*!</a>

            <p><small>* Alle gegevens, behalve de resultaten van het onderzoek, worden direct na het onderzoek verwijderd. De toestemming die je via Dropbox aan ons hebt toegekend wordt niet door ons opgeslagen.</small></p>
        </div>

        <div class="col-md-4 col-md-offset-1">
            <p class="text-info emphasize"><strong>Bekijk de tussenstand!</strong></p>

            <i class="fa fa-pie-chart fa-5x icon"></i>

            <p>Uit de resultaten van het onderzoek halen wij een aantal interessante gegevens, zoals de gemiddelde waardering die aan de gegevens worden gegeven. Met deze gegevens willen wij je inzicht geven of de data die jij opslaat wel degelijk relevant voor jou is. Bekijk de resultaten door op de onderstaande knop te klikken!</p>

            <a href="{{ route('overview-dropbox') }}" class="btn btn-lg btn-info">Resultaten!</a>

        </div>
    </div>

    <hr />

    <div class="row">
        <h4 style="padding-bottom:15px">Bekijk de code op <a href="https://github.com/bartvtende/DigitalWasteWeb">GitHub</a>!</h4>
    </div>
</div>
</body>
</html>
@endsection