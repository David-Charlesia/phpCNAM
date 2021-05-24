<!-- JS -->
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<?php 
    if(!isset($marker_js)){
        print ("heyyyyyyyyyyyyyyyyyyyyyyyyy");
        require_once('../model/Model.php');
        $bd = Model::getModel(); 

        $results = $bd->doRequestDefault();
        $marker_js = "";
        $temp = "";
        $tab=[];
        $tab_temp=[];
        while( $row = sparql_fetch_array( $results ) ){
            if($bd->my_in_array(array($row['Latitude'], $row['Longitude']),$tab_temp)){
                $pos = array_search(array($row['Latitude'], $row['Longitude']),$tab_temp);
                $tab[$pos] = $tab[$pos]."<li><div><h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=\'".addslashes($row['Spectacle'])."\'>Lien</a></div></li>";
            }else{
                array_push($tab, "L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<ul class=\"mypopup\"><li><div><h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=\'".addslashes($row['Spectacle'])."\'>Lien</a></div></li>");
                array_push($tab_temp, array($row['Latitude'], $row['Longitude']));
            }
            //$marker_js= $marker_js."L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=".addslashes($row['Spectacle']).">Lien</a>');";
            //</ul>);
        }

        foreach ($tab as $value) {
            $marker_js = $marker_js.$value."</ul>');";
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