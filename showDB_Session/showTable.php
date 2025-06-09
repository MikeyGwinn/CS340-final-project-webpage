<!DOCTYPE html>

<html>
	<head>
		<title>Table Viewer</title>
		<link rel="stylesheet" href="index.css">
	</head>
<body>

<?php
// change the value of $dbuser and $dbpass to your username and password
	include 'config.php'; 
	
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	$table = $_POST['table'];
	$query = "SELECT * FROM $table ";

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}
	
	$fields_num = mysqli_num_fields($result);
?>	
	<h1>Table: <?php echo $table?> </h1>
	<table id='t01'><tr>
<?php
	// printing table headers
	for($i=0; $i<$fields_num; $i++) {	
		$field = mysqli_fetch_field($result);	
		echo "<td><b>{$field->name}</b></td>";
	}
	echo "</tr>\n";
	while($row = mysqli_fetch_row($result)) {	
		echo "<tr>";	
		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable	
		foreach($row as $cell)		
			echo "<td>$cell</td>";	
		echo "</tr>\n";
	}

	mysqli_free_result($result);
	mysqli_close($conn);
	?>
</body>

</html>

	
