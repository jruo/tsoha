<?php

$pdo = new PDO('pgsql:');

$query = $pdo->prepare('SELECT username FROM member;');
$query->execute();
$results = $query->fetchAll();

echo '<h1>Lista kaikkien käyttäjien käyttäjänimistä</h1>';
echo '<ul>';

foreach ($results as $row) {
    echo '<li>' . $row['username'] . '</li>';
}

echo '</ul>';