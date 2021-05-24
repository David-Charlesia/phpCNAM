<!-- JS -->
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<?php 
    if(!isset($marker_js)){
        require_once('../model/Model.php');
        $bd = Model::getModel(); 

        $results = $bd->doRequestDefault();
        $marker_js = "";
        while( $row = sparql_fetch_array( $results ) ){
            $marker_js= $marker_js."L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=".addslashes($row['Spectacle']).">Lien</a>');";
    }
    }
?>

<script>
    //init map
    var mymap = L.map('mapid').setView([48.852569, 2.349903], 5);

    // load filters
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 5,
        maxZoom: 20
    }).addTo(mymap);

    //L.marker([48.852569, 2.349903]).addTo(mymap).bindPopup("<h1>Paris<h1>");

    <?= $marker_js ?>

</script>