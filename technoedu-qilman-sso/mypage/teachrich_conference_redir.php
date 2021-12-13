<?php
include_once("./teachrich_config.inc.php");

function redirect($redir_url) {
    header('Expires: '.gmdate('r', time() + 60)); // 1 min
    header('Location: '.$redir_url);
    exit();
}

// Redirect to a path inside technoedu. Ex: http://technoedu.co.kr/<given_path>
function redirect_to_path($redir_path) {
    global $TECHNOEDU_BASE;
    $redir_url = $TECHNOEDU_BASE . $redir_path;
    redirect($redir_url);
}


session_start();

// Check if logged in first.
if (!isset($_SESSION['user_id'])
    || empty($_SESSION['user_id'])
    || strlen($_SESSION['user_id']) <= 0
    || !isset($_SESSION['user_part'])
    || empty($_SESSION['user_part'])
    || strlen($_SESSION['user_part']) <= 0) {
    redirect_to_path('/');
}

$user_part = $_SESSION['user_part'];

if (!array_key_exists($user_part, $PART_REDIR_LIST)) {
    redirect_to_path('/');
}

$redir_path = $PART_REDIR_LIST[$user_part];
redirect_to_path($redir_path);
