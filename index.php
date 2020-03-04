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

//Instantiate F3
$f3 = Base::instance();
//instantiate a new validator object
$validate = new Validator();


//Define a default route
$f3->route("GET /", function () {
    $view = new Template();
    echo $view->render("views/home.html");
});

$f3->route("GET /listings", function () {
    $view = new Template();
    echo $view->render("views/lists.html");
});

//creating a payment route
//Define a default route
$f3->route("GET /payment", function () {
    $view = new Template();
    echo $view->render("views/payment-form.html");
});


//Run f3
$f3->run();