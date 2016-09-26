<?php
mysql_connect('localhost', 'root', '');
mysql_select_db('mycorp');
$id = $_GET['id'];
$query = mysql_query("SELECT * FROM newsletters WHERE id='" . $id . "'");
while ($newsletter = mysql_fetch_assoc($query)) {
    echo '<h3>' . $newsletter['subject'] . '</h3>';
    echo $newsletter['body'];
    echo 'You are viewing <a href="' . $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'] . '">This newsletter</a>';
}
