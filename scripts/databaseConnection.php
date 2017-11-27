<?php
    function makeConnection() {
        //Set databse information
        $db ="mysql:host=localhost;dbname=blubit_nl_Meijerglasvezel;port=80";
        $user = "blubit_nl_Meijerglasvezel";
        $pass = "b3LKvr6HmaNK";
        
        try {
            //Create new PDO object
            $pdo = new PDO($db, $user, $pass);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return($pdo);
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage()."<br>";
        }
    }
    
    function executeSQL($sql) {
        //Create a new PDO object
        $pdo = makeConnection();
        
        try {
            //Check if exec or execute has to be used
            //Exec only if there is nothing returned
            if (strpos($sql, "SELECT") !== false) {
                //Return all results in an array
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();
                return($result);
            } else {
                $pdo->exec($sql);
            }
        } catch(PDOException $e) {
            print("Query failed: " . $e->getMessage());
        }
        
        //Close connection
        $pdo = NULL;
    }
    
    function testFunction() {
        print("The file is succesfully added");
    }
?>