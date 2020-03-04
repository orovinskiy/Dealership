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
$f3->route("GET|POST /payment", function ($f3) {
    //instantiate a new validator object
    $validate = new Validator();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        var_dump($_POST);
        //add to hive to make form sticky
        $f3->set('payment',$_POST);
        //check to ensure form is valid
        if($validate->validForm()){
            //reroute to thank you page
            $f3->reroute("/thank");
        }
        else{
            //Data was not valid
            //Get errors and add to f3 hive
            $f3->set('errors', $validate->getErrors());
        }
    }
    $view = new Template();
    echo $view->render("views/payment-form.html");
});


//Run f3
$f3->run();