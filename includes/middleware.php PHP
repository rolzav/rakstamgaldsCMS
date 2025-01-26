<?php
function checkAuth()
{
    if (!isset($_SESSION['user_id'])) {
        redirect('/login');
    }
}

function checkRole($role)
{
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== $role && $_SESSION['role'] !== 'admin')) {
        redirect('/');
    }
}
?>
