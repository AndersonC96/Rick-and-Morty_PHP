<?php
    require_once "../../class.php";
    $db = new rickmortydb;
    $db->connect();
    if(isset($_POST['rate']) && isset($_POST['character_id'])){
        try{
            $db->rate_character($_COOKIE['user'], $_POST['character_id'], $_POST['rate']);
            echo json_encode(true);
        }
        catch (Exception $e){
            echo json_encode($e->getMessage());
        }
    }
    else
        echo json_encode("Fields are empty");
?>