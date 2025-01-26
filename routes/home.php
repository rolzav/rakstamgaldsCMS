<?php
require_once __DIR__ . '/../includes/init.php';

Flight::route('/', function () {
    Flight::render('home', ['title' => 'Home']);
});
?>
