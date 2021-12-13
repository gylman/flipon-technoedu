<?php
include_once("./teachrich_config.inc.php");

/*
    TeachRich redirects here to log out from TechnoEdu session.
    Afterwards user is redirected back to TeachRich.
*/

function redirect($redir_url) {
    header('Location: '.$redir_url);
    exit();
}

// Logout -- end session
session_start();
session_destroy();

$redir_url = $TEACHRICH_REDIR_URL . "/" . (isset($_GET['r']) ?$_GET['r'] :"");
redirect($redir_url);
