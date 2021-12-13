<?php
include_once("../api/config/dbinfo.inc.php");
include_once("./teachrich_config.inc.php");

/*
    The teachrich.io frontend redirects here with following query params:
    - token: SSO token
    - r: path to redirect back to.
    (ex: teachrich_redir.php?token=<token>&r=<redir_back_to_path>)

    What this script does:
    - Verifies the token send by TeachRich Frontend by communicating with
      TeachRich Backend API.
    - If token is valid, starts login session on TechnoEdu.
    - Redirects back to TeachRich Frontend.
*/

function redirect($redir_url) {
    header('Location: '.$redir_url);
    exit();
}

function dump_to_log($var) {
    file_put_contents('php://stderr', '[teachrich_redir.php] >>> ' . print_r($var, true) . "\n");
}

function print_to_log($str) {
    file_put_contents('php://stderr', '[teachrich_redir.php] >>> ' . $str . "\n");
}

function makePostRequest($url, $data) {
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true, // return instead of echo-ing response
        CURLOPT_POSTFIELDS => http_build_query($data)
    );
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);

    if (curl_error($ch)) {
        // handle error
        echo "curl error occured :(\n\n";
        echo "error is: " . curl_error($ch) . "\n\n";
        exit();
    }

    print_to_log($response);

    curl_close($ch);

    return json_decode($response);

    // TODO caution: use key 'http' even if you send the request to https://...
    //      So does file_get_contents work with SSL?

    // $options = array(
    //     'http' => array(
    //         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //         'method'  => 'POST',
    //         'content' => http_build_query($data)
    //     )
    // );
    // $context  = stream_context_create($options);
    // $result = file_get_contents($url, false, $context);
    // if ($result === false) {
    //     return array('is_valid' => false);
    // }

    // return json_decode($result, true);
}

/*
 * Checks if a TechnoEdu user corresponding to given TeachRich user ID exists
 * and logs into that TechnoEdu user if it does.
 */
function checkUserId($user_id) {
    global $DBHOST;
    global $DBUSER;
    global $DBPASSWD;
    global $DBNAME;

    $db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
    $db->set_charset("utf8");
    if ($db->connect_error) {
        return;
    }

    global $GENERATED_USER_EMAIL_DOMAIN;
    $user_email = $user_id . $GENERATED_USER_EMAIL_DOMAIN;
    $qry = "SELECT * FROM user_basic WHERE email = '$user_email'";
    dump_to_log($qry);
    $rt = $db->query($qry);

    if ($rt->num_rows <= 0) {
        return;
    }

    $row = $rt->fetch_array(MYSQLI_ASSOC);

    $_SESSION['start'] = time(); // Taking now logged in time.
    $_SESSION['expire'] = $_SESSION['start'] + (60 * 60 * 24); // 1 day
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_part'] = $row['part'];
    $_SESSION['user_dept'] = $row['depart'];
    $_SESSION['user_level'] = $row['level'];

    $rt->close();

    $qry = "UPDATE user_basic SET login_datetime = now() WHERE id = '".$_SESSION['user_id']."'";

    $db->query($qry);
    if ($db->affected_rows <= 0) {
        // $db->error;
        return;
    }

    $db->close();
}

// dump_to_log('$_GET');
// dump_to_log($_GET);
// dump_to_log($_GET);
// dump_to_log($_GET);
// dump_to_log($_GET);
// echo "_GET >>> \n\n";
// var_dump($_GET);

// Validate
$redir_url = $TEACHRICH_REDIR_URL . "/" . (isset($_GET['r']) ?$_GET['r'] :"");

if (!isset($_GET['token'])) {
    redirect($redir_url);
}

$token = $_GET['token'];

// Verify token
$url = $TEACHRICH_API_URL . '/auth/technoedu_verify';
$data = array('token' => $token);
$response = makePostRequest($url, $data);

dump_to_log('response');
dump_to_log($response);
dump_to_log($response);
dump_to_log($response);
dump_to_log($response);
// echo "response >>> \n\n";
// var_dump($response);

if (!$response->is_valid) {
    // TODO error
    redirect($redir_url);
} else {
    session_start();
    session_destroy();
    session_start();

    $user_id = $response->user_id;
    checkUserId($user_id);

    print_to_log('$_SESSION');
    dump_to_log($_SESSION);

    redirect($redir_url);
}
