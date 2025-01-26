<?php
function set_message($message)
{
    $_SESSION['message'] = htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); // Sanitize session message
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-info">' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '</div>';
        unset($_SESSION['message']);
    }
}
?>
