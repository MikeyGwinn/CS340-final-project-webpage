<?php
    session_start();
    if (!$_SESSION["count"])
        $_SESSION["count"] = 0;
    if ($_GET["count"] == "yes")
        $_SESSION["count"] = $_SESSION["count"] + 1;
    echo "<h1>".$_SESSION["count"]."</h1>";
?>
<a href="sessionPage2.php?count=yes">Click here to count</a>
<p>
<a href="sessionPage3.php">Go to page 3 and destroy</a>

