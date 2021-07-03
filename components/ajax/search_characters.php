<?php
    require_once "../../class.php";
    $db = new rickmortydb;
    $db->connect();
    if(isset($_POST['content']) && isset($_POST['status']) && isset($_POST['gender']))
        try{
            echo json_encode($db->search_character($_COOKIE['user'], $_POST['content'], $_POST['status'], $_POST['gender']));
        }
        catch (Exception $e){
            echo json_encode($e->getMessage());
        }
    else
        echo json_encode("Fields are empty");
?>