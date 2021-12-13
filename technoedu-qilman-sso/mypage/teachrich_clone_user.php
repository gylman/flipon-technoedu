<?php
include_once("../api/config/dbinfo.inc.php");
include_once("./teachrich_config.inc.php");

// Connect to database
$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
    die(json_encode(array('error' => 'Can\'t connect to database:' . $db->connect_error)));
}

// Parse request
$request = json_decode(file_get_contents('php://input'));
if(json_last_error() != JSON_ERROR_NONE) {
    die(json_encode(array('error' => 'Request body is not valid JSON.')));
}

// Authentication of API user.
// NOTE: Should probably be done public/private keys instead though. FIXME?
if ($request->api_key != $TEACHRICH_SECRET_API_KEY) {
    die(json_encode(array('error' => 'Invalid secret api key.')));
}

// Count existing users
$qry = "SELECT COUNT(*) FROM user_basic";
$result = $db->query($qry);
$row = $result->fetch_row();
$count = $row[0];
$result->close();

// User attributes
$user_id =  $GENERATED_USER_PREFIX . $count;
$password = '';
$user_name = "Teachrich User <$user_id>";
$user_email = $request->user_id . $GENERATED_USER_EMAIL_DOMAIN;
$allow_mailing = 0;
$phone = '000000000000';
$birthday = '1900-01-01';
$sex = '1';
$part = $request->user_part;
$department = '';

$qry = "INSERT INTO user_basic (id, pw, name, email, allow_mailing, phone, birthday, sex, part, depart, reg_datetime) ".
		"VALUES ('".$user_id."', '".$password."', '".$user_name."', '".$user_email."', ".$allow_mailing.", '".$phone."', '".$birthday."', '".$sex."', '".$part."', '".$department."', now())";

$db->query($qry);
if ($db->affected_rows <= 0) {
	die(json_encode(array('error' => 'Internal error. Error: ' . $db->error)));
}

$db->close();
die(json_encode(array('ok' => 'User created.')));

?>