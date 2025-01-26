<?php
Flight::route('/about', function () {
    Flight::render('about', ['title' => 'About']);
});
