<?php
require __DIR__ . '/inc/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $_SESSION = [];
    session_regenerate_id(true);
    flash('success', tr('You are logged out.'));
}
redirect('login.php');
