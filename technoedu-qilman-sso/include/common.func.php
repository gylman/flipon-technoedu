<?
session_start();

$now = time();
if (isset($_SESSION['expire']) )
{
	if ($now > $_SESSION['expire']) {
		session_destroy();
		session_start();
	}
}

// login check
function isLogin() {
	if (isset($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0) {
		return true;
	}
	
	return false;
}
?>
