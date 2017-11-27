<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109575524-1"></script>
<script>
  window.dataLayer = window.dataLayer || []; 
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-109575524-1');
</script>
    </head>
    <body>
        <?php
            $db ="mysql:host=localhost;dbname=blubit_nl_Meijerglasvezel;port=80";
            $user = "blubit_nl_Meijerglasvezel";
            $pass = "b3LKvr6HmaNK";
            
            try {
                $pdo = new PDO($db, $user, $pass);
		// set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully<br>";
            }catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage()."<br>";
            }

//            $sql = "CREATE TABLE TestTable (number int, name varchar(40), active boolean)";
//            try {
//                print("Executing SQL<br>");
//                $pdo->exec($sql);
//                print("Table created<br>");
//            } catch (Exception $ex) {
//                print("Creating table failed: " . $ex->getMessage()."<br>");
//            }
            
			if(isset($_GET['true'])){
				$sql = "DELETE FROM TestTable";
				$pdo->exec($sql);
				print("I WANT TO DIE<br>");
				unset($_GET['true']);
			}

			
            $sql = "INSERT INTO TestTable(number, name, active) VALUES(1, 'Jona', TRUE);";
            try{
                $pdo->exec($sql);
                print("Entry inserted<br>");
            } catch(PDOException $ex) {
                print("Insert failed: ".$ex->getMessage()."<br>");
            }
			
			$sql = $pdo->query('SELECT * FROM TestTable;')->fetchAll();
			$num = 0;
			foreach($sql as $row){
					echo "Number: " . $row['number'] . " Name: " . $row['name'] . " Is Active: " . $row['active'] . "<br/>";
					$num++;
			}
			echo "Total rows: " . $num;
			
/*
			$result = $db->prepare("");
			$result->execute();
			
			while ($row = $db->fetchAll(PDO::FETCH_ASSOC)){
				echo "Number: " . $row['number'] . " Name: " . $row['name'] . " Is Active: " . $row['active'];
			}*/
			
            $pdo = NULL;
            print("Connection closed");
        ?>
		<form method="get">
			<input type="submit" value="delete table" name="true">
		</from>
    </body>
</html>
