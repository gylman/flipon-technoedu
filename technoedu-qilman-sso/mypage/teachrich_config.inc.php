<?php

// Configuration for cloning users
$TEACHRICH_API_URL = 'http://flipon-api';
$TEACHRICH_SECRET_API_KEY = 'somecryptographicallysecurerandomstring';
$GENERATED_USER_PREFIX = '_gen_';
$GENERATED_USER_EMAIL_DOMAIN = '@generated.teachrich.io';

// Configuration for redirecting back to TeachRich
$TEACHRICH_REDIR_URL = 'http://localhost:4000';

// Configuration for redirecting the user to conference room of their organization
$TECHNOEDU_BASE = 'http://localhost:3000';
include_once('./teachrich_config_large.inc.php');

?>