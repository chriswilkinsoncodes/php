<!-- Birthday Reminder App - Birthday Details -->
<?php
readfile('bd_header.tmpl.html');
?>
<h2>Birthday Details</h2>
<ul class="details-list">
<?php

    $category = [
        "f" => "Family",
        "r" => "Friend",
        "c" => "Colleague",
        "u" => "Customer",
        "" => "none",
    ];

    $period = [
        "d" => "day",
        "w" => "week",
        "m" => "month",
    ];

    require 'bd_config.inc.php';

    if(isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header('Location: register.php');
    };

    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        
    $sql = "SELECT * FROM birthdays WHERE id=$id";
    $result = $db->query($sql);
    $db->close();

    foreach ($result as $row) {
        printf('<li>Name: %s %s</li>
        <li>Birthday: %s</li>
        <li>Category: %s</li>
        <br>
        <li>Observance(s): %s</li>
        <li>Budget: %s</li>
        <li>Actual: %s</li>
        <li>Reminder: %s</li>
        <li>Gift Ideas: %s</li>
        <a href="bd_update.php?id=%s">Update</a>
        <a href="bd_delete.php?id=%s">Delete</a>
        </li>',
        // are htmlspecialchars() & ENT_QUTOES needed here if they've been used before adding the data to the db?
        $row['firstname'], $row['lastname'], $row['birthday'], $category[$row['category']], $row['acknowledgement'], $row['budget'], $row['actual'], $row['reminder'], $row['ideas'], $row['id'], $row['id']);
    }
?>
</ul>
<a href="bd_add.php">Add Birthday</a>
<a href="bd_select.php">Show Birthdays</a>
<?php
readfile('bd_footer.tmpl.html');
?>
