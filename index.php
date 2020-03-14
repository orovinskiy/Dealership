<?php

/**
 * @authors Dallas Slown, Oleg Rovinskiy
 * @date 1/18/2020
 * @url https://github.com/orovinskiy/Dealership/
 * This is a DealerShip Website
 */
//error reporting..
ini_set("display_errors", 1);
error_reporting(E_ALL);

//Require autoload file
require("vendor/autoload.php");

//starting a session
session_start();

//Instantiate F3
$f3 = Base::instance();

//create a new dealership object
$db = new Database();
$links = new Controller($f3);

//CREATES THE CAR HOLDERS
$f3->set("div",array(0,1,2,3,4,5,6,7,8,9));
//creating a year array
$f3->set("years",array(2020,2021,2022,2023,2024,2025,2026));
//creating states array
$f3->set("states", array('AL' => 'Alabama','AK' => 'Alaska','AZ' => 'Arizona','AR' => 'Arkansas',
    'CA' => 'California','CO' => 'Colorado','CT' => 'Connecticut','DE' => 'Delaware','DC' => 'District Of Columbia',
    'FL' => 'Florida','GA' => 'Georgia','HI' => 'Hawaii','ID' => 'Idaho','IL' => 'Illinois','IN' => 'Indiana',
    'IA' => 'Iowa','KS' => 'Kansas','KY' => 'Kentucky','LA' => 'Louisiana','ME' => 'Maine','MD' => 'Maryland',
    'MA' => 'Massachusetts','MI' => 'Michigan','MN' => 'Minnesota','MS' => 'Mississippi','MO' => 'Missouri',
    'MT' => 'Montana','NE' => 'Nebraska','NV' => 'Nevada','NH' => 'New Hampshire','NJ' => 'New Jersey',
    'NM' => 'New Mexico','NY' => 'New York','NC' => 'North Carolina','ND' => 'North Dakota','OH' => 'Ohio',
    'OK' => 'Oklahoma','OR' => 'Oregon','PA' => 'Pennsylvania','RI' => 'Rhode Island','SC' => 'South Carolina',
    'SD' => 'South Dakota','TN' => 'Tennessee','TX' => 'Texas','UT' => 'Utah','VT' => 'Vermont','VA' => 'Virginia',
    'WV' => 'West Virginia','WI' => 'Wisconsin','WY' => 'Wyoming'));
//creating array of months
$f3->set("months", array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'));

//Define a default route
$f3->route("GET /", function () {
    $GLOBALS['links']->home();
});

//Route to the specific car that's clicked
$f3->route("POST /buy/@id", function ($f3,$param) {
    $item = $param['id'];
    $GLOBALS['links']->buyCar($item);
});

//Route to all the cars that are available to buy
$f3->route("GET /listings", function () {
    $GLOBALS['links']->listings();
});

//creating a payment route
$f3->route("GET|POST /payment", function () {
    $GLOBALS['links']->payment();
});

$f3->route("GET|POST /admin", function($f3){
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST);
        $validate = new Validator();
        //check to ensure login form is valid
        if($validate->validLogin()) {

        }
        //form was not valid get errors
        else{
            $f3->set('errors', $validate->getErrors());
        }
    }
        $view = new Template();
   echo $view->render("views/admin-login.php");
});

//Route to a thank page after payment has been made
$f3->route("GET /thank", function () {
    $GLOBALS['links']->thanks();
});

//Run f3
$f3->run();