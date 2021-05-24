<?php 
require_once("../model/sparqllib.php");
require_once("../model/Model.php");

$bd = Model::getModel();
if(isset($_GET['city']) /*&& $bd->verify_city($_GET['city'])*/){
    $city = $_GET['city'];
    $results = $bd->doRequest($city);
}else{
   $results = $bd->doRequestDefault();
}

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title> PHP CNAM</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
		<link rel="stylesheet" href="../contents/css/results.css"/>
      <link rel="stylesheet" href="../contents/css/map.css"/>
	</head>
	<body>
		<nav>
			<ul>
				
			</ul>
		</nav>
        
        <main>
         
        <?php 
        $fields = sparql_field_array( $results );
          
        print "<p>Number of rows: ".sparql_num_rows( $results )." results.</p>";
        print "<table>";
        print "<tr>";
        foreach( $fields as $field )
        {
           print "<th>$field</th>";
        }
        print "</tr>";


        $marker_js = "";
        $temp = "";
        $tab=[];
        $tab_temp=[];

        while( $row = sparql_fetch_array( $results ) ){
            //$row['Titre']='tesssssssssssst';
           // $marker_js= $marker_js."L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".$row['Nom_Lieu']."</h3><h3>Date : ".$row['Date']."</h3><a href=".$row['Spectacle'].">Lien</a>');";

           print"<tr>";
           print "<td><a href=".$row['Spectacle'].">Lien</a></td>";
           print "<td>".$row['Titre']."</td>";
           print "<td>".$row['Date']."</td>";
           print "<td>".$row['focus']."</td>";
           print "<td>".$row['Nom_Lieu']."</td>";
           print"</tr>";

           
            if($bd->my_in_array(array($row['Latitude'], $row['Longitude']),$tab_temp)){
                $pos = array_search(array($row['Latitude'], $row['Longitude']),$tab_temp);
                $tab[$pos] = $tab[$pos]."<li><div><h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=\'".addslashes($row['Spectacle'])."\'>Lien</a></div></li>";
            }else{
                array_push($tab, "L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<ul class=\"mypopup\"><li><div><h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=\'".addslashes($row['Spectacle'])."\'>Lien</a></div></li>");
                array_push($tab_temp, array($row['Latitude'], $row['Longitude']));
            }

        

           //$marker_js= $marker_js."L.marker([".$row['Latitude'].", ".$row['Longitude']."]).addTo(mymap).bindPopup('<h2>Titre : ".addslashes($row['Titre'])."</h2><h3>Lieu : ".addslashes($row['Nom_Lieu'])."</h3><h3>Date : ".addslashes($row['Date'])."</h3><a href=".addslashes($row['Spectacle']).">Lien</a>');";
        }
        print "</table>";

        foreach ($tab as $value) {
         $marker_js = $marker_js.$value."</ul>');";
     }

        ?>

        <div id="mapid">

      </div>

        <?php 
            require('./map.php');
        ?>
      </main>
   </body>
</html>