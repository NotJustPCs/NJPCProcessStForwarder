<h1>Process Finder</h1>
<?php

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

$urlroot = 'http://go.njpc.it/prst-';
$desc = $_GET['desc'];
$originaldesc = $_GET['desc'];
$org = $_GET['org'];

if ($org == 'eBay') {
    $descbits = explode(" ",$desc);
    if ($descbits[1] == 'sold') {
        $desc = $org . $descbits[1];
    }
elseif ($org == 'Companies House') {
    $descbits = explode(" ",$desc);
    if ($descbits[2] == 'sold' && $descbits[3] == 'sold') {
        $desc = $org . $descbits[2] . $descbits[3];
    }
}
//    $desc = trim(substr($desc,0,strpos($desc, ' ')));
}

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
    echo '<strong>Original Ticket Description: </strong>' . $originaldesc . '<br>';
    echo $desc . '<br>';
    echo $org;
} else {
//    header( 'Location: ' . $desc,true,301 );
    header( 'refresh:10; url=' . $desc );
    echo 'Starting your new process in a mo.<br><b>- Please activate the Share link and copy it into the ticket.<br>- Please rename the process to include the ticket name</b><br>';
    echo $originaldesc . '<br>';
    echo $org;
}

curl_close($handle);

/* Handle $response here. */
?>
