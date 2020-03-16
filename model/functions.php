<?php
/**
 * receives information from admin-page.html and calls all the correct functions
 * to update the database as directed
 * @author Dallas Sloan
 * @version 1.0
 */


//error reporting..
ini_set("display_errors", 1);
error_reporting(E_ALL);
include('database.php');

$db = new Database();

echo"hello World";
var_dump($_POST);

if(isset($_POST['$func'])){
    if($_POST['$func'] == 'updateSold'){
       $GLOBALS['db']->updateSold($_POST['$sold'], $_POST['$tid'] );
    }

    if($_POST['$func'] == "deleteTran"){
        $GLOBALS['db']->deleteTran($_POST['$tid']);
    }
}


