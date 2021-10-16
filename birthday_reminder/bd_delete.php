<!-- Birthday Reminder App - Delete Birthday -->
<?php
readfile('bd_header.tmpl.html');
?>
<h2>Delete Birthday</h2>
<?php

    if(isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header('Location: bd_select.php');
    }

    require 'bd_config.inc.php';
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

    $sql = "SELECT * FROM birthdays WHERE id=$id";
    $result = $db->query($sql);
    foreach ($result as $row) {
        printf("%s's birthday deleted.<br>",
        $row['firstname']);
    }
    
    $sql = "DELETE FROM birthdays WHERE id=$id";
    $db->query($sql);
    // echo "<p>$result['name']'s birthday deleted.</p>";
    $db->close();
?>

<a href="bd_add.php">Add Birthday</a>
<a href="bd_select.php">Show Birthdays</a>
<?php
readfile('bd_footer.tmpl.html');
?>
