<?php
    $bd = Model::getModel();
    if(isset($_POST['sign'])){
        if(isset($_POST['sign']) == 'signin'){
            $bd->connect($_POST['pseudo'], $_POST['password']);
            require('../index.php');
        }
    }
?>