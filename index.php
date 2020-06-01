<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Not Just PCs - Process Finder</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- styles -->
	<link rel="stylesheet" href="//www.njpcstatus.co.uk/style.css?v=20200127">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<!-- scripts -->
	<script src="//cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
</head>
<body>
<nav class="navigation">
	<section class="container">
		<span class="navigation-title">
			<img class="img" src="//www.njpcstatus.co.uk/Logo-Square-128px.png">
			<h1 class="title">Not Just PCs</h1>
			<h2 class="title">Process Finder</h2>
		</span>
	</section>
</nav>
<div class="container" id="main">

<?php

include 'functions.php';

$urlroot = 'http://go.njpc.it/prst-';
$desc = $_GET['desc'];
if (substr($desc,0,4) == 'FW: ') {
	$desc = substr($desc,4);
}
$descbits = explode(" ",$desc);
$originaldesc = $_GET['desc'];
$org = $_GET['org'];
$ticketno = $_GET['ticketno'];
$ticketnicename = '#' . $ticketno . ' ' . $originaldesc

if (($org == 'eBay') && ($descbits[1] == 'sold')) {
    $desc = $org . $descbits[1];
  }
	elseif (($org == 'Companies House') && ($descbits[2] == 'Confirmation') && ($descbits[3] == 'Statement')){
    $desc = $org . $descbits[2] . $descbits[3];
	}
	elseif ($org == 'GoCardless'){
		$desc = preg_replace('/[0-9]+/', '', $desc);
	}
	elseif ($org == 'Little Beach Boutique'){
		if (($descbits[1] == 'Beach') && ($descbits[3] == 'Order') && ($descbits[5] == 'placed')) {
			$desc = 'lbb-shopifyorder';
		}
	}
	elseif (($descbits[2] == 'PCs]:') && ($descbits[3] == 'New') && ($descbits[4] == 'order')) {
  	$desc = 'woosale';
	}
	elseif (($descbits[0] == 'New') && ($descbits[1] == 'customer:') ) {
  	$desc = 'newddcust';
	}
	elseif ($org == 'Not Just PCs Ltd') {
		if (($descbits[0] == '[GANDI]') && ($descbits[1] == 'Invoice')) {
			$desc = preg_replace('/[0-9]+/', '', $desc);
		}
		elseif (strpos($descbits[0],'njpc.uk]') !== false) {
			if ($descbits[1] == 'DISKWARN') {
				$desc = preg_replace('/[0-9]+/', '', $desc);
			}
		}
	}

$desc = $urlroot . seoUrl($desc);

$handle = curl_init($desc);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($handle);

$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode == 404) {
	echo '<i style="color:red;" class="fa fa-times" aria-hidden="true"></i> There is no process for this yet. Maybe you should <a target="_blank" href="https://app.process.st/templates/Create-new-Process-uXELTkfN1s-Rrhe6UZxH-w/checklists/run" title="Learn how to add a simple process to this tool">make one</a>?<br>';
	echo '<i class="fa fa-building" aria-hidden="true"></i> <strong>Organisation of Ticket: </strong>' . $org . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Number: </strong>' . $ticketno . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Full Description: </strong>' . $ticketnicename . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Link: </strong> https://notjustpcs.zendesk.com/agent/tickets/' . $ticketno . '<br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Process URL tested: </strong>' . $desc . '<br>';
	echo '<i class="fa fa-list-ol" aria-hidden="true"></i> <strong>Word numbers of Ticket Description: </strong><br><table>';
	$descbitsid = 0;
	foreach($descbits as $row){
	  echo '<tr>';
	  $row = explode(' ',$row);
	  foreach($row as $cell){
	    echo '<td>';
	    echo $descbitsid++;
	    echo '</td>';
	    echo '<td>';
	    echo $cell;
	    echo '</td>';
	  }
	  echo '</tr>';
	}
	echo '</table>';
	echo '<a href="javascript:location.reload(true)"><i class="fa fa-refresh"></i> Try again</a>.';
} else {
	$targeturlhandle = curl_init($desc);
	curl_setopt($targeturlhandle, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($targeturlhandle);
	$targeturl = curl_getinfo($targeturlhandle, CURLINFO_EFFECTIVE_URL);
	$targeturlincquery = $targeturl;
	echo '<i style="color:green;" class="fa fa-check" aria-hidden="true"></i> Starting your new process in a mo.<br><b>- Please activate the Share link and copy it into the ticket.<br>- Please rename the process to include the ticket name</b><br>';
	echo '<i class="fa fa-building" aria-hidden="true"></i> <strong>Organisation of Ticket: </strong>' . $org . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Number: </strong>' . $ticketno . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Full Description: </strong>' . $ticketnicename . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Link: </strong> https://notjustpcs.zendesk.com/agent/tickets/' . $ticketno . '<br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Short Process URL: </strong>' . $desc . '<br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Long Process URL: </strong>' . $targeturl . '<br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Full Process URL: </strong>' . $targeturlincquery . '<br>';
	echo '<i class="fa fa-play" aria-hidden="true"></i> <a href=' . $targeturlincquery . '>Click here</a> to start the process if you are not redirected.<br>';
	header( 'refresh:10; url=' . $targeturlincquery );
	header("Location: " . $targeturlincquery );
}

curl_close($targeturlhandle);
curl_close($handle);

?>
</div>
<footer class="footer">
	<div class="container">
		<img height="64px" src="//www.njpcstatus.co.uk/Logo-Square-128px.png" />
		<span class="text-muted">Not Just PCs</span>
	</div>
</footer>
</body>
</html>

<?php
	redirect($targeturlincquery);
?>
