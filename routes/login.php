<?php
Flight::route('/login', function () {
    if (isset($_SESSION['user_id'])) {
        redirect('/'); 
    }

    if (Flight::request()->method == 'POST') {
        $token = Flight::request()->data->csrf_token;
        if (!$token || $token !== $_SESSION['csrf_token']) {
            Flight::halt(403, 'Invalid CSRF token');
        }

        $username = htmlspecialchars(trim(Flight::request()->data->username), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim(Flight::request()->data->password), ENT_QUOTES, 'UTF-8');

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            redirect('/admin');
        } else {
            Flight::render('login', ['title' => 'Login', 'error' => 'Invalid credentials']);
        }
    } else {
        Flight::render('login', ['title' => 'Login']);
    }
});
