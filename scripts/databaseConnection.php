<<<<<<< HEAD
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

    function executeSQL($sql , $method = 0) {

        ///////////////////////////////////////////
        //$method = 0 => Both
        //$method = 1 => Assoc (Name)
        //$method = 2 => Numeral
        ////////////////////////////////////////////

        //Create a new PDO object
        $pdo = makeConnection();

        try {
            //Check if exec or execute has to be used
            //Exec only if there is nothing returned
            if (strpos($sql, "SELECT") !== false) {
                //Return all results in an array
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                switch($method){
                  case 0: $result = $stmt->fetchAll(); break;
                  case 1: $result = $stmt->fetchAll(PDO::FETCH_ASSOC); break;
                  case 2: $result = $stmt->fetchAll(PDO::FETCH_NUM); break;
                }

            } else {
                $pdo->exec($sql);
            }
        } catch(PDOException $e) {
            print("Query failed: " . $e->getMessage());
        }

        //Close connection
        $pdo = NULL;

        if (isset($result)) {
            return($result);
        }
    }

    function testFunction() {
        return("The file is succesfully added");
    }
?>
=======
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
            return "ERROR";
        }
    }

    function executeSQL($sql , $method = 0) {

        ///////////////////////////////////////////
        //$method = 0 => Both
        //$method = 1 => Assoc (Name)
        //$method = 2 => Numeral
        ////////////////////////////////////////////

        //Create a new PDO object
        $pdo = makeConnection();

        if($pdo == "ERROR"){
          return $pdo . " 1";
        }


        try {
            //Check if exec or execute has to be used
            //Exec only if there is nothing returned
            if (strpos($sql, "SELECT") !== false) {
                //Return all results in an array
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                switch($method){
                  case 0: $result = $stmt->fetchAll(); break;
                  case 1: $result = $stmt->fetchAll(PDO::FETCH_ASSOC); break;
                  case 2: $result = $stmt->fetchAll(PDO::FETCH_NUM); break;
                }

            } else {
                $pdo->exec($sql);
            }
        } catch(PDOException $e) {
            print("Query failed: " . $e->getMessage());
        }

        //Close connection
        $pdo = NULL;

        if (isset($result)) {
            return($result);
        }
    }

    function testFunction() {
        print("The file is succesfully added");
    }
?>
>>>>>>> 0fcebbf0dc4cf8f2754c387c41c0b374459b5db7
