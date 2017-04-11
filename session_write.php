<?
session_start();

//
//  Crop&Merge by Vincent40 -using Jcrop and others- 
//

if (isset($_GET['session_name'])) {
	$_SESSION['myimage'] = "temporanei/".$_GET['session_name'];
}
echo $_GET['session_name'];
$_SESSION["radicale"] = false;

?>