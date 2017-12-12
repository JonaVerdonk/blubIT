<?php
    if(isset($_POST['sql'])) {
        $sql = $_POST["sql"];

        include($_SERVER["DOCUMENT_ROOT"]."scripts/databaseConnection.php");
        $result = executeSQL($sql, 2);

        echo json_encode($result);
    } else {
        echo "SQL not set";
    }
?>
