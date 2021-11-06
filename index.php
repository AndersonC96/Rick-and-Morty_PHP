<?php
	require_once "class.php";
	$db = new rickmortydb;
	$db->connect();
?>
<!DOCTYPE html>
<html>
    <?php
        include "components/modules/head.php";
    ?>
    <body class="bg-dark text-white">
        <?php
            if(isset($_COOKIE['user'])){
                include "components/modules/navbar.php";
                include "components/modules/portal.php";
                echo "<section class='container'>";
				include "components/modules/search_form.php";
				include "components/modules/characters.php";
                echo "</section>";
            }else{
                include "components/modules/logout.php";
            }
        ?>
    </body>
</html>