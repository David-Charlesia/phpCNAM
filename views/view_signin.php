<?php
    $bd = Model::getModel();
    if(!isset($_SESSION['pseudo']) && isset($_GET['sign'])){
        if(isset($_GET['sign']) == 'signin'){
            $bd->connect($_POST['pseudo'], $_POST['password']);
            require('view_home.php');
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title> PHP CNAM</title>
		<link rel="stylesheet" href="./contents/css/phpcnam.css"/>
        <link rel="stylesheet" href="signin.css"/>
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="./views/view_search.php" >Page de recherche</a></li>
				<li><a href="./views/view_card.php" >Carte</a></li>
				<li><a href="./views/view_search.php">Se connecter/Créer un compte</a></li>
			</ul>
		</nav>

        <div id=forms>
            <div class="form">
                <h2>Connexion : </h2>
                <form action="?sign=signin" method="post">
                    <input type="text" placeholder="pseudo" name="pseudo"/>
                    <input type="password" placeholder="password" name="password"/>
                    <input type="submit" value="Connexion"/>
                </form>
            </div>

            <div class="form">
                <h2>Créer un compte : </h2>
                <form action="?sign=signup" method="post">
                    <input type="text" placeholder="pseudo" name="pseudo"/>
                    <input type="email" placeholder="email" name="email"/>
                    <input type="password" placeholder="mot de passe" name="password"/>
                    <input type="password" placeholder="retaper le mot de passe" name="password2"/>
                    <input type="submit" value="Créer un compte"/>
                </form>
            </div>
        </div>

    </body>
</html>