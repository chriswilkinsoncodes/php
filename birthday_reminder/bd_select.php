<!-- Birthday Reminder App - Select Birthday -->
<?php
readfile('bd_header.tmpl.html');
?>
<h2>List of Birthdays</h2>
<ul>
<?php
    require 'bd_config.inc.php';
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        
    $sql = 'SELECT * FROM birthdays';
    $result = $db->query($sql);
    $db->close();

    // $row is an arbitrary variable
    foreach ($result as $row) {
        printf('<li>%s %s %s 
        <a href="bd_details.php?id=%s">Details</a>
        <a href="bd_update.php?id=%s">Update</a>
        <a href="bd_delete.php?id=%s">Delete</a>
        </li>',
        // are htmlspecialchars() & ENT_QUTOES needed here if they've been used before adding the data to the db?
        $row['firstname'], $row['lastname'], $row['birthday'], $row['id'], $row['id'], $row['id']);
    }
?>
</ul>
<a href="bd_add.php">Add Birthday</a>
<?php
readfile('bd_footer.tmpl.html');
?>
