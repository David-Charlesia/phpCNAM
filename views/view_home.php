<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>Connexion/Créer son compte</title>
		<link rel="stylesheet" href="./contents/css/phpcnam.css"/>
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="./views/view_search.php" >Page de recherche</a></li>
				<li><a href="./views/view_card.php" >Carte</a></li>
				<li><a href="./views/view_signin.html">Se connecter/Créer un compte</a></li>
			</ul>
		</nav>

		<header>
			<h1><a href="?"> PHP CNAM </a></h1>
            <h2>Site de recherche de spectacle</h2>
			<p>Bienvenue <?= $_SESSION['pseudo']?></p>
		</header>

		<main>

        <form action="./views/view_results.php">

            <input type="text" placeholder="ville" name="city" id="ville"/>
            <button type="submit" value="Chercher">
                <img src="./contents/img/search_icon.png" width="2em" height="2em" alt="Chercher"/>
            </button>

        </form>


        </main>
</body>
</html>