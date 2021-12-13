<?
	// 아래 url은 등록된 mcu의 url 정보를 DB에서 가져온다. 웹페이지에 나타나지 않게 유의!(보안)
	//$mcuurl = 'http://61.252.54.69:10062/wem1000/appsvrinf.jsp';
	//$mcuurl = 'http://49.247.222.32:8585/wem1000/appsvrinf.jsp';
	//$mcuurl = 'http://115.68.14.146:8585/wem1000/appsvrinf.jsp';
	//$mcuurl = 'http://49.247.9.66:8585/wem1000/appsvrinf.jsp';
	$mcuurl = 'http://112.166.16.238:8585/wem1000/appsvrinf.jsp';

	$referer='';

	// Convert the data array into URL Parameters like a=b&foo=bar etc.
	$data = http_build_query($_POST);

	// parse the given URL
	$url = parse_url($mcuurl);


	if ($url['scheme'] != 'http') 
	{ 
		printf('Error: Only HTTP request are supported !');
	}

	// extract host and path:
	$host = $url['host'];
	$path = $url['path'];
	$port = $url['port'];

	// open a socket connection on port 80 - timeout: 30 sec
	$fp = fsockopen($host, $port, $errno, $errstr, 30);

	if ( $fp )
	{

		// send the request headers:
		fputs($fp, "POST $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");

		if ($referer != '')
			fputs($fp, "Referer: $referer\r\n");

		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ". strlen($data) ."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $data);

		$result = ''; 
		while(!feof($fp)) 
		{
			// receive the results of the request
			$result .= fgets($fp, 128);
		}
	}
	else 
	{ 
		echo "err";
	}

	// close the socket connection:
	fclose($fp);

	// split the result header from the content
	$result = explode("\r\n\r\n", $result, 2);

	$header = isset($result[0]) ? $result[0] : '';
	$content = isset($result[1]) ? $result[1] : '';

	echo $content;
?>
