<?php
    require_once "../../class.php";
    $db = new rickmortydb;
    $db->connect();
    if(isset($_POST['email']) && isset($_POST['password'])){
        try{
            $db->login($_POST['email'], $_POST['password']);
            echo json_encode(array(0, "Succes"));
        }
        catch (Exception $e){
            echo json_encode(array(1, $e->getMessage()));
        }
    }
    else
        echo json_encode(array(1, "Fields empty"));
?>