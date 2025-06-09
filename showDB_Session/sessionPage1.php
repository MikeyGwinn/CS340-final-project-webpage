<?php
    session_start();
    if (!$_SESSION["count"])
        $_SESSION["count"] = 0;
    if ($_GET["count"] == "yes")
        $_SESSION["count"] = $_SESSION["count"] + 1;
    echo "<h1>".$_SESSION["count"]."</h1>";
?>
<html>
<body>
	<h1> Page One </h1>
	<a href="sessionPage1.php?count=yes">Click here to count</a>
	<p>
	<a href="sessionPage2.php">Go to page 2</a>
</body>
</html>