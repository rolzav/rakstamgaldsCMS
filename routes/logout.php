<?php
Flight::route('/logout', function () {
    session_destroy();
    redirect('/login');
});
