<html>
<head>
</head>

<body>

<?php
require_once("db-config.php");

try {
	$db = new PDO('mysql:host=localhost;dbname=' . $dbname . ';charset=utf8', $username, $pw);
  } catch (PDOException $e) {
    print "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  
	try {
		echo 'running query:<br/>SELECT * FROM users<br/>';
		echo '<br/>Results:<br/>';
		foreach($db->query('SELECT * FROM users') as $row) {
			echo $row['name'] . '<br/>';
		}
		
		echo '<br/><br/>';
		echo 'running query with bindValue:<br/>SELECT * FROM users WHERE name=?<br/>name = test1<br/>';
		$stmt = $db->prepare("SELECT * FROM users WHERE name=?");
		$stmt->bindValue(1, 'test2');
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo '<br/>Results:<br/>';
		foreach ($rows as $row) {
			echo $row['name'] . '<br/>';
		}
	} catch(PDOException $ex) {
		echo "An Error occured!"; //user friendly message
		some_logging_function($ex->getMessage());
	}
?>

</body>

</html>