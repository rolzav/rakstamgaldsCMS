<?php
Flight::route('/admin', function () {
    checkAuth();
    checkRole('admin');
    Flight::render('admin/dashboard', ['title' => 'Admin Dashboard']);
});
