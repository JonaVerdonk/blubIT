<?php
    /*
        File made to handle ajax requests so you can execute queries from javascript
    */

    if(isset($_POST['sql'])) {
        $sql = $_POST["sql"];

        //Include the database connection file
        include($_SERVER["DOCUMENT_ROOT"]."scripts/databaseConnection.php");
        //Execute the query that was send in the ajax request
        $result = executeSQL($sql, 2);

        echo json_encode($result);
    } else {
        echo "SQL not set";
    }
?>
