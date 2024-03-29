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
	<link rel="stylesheet" href="//static.notjustpcs.co.uk/style.css?v=20220731">
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
			<img class="img" src="//static.notjustpcs.co.uk/Logo-Square-128px.png">
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
#$ticketnicename = '#' . $ticketno . ' ' . $originaldesc;
$ticketnicename = $ticketno . ' ' . $originaldesc;
#$ticketquerystring = '?checklist_name=' . urlencode($ticketnicename);
$ticketquerystring = '?checklist_name=' . urlencode($ticketnicename) . '&zd_tkt_no=' . $ticketno . '&zd_tkt_desc=' . $originaldesc;
$processprocesslink = 'https://app.process.st/templates/Create-new-Process-uXELTkfN1s-Rrhe6UZxH-w/checklists/run' . $ticketquerystring;
$genericprocesses = array (
  array("Everything Process","This is a process about how to run actually go about doing anything. It should be followed when you're dealing with customers, or when you're sweeping the garage, and everything in between.","https://app.process.st/templates/The-Everything-Process-iRNWttFAKahlKrFHxklORg/checklists/run")
  ,array("Basic checks on a PC (Remote Service Case process)","This is a good one to run on pretty much every Windows PC we encounter","https://app.process.st/templates/New-Remote-Service-Case-Windows-jkMkEdwvfgI3S3gBbPNBWw/checklists/run")
	,array("Prepare for onsite visit","A good way to make sure you are well prepared when you are planning to visit a client","https://app.process.st/templates/Prepare-for-onsite-visit-s_ZbjLw52XgZsXsQeEBAsQ/checklists/run")
	,array("Check a device into the workshop","Whenever a customer brings a device to us, we need to run this process","https://app.process.st/templates/Checking-in-a-laptopdesktop-q7SQAlOuUivXDRpCQkBBoQ/checklists/run")
);
$genericprocessescount = count($genericprocesses);



if ($org == 'eBay') {
		if ($descbits[1] == 'sold') {
		    	$desc = $org . 'sold';
		}
		elseif ($descbits[3] == 'sold:') {
			$desc = $org . 'sold';
		}
		elseif ($descbits[1] == 'offer') {
			$desc = $org . 'offer';
		}
  }
elseif (($org == 'Companies House') && ($descbits[2] == 'confirmation') && ($descbits[3] == 'statement')){
    $desc = $org . $descbits[2] . $descbits[3];
  }
elseif ($org == 'Little Beach Boutique'){
#		if (($descbits[1] == 'Beach') && ($descbits[3] == 'Order') && ($descbits[5] == 'placed')) {
	if (($descbits[1] == 'Beach') && ($descbits[3] == 'Order')) {
		$desc = 'lbb-shopifyorder';
	}
  }
elseif (($descbits[2] == 'PCs]:') && ($descbits[3] == 'New') && ($descbits[4] == 'order')) {
	$desc = 'woosale';
  }
elseif (($descbits[0] == 'New') && ($descbits[1] == 'customer:')) {
  	$desc = 'newddcust';
  }
elseif ($org == 'GlobalSign'){
	if ($descbits[1] == 'Renewal') {
		$desc = 'gs-sslrenewal';
	}
  }
elseif ($org == 'GoCardless'){
	$desc = preg_replace('/[0-9]+/', '', $desc);
  }
elseif ($org == 'Google'){
	if (($descbits[1] == 'Phishing') && ($descbits[4] == 'post-delivery')) {
		$desc = 'workspacephishingalert';
	}
	elseif (($descbits[1] == 'Gmail') && ($descbits[4] == 'spoofing')) {
		$desc = 'workspacespoofingalert';
	}
  }
elseif ($org == 'Not Just PCs') {
	if ($descbits[0] == '[GANDI]') {
		if ($descbits[1] == 'Invoice') {
			$desc = preg_replace('/[0-9]+/', '', $desc);
		}
		elseif ($descbits[2] == 'expires') {
			$desc = 'domain-renewal';
		}
	}
	elseif (($descbits[3] == 'review') && ($descbits[11] == 'Business')) {
		$desc = 'newnjpcreview';
	}
	elseif (($descbits[0] == 'Monitor') && ($descbits[1] == 'is')) {
		$desc = 'uptimerobotalert';
	}
	elseif (strpos($descbits[0],'njpc.uk]') !== false) {
		if ($descbits[1] == 'DISKWARN') {
			$desc = preg_replace('/[0-9]+/', '', $desc);
		}
		elseif (($descbits[2] == 'AutoSSL') && ($descbits[3] == 'reduced')) {
			$desc = 'autossl-reduced-ssl-coverage';
		}
		elseif (($descbits[1] == 'Disk') && ($descbits[2] == 'Usage') && ($descbits[5] == 'user')) {
			$desc = 'user-disk-usage';
		}
	}
  }
elseif (($descbits[0] == 'Approval') && (substr($descbits[1],0,9) == 'requested' )) {
	$desc='365approval';
  }
elseif ($descbits[0] == '[office.notjustpcs.co.uk][CMS]Packages') {
	$desc='synology-packages';
  }

$desc = $urlroot . seoUrl($desc);

$handle = curl_init($desc);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($handle);

$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode == 404) {
	echo '<i style="color:red;" class="fa fa-times" aria-hidden="true"></i> There is no process for this yet. Maybe you should <a target="_blank" href="' . $processprocesslink . '" title="Learn how to add a simple process to this tool">make one</a>?<br>';
	echo '<i class="fa fa-list" aria-hidden="true"></i> <strong>Generic Processes: </strong> The primary generic processes are often relevant, too:<ul>';
        $i = 0;
        while ($i < $genericprocessescount)
        {
            echo '<a href=' . $genericprocesses[$i][2] . $ticketquerystring . ' title="' . $genericprocesses[$i][1] . '" target="_blank">' . $genericprocesses[$i][0] . '</a><br />';
            $i++;
        }
	echo '</ul><br><i class="fa fa-building" aria-hidden="true"></i> <strong>Organisation of Ticket: </strong>' . $org . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Number: </strong>' . $ticketno . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Full Description: </strong>' . $ticketnicename . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Link: </strong><a target="_blank" href="https://notjustpcs.zendesk.com/agent/tickets/' . $ticketno . '">Link</a><br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong><a target="_blank" href="https://go.njpc.it/shorties">Process URL</a> tested: </strong>' . $desc . '<br>';
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
	$targeturlincquery = $targeturl . $ticketquerystring;
	echo '<i style="color:green;" class="fa fa-check" aria-hidden="true"></i> Starting your new process in a mo.<br><b style="color:red">- Please activate the Share link and copy it into the ticket.</b><br>';
	echo '<i class="fa fa-building" aria-hidden="true"></i> <strong>Organisation of Ticket: </strong>' . $org . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Number: </strong>' . $ticketno . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Full Description: </strong>' . $ticketnicename . '<br>';
	echo '<i class="fa fa-ticket" aria-hidden="true"></i> <strong>Original Ticket Link: </strong> <a target="_blank" href="https://notjustpcs.zendesk.com/agent/tickets/' . $ticketno . '">Link</a><br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Short Process URL: </strong><a target="_blank" href="' . $desc . '">Link</a><br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Long Process URL: </strong><a target="_blank" href="' . $targeturl . '">Link</a><br>';
	echo '<i class="fa fa-file-code-o" aria-hidden="true"></i> <strong>Full Process URL: </strong><a target="_blank" href="' . $targeturlincquery . '">Link</a><br>';
	echo '<i class="fa fa-play" aria-hidden="true"></i> <a href=' . $targeturlincquery . '>Click here</a> to start the process if you are not redirected.<br>';
	echo '<i class="fa fa-list" aria-hidden="true"></i> <strong>Generic Processes: </strong> The primary generic processes are often relevant, too:<br>';
        $i = 0;
        while ($i < $genericprocessescount)
        {
            echo '<a href=' . $genericprocesses[$i][2] . $ticketquerystring . ' title="' . $genericprocesses[$i][1] . '" target="_blank">' . $genericprocesses[$i][0] . '</a><br />';
            $i++;
        }	header( 'refresh:10; url=' . $targeturlincquery );
	header("Location: " . $targeturlincquery );
}

curl_close($targeturlhandle);
curl_close($handle);

?>
</div>
<footer class="footer">
	<div class="container">
		<img height="64px" src="//static.notjustpcs.co.uk/Logo-Square-128px.png" />
		<span class="text-muted">Not Just PCs</span>
	</div>
</footer>
</body>
</html>

<?php
	redirect($targeturlincquery);
?>
