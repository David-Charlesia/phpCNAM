<?php 
if(session_status()==PHP_SESSION_ACTIVE){
    session_start();
}


require_once("./model/Model.php");
require_once('./model/sparqllib.php');

if(isset($_SESSION['pseudo'])) {
    require('views/view_home.php');
} else {
    require('views/view_signin.php');
}



?>