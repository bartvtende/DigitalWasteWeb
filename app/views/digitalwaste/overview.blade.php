@extends('digitalwaste.master')

@section('content')
    <div class="container">

        <h1>Uitkomst onderzoek Digital Waste</h1>

        @if (isset($results))

        <p class="emphasize">Er hebben al <b>{{ $results['amountOfParticipants'] }}</b> mensen deelgenomen aan dit onderzoek, bedankt!</b></p>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="text-info">Gemiddelde waardering</h3></div>
                    <div class="panel-body">
                        @if (isset($userResults))
                            <h3>{{ round($userResults['gem_rating'], 1) }} sterren</h3>
                            <br />
                            <small>Gemiddelde van alle deelnemers:</small>
                            <p>{{ round($results['gem_rating'], 1) }} sterren</p>
                        @else
                            <h3>{{ round($results['gem_rating'], 1) }} sterren</h3>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <?php
                    function formatBytes($size, $precision = 2) {
                        $base = log($size, 1024);
                        $suffixes = array('B', 'kB', 'MB', 'GB', 'TB');

                        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
                    }
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="text-info">Gemiddelde waardering</h3></div>
                    <div class="panel-body">
                        @if (isset($userResults))
                            <h3>{{ formatBytes($userResults['gem_bestandsgrootte']) }}</h3>
                            <br />
                            <small>Gemiddelde van alle deelnemers:</small>
                            <p>{{ formatBytes($results['gem_bestandsgrootte']) }}</p>
                        @else
                            <h3>{{ formatBytes($results['gem_bestandsgrootte']) }}</h3>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="text-info">Eerst geüploadde bestand</h3></div>
                    <div class="panel-body">
                        @if (isset($userResults))
                            <h3>{{ $userResults['eerst_geupload'] }}</h3>
                            <br />
                            <small>Eerste van alle deelnemers:</small>
                            <p>{{ $results['eerst_geupload'] }}</p>
                        @else
                            <h3>{{ $results['eerst_geupload'] }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="text-info">Verdeling per categorie</h3></div>
                    <div class="panel-body">
                        @if (isset($userResults))
                            <div id="piechart_single" style="width: 100%; height: 400px;"></div>
                            <br />
                            <small>Gemiddelde van alle deelnemers:</small>
                            <div id="piechart" style="width: 100%; height: 200px;"></div>
                        @else
                            <div id="piechart" style="width: 100%; height: 400px;"></div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="text-info">Waardering per categorie</h3></div>
                    <div class="panel-body">
                        @if (isset($userResults))
                        <div id="chart_div_single" style="width: 100%; height: 400px;"></div>
                        <br />
                        <small>Gemiddelde van alle deelnemers:</small>
                        <div id="chart_div" style="width: 100%; height: 200px;"></div>
                        @else
                        <div id="chart_div" style="width: 100%; height: 400px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <a href="{{ route('home') }}" class="btn btn-info btn-lg"><i class="fa fa-angle-left"></i> Terug naar de homepage</a>
        </div>
    </div>
    @else
        <h2>Er heeft nog niemand meegedaan, wil jij de eerste zijn?</h2>
        <br />
        <a href="{{ route('home') }}" class="btn btn-lg btn-info">Ga terug naar de homepage!</a>
    @endif
@endsection

@section('scripts')
    @if (isset($results))
    <?php
        $extensies = json_decode($results['verd_extensies']);
        $ratings = json_decode($results['verd_rating']);
        if (isset($userResults)) {
            $extensies_single = json_decode($userResults['verd_extensies']);
            $ratings_single = json_decode($userResults['verd_rating']);
        }
    ?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {

            var dataExtension = google.visualization.arrayToDataTable([
                ['Categorie bestand', 'Percentage'],
                ['Document',    <?= round($extensies->document, 2) ?>],
                ['Foto',        <?= round($extensies->image, 2) ?>],
                ['Video',       <?= round($extensies->video, 2) ?>]
            ]);

            var dataRating = google.visualization.arrayToDataTable([
                ['Categorie bestand', 'Waardering (in sterren)', { role: 'style' }],
                ['Document',    <?= round($ratings->document, 2) ?>, '#3366CC'],
                ['Foto',        <?= round($ratings->image, 2) ?>, '#3366CC'],
                ['Video',       <?= round($ratings->video, 2) ?>, 'white']
            ]);

            var options = {
                'backgroundColor': '#4e5d6c',
                'legend': { textStyle: {color: 'white'} },
                'vAxis': { textStyle: {color: 'white'} },
                'hAxis': { textStyle: {color: 'white'} }
            };

            var chartExtension = new google.visualization.PieChart(document.getElementById('piechart'));
            var chartRating = new google.visualization.BarChart(document.getElementById('chart_div'));

            chartExtension.draw(dataExtension, options);
            chartRating.draw(dataRating, options);

            <?php
            if (isset($userResults)) {

                echo "var dataExtensionSingle = google.visualization.arrayToDataTable([";
                echo "['Categorie bestand', 'Percentage'],";
                echo "['Document', ". round($extensies_single->document, 2) ." ],";
                echo "['Foto', ". round($extensies_single->image, 2) ." ],";
                echo "['Video', ". round($extensies_single->video, 2) ." ]";
                echo "]);";

                echo "var dataRatingSingle = google.visualization.arrayToDataTable([";
                echo "['Categorie bestand', 'Percentage', {role: 'style'}],";
                echo "['Document', ". round($ratings_single->document, 2) ." , '#3366CC'],";
                echo "['Foto', ". round($ratings_single->image, 2) ." , '#3366CC'],";
                echo "['Video', ". round($ratings_single->video, 2) ." , 'white']";
                echo "]);";

                echo "var chartExtensionSingle = new google.visualization.PieChart(document.getElementById('piechart_single'));";
                echo "var chartRatingSingle = new google.visualization.BarChart(document.getElementById('chart_div_single'));";

                echo "chartExtensionSingle.draw(dataExtensionSingle, options);";
                echo "chartRatingSingle.draw(dataRatingSingle, options);";
            } ?>

        }
    </script>
    @endif
@endsection