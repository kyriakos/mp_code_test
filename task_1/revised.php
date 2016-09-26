<?php
$db = new mysqli('localhost', 'root', '');
$db->select_db('mycorp');

$id = (int)$_GET['id'];

$query = $db->prepare("SELECT * FROM newsletters WHERE `id` = ?");
$query->bind_param('i', $id);
if ($query->execute()) {

    $res = $query->get_result();

    if ($res->num_rows > 0) {
        $newsletter = $res->fetch_assoc();

        echo '<h1>' . htmlspecialchars($newsletter['subject']) . '</h1>';
        echo '<p>' . htmlspecialchars($newsletter['body']) . '</p>';
        echo 'You are viewing <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . $id . '">This newsletter</a>';
    } else {
        echo 'ERROR: Invalid newsletter ID.';
    }
} else {
    echo 'ERROR: Problem retrieving data from database.';
}