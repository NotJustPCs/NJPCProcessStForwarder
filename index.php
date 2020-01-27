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
$descbits = explode(" ",$desc);
$originaldesc = $_GET['desc'];
$org = $_GET['org'];
$ticketno = $_GET['ticketno'];

if ($org == 'eBay') {
    if ($descbits[1] == 'sold') {
        $desc = $org . $descbits[1];
    }
  }
	elseif ($org == 'Companies House') {
	    if ($descbits[2] == 'Confirmation' && $descbits[3] == 'Statement') {
	        $desc = $org . $descbits[2] . $descbits[3];
	    }
	}
	elseif (($descbits[2] == 'PCs]:') && ($descbits[3] == 'New') && ($descbits[4] == 'order')) {
	        $desc = 'woosale';
	}
//    $desc = trim(substr($desc,0,strpos($desc, ' ')));

//$desc = preg_replace('/\s+/', '', $desc);
//$desc = strtolower($desc);
$desc = $urlroot . seoUrl($desc);

$handle = curl_init($desc);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);


/* Get the HTML or whatever is linked in $url. */
$response = curl_exec($handle);

/* Check for 404 (file not found). */
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode == 404) {
    echo 'There is no process for this yet. Maybe you should <a target="_blank" href="https://app.process.st/templates/Create-new-Process-uXELTkfN1s-Rrhe6UZxH-w/checklists/run" title="Learn how to add a simple process to this tool">make one</a>?<br>';
    echo '<strong>Organisation of Ticket: </strong>' . $org . '<br>';
    echo '<strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
    echo '<strong>Cleaned Ticket Description: </strong>' . $desc . '<br>';
    echo '<strong>Word numbers of Ticket Description: </strong><br><table>';
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
          /*echo '<td>';
          echo $descbits[$descbitsid++];
          echo '</td>'; */
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
//    header( 'Location: ' . $desc,true,301 );
    header( 'refresh:10; url=' . $desc );
    header("Location: " . $desc );
    echo 'Starting your new process in a mo.<br><b>- Please activate the Share link and copy it into the ticket.<br>- Please rename the process to include the ticket name</b><br>';
    echo $originaldesc . '<br>';
    echo $org . '<br>';
    echo '<a href=' . $desc . '>Click here</a> if you are not redirected.';
}

curl_close($handle);

/* Handle $response here. */
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
	sleep(30);
	redirect($desc);
?>
