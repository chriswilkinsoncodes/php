<!-- Birthday Reminder App - Add Birthday -->
<?php
readfile('bd_header.tmpl.html');
?>
<h2>Update Birthday</h2>
<?php

require 'bd_config.inc.php';

if(isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: bd_add.php');
}

if(!isset($_POST['submit'])) {
$firstname = '';
$lastname = '';
$birthday= '';
$category = '';
$acknowledgement = '';
$budget = '';
$actual = '';
$reminder = '';
$reminder_num = '';
$reminder_period = '';
$ideas = '';}

if(isset($_POST['submit'])) {
    $ok = true;

    if(!isset($_POST['firstname']) || $_POST['firstname'] === '') {
        $ok = false;
        
    } else {
        $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES);
    }
    if(isset($_POST['lastname']) && $_POST['lastname'] !== '') {
        $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES);
        $category = htmlspecialchars($_POST['category'], ENT_QUOTES);
        $acknowledgement = htmlspecialchars(implode(' ', $_POST['acknowledgement']), ENT_QUOTES);
        $budget = htmlspecialchars($_POST['budget'], ENT_QUOTES);
        $actual = htmlspecialchars($_POST['actual'], ENT_QUOTES);
        $reminder_num = htmlspecialchars($_POST['reminder_num'], ENT_QUOTES);
        $reminder_period = htmlspecialchars($_POST['reminder_period'], ENT_QUOTES);
        $ideas = htmlspecialchars($_POST['ideas'], ENT_QUOTES);
    }
    // if(!isset($_POST['lastname']) || $_POST['lastname'] === '') {
    //     $ok = true;
    // } else {
        // $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES);
    // }
    if(!isset($_POST['birthday']) || $_POST['birthday'] === '') {
        $ok = false;
    } else {        
        $birthday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    }
    // if(!isset($_POST['category']) || $_POST['category'] === '') {
    //     $ok = false;
    // } else {
        // $category = htmlspecialchars($_POST['category'], ENT_QUOTES);
    // }
    // if(!isset($_POST['acknowledgement']) || !is_array($_POST['acknowledgement']) || count($_POST['acknowledgement']) === 0) {
    //     $ok = false;
    // } else {
        // $acknowledgement = htmlspecialchars(implode(' ', $_POST['acknowledgement']), ENT_QUOTES);
    // }
    // if(!isset($_POST['budget']) || $_POST['budget'] === '') {
    //     $ok = false;
    // } else {
        // $budget = htmlspecialchars($_POST['budget'], ENT_QUOTES);
    // }
    // if(!isset($_POST['actual']) || $_POST['actual'] === '') {
    //     $ok = false;
    // } else {
        // $actual = htmlspecialchars($_POST['actual'], ENT_QUOTES);
    // }
    // if(!isset($_POST['reminder']) || $_POST['reminder'] === '') {
    //     $ok = false;
    // } else {
    //     $reminder = htmlspecialchars($_POST['reminder'], ENT_QUOTES);
    // }
    // if(!isset($_POST['reminder_num']) || $_POST['reminder_num'] === '') {
    //     $ok = false;
    // } else {
        // $reminder_num = htmlspecialchars($_POST['reminder_num'], ENT_QUOTES);
    // }
    // if(!isset($_POST['reminder_period']) || $_POST['reminder_period'] === '') {
    //     $ok = false;
    // } else {
        // $reminder_period = htmlspecialchars($_POST['reminder_period'], ENT_QUOTES);
    // }
    // if(!isset($_POST['ideas']) || $_POST['ideas'] === '') {
    //     $ok = false;
    // } else {
        // $ideas = htmlspecialchars($_POST['ideas'], ENT_QUOTES);
    // }

    if($ok) {
        $reminder = $reminder_num.$reminder_period;
        // insert into db
        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);


        $sql = sprintf(
            "UPDATE birthdays SET firstname='%s', lastname='%s', birthday='%s', category='%s', acknowledgement='%s',
            budget='%s', actual='%s', reminder='%s', ideas='%s'
            WHERE id=%s",
            $db->real_escape_string($firstname),
            $db->real_escape_string($lastname),
            $db->real_escape_string($birthday),
            $db->real_escape_string($category),
            $db->real_escape_string($acknowledgement),
            $db->real_escape_string($budget),
            $db->real_escape_string($actual),
            $db->real_escape_string($reminder),
            $db->real_escape_string($ideas),
            $id);
        
        $db->query($sql);
        // echo '<p>User updated.</p>';
        $db->close();

        header('Location: bd_select.php');
    }
}
else {
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

    // using what we already know; there will be an alternate way of doing this
    $sql = "SELECT * FROM birthdays WHERE id=$id";
    $result = $db->query($sql);
    foreach ($result as $row) {
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $birthday = $row['birthday'];
        $category = $row['category'];
        $acknowledgement = $row['acknowledgement'];
        $budget = $row['budget'];
        $actual = $row['actual'];
        $reminder = $row['reminder'];
        $ideas = $row['ideas'];
    }
    // echo $acknowledgement;
    // echo strpos($acknowledgement, 'e');
    // echo strpos($acknowledgement, 'c');
    
    
    $db->close();
}
?>

<form
    action=""
    method="post">
    First Name: <input type="text" name="firstname" value="<?php echo $firstname?>" required><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $lastname?>"><br>
    Birthday: <input type="text" name="birthday" placeholder="YYYY-MM-DD" value="<?php echo $birthday?>" required><br>
    Category:<br>
        <input type="radio" name="category" value="f" <?php if ($category === 'f') echo ' checked' ?>> Family
        <input type="radio" name="category" value="r" <?php if ($category === 'r') echo ' checked' ?>> Friend
        <input type="radio" name="category" value="c" <?php if ($category === 'c') echo ' checked' ?>> Colleague
        <input type="radio" name="category" value="u" <?php if ($category === 'u') echo ' checked' ?>> Customer<br>
        Observance(s):<br>
        <select name="acknowledgement[]" multiple size="3">
            <option value="e" <?php if (strpos($acknowledgement, 'e') !== false) echo ' selected' ?>>Event</option>
            <option value="g" <?php if (strpos($acknowledgement, 'g') !== false) echo ' selected' ?>>Gift</option>
            <option value="c" <?php if (strpos($acknowledgement, 'c') !== false) echo ' selected' ?>>Card</option>
            <option value="p" <?php if (strpos($acknowledgement, 'p') !== false) echo ' selected' ?>>Phone</option>
            <option value="t" <?php if (strpos($acknowledgement, 't') !== false) echo ' selected' ?>>Text</option>
        </select><br>
    Budget: <input type="text" name="budget" value="<?php echo $budget?>"><br>
    Actual: <input type="text" name="actual" value="<?php echo $actual?>"><br>
    Reminder: <input type="text" name="reminder_num" value="<?php echo filter_var($reminder, FILTER_SANITIZE_NUMBER_INT) ?>"><br>

    <!-- $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT); -->

        <select name="reminder_period" id="">
            <option value="">Select reminder period...</option>
            <option value="d" <?php if (strpos($reminder, 'd') !== false) echo ' selected' ?>>days</option>
            <option value="w" <?php if (strpos($reminder, 'w') !== false) echo ' selected' ?>>weeks</option>
            <option value="m" <?php if (strpos($reminder, 'm') !== false) echo ' selected' ?>>months</option>
        </select><br>
    Gift Ideas:<br>
    <textarea name="ideas"><?php echo $ideas?></textarea><br>
    <br>
    <input type="submit" name="submit" value="Update Birthday">
</form>
<br>
<a href="bd_select.php">Show Birthdays</a>
<?php
readfile('bd_footer.tmpl.html');
?>
