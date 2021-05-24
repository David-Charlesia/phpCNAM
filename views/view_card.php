<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title> PHP CNAM</title>
		
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
        <link rel="stylesheet" href="../contents/css/view_card.css"/>
        <link rel="stylesheet" href="../contents/css/map.css"/>
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="" >Carte</a></li>
			</ul>
		</nav>

		<header>
			<h1><a href="../index.php"> PHP CNAM </a></h1>
            <h2>Site de recherche de spectacle</h2>
		</header>

		<main>
            <div id="mapid">


            </div>
            <?php require('./map.php'); ?>
        </main>
    </body>