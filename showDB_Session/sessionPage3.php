<?php
    session_start();
	session_destroy();
    if (isset($_SESSION["count"]) ) {
        echo "The session is still alive";
	} else {
		echo "<h1> Session is dead </h1>";
	}
?>
<p>
<a href="sessionPage3.php">Click here destroy</a>
<p>
<a href="sessionPage1.php">Go to page 1 and start again</a>

