<?php
session_start();
$comment = $_GET['comment'].PHP_EOL;
$line = file("id.txt");
$id = (intval($line[0]));
if ($_SESSION['currUser'] != ""){
	$pFile = fopen("id.txt", "w");
	if(flock($pFile, LOCK_EX+LOCK_NB)) {	
		fwrite($pFile,($id + 1));
		flock($pFile, LOCK_UN); 
	}
	fclose($pFile);	
	
	$fp = fopen('tempComments.txt','a+');
	if(flock($fp, LOCK_EX+LOCK_NB)) {
		fwrite($fp,$line[0].PHP_EOL);
		fwrite($fp,$_SESSION['currUser'].PHP_EOL);
		fwrite($fp,date("Y-m-d").PHP_EOL);
		fwrite($fp, $comment);
		fwrite($fp,"----------------------------------------".PHP_EOL);
		flock($fp, LOCK_UN); 
		}
	fclose($fp);
	header("Refresh: 0;  url=index.php?page=festivals");
}
else {
	header("Refresh: 0;  url=index.php?page=festivals");
}

?>