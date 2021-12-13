<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultBoard = array();

// limit
$page_limit = 10;
$qry_limit = '';
if (isset($_POST["page"])) {
	if (isset($_POST["limit"])) {
		$page_limit = $_POST["limit"];
	}
	$qry_limit = " LIMIT ".($_POST["page"] * $page_limit).", ".$page_limit;
}

$qry_search = '';
if (isset($_POST["search_val"])) {
	$qry_search = " WHERE title LIKE '%".$_POST["search_val"]."%' OR content LIKE '%".$_POST["search_val"]."%'";
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT COUNT(*) FROM board_faq".$qry_search;

$total_count = 0;
if ($result = $db->query($qry)) {
	$row = $result->fetch_row();
	$total_count = $row[0];
	$result->free();
}

$qry = "SELECT * FROM board_faq".$qry_search." ORDER BY reg_datetime DESC".$qry_limit;

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultBoard[$i]["id"]		= $row["id"];
		$arrJsonResultBoard[$i]["user_id"]	= $row["user_id"];
		$arrJsonResultBoard[$i]["title"]	= $row["title"];
		$arrJsonResultBoard[$i]["content"]	= $row["content"];
		$arrJsonResultBoard[$i]["hits"]	= $row["hits"];
		$arrJsonResultBoard[$i]["reg_datetime"]	= $row["reg_datetime"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["total_count"] = $total_count;
$arrJsonResult["count"] = $i;
$arrJsonResult["board"] = $arrJsonResultBoard;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
