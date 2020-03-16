<?php
/**
 * receives information from admin-page.html ajax call, and calls  the correct function
 * depending on which event handler was initiated
 * @author Dallas Sloan
 * @version 1.0
 */


//error reporting..
ini_set("display_errors", 1);
error_reporting(E_ALL);
include('database.php');

$db = new Database();

//var_dump($_POST);

//check to see if POST is set
if(isset($_POST['$func'])){
    //two if statements to determine which function was called in the ajax call
    if($_POST['$func'] == 'updateSold'){
       $GLOBALS['db']->updateSold($_POST['$sold'], $_POST['$tid'] );
    }

    if($_POST['$func'] == "deleteTran"){
        $GLOBALS['db']->deleteTran($_POST['$tid']);
    }
}


