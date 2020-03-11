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

//create a new dealership object
$db = new Database();


$f3->set("div",array(0,1,2,3,4,5,6,7,8,9));


//Define a default route
$f3->route("GET /", function () {
    $view = new Template();
    echo $view->render("views/home.html");
});

$f3->route("POST /buy/@id", function ($f3,$param) {
    $item = $param['id'];

    $file = file_get_contents('model/cars.json');
    $jsonCar = json_decode($file,true);
    $jsonCar = $jsonCar[$item];
    //var_dump($jsonCar);

    $f3->set('make',$jsonCar['Identification']['Model Year']);
    $f3->set('pic',$jsonCar['Identification']['Make']);
    $f3->set('cost',$jsonCar['Identification']['Cost']);
    $f3->set('transmission',$jsonCar['Engine Information']['Transmission']);
    $f3->set('engine',$jsonCar['Engine Information']['Engine Type']);
    $f3->set('horse',$jsonCar['Engine Information']['Engine Statistics']['Horsepower']);
    $f3->set('driveline',$jsonCar['Engine Information']['Driveline']);
    $f3->set('classification',$jsonCar['Identification']['Classification']);
    $f3->set('highway',$jsonCar['Fuel Information']['Highway mpg']);
    $f3->set('city',$jsonCar['Fuel Information']['City mph']);
    $f3->set('fuel',$jsonCar['Fuel Information']['Fuel Type']);
    $f3->set('id',$item);

    $view = new Template();
    echo $view->render("views/carDetails.html");
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

    var_dump($_GET);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        var_dump($_POST);
        //add to hive to make form sticky
        $f3->set('payment',$_POST);
        //check to ensure form is valid
        if($validate->validForm()){
            //writing info to buyer table
            $buyerID = $GLOBALS['db']->addBuyers($_POST);

            //writing to payment_type table
            $paymentID = $GLOBALS['db']->addPayment($_POST);
            echo $paymentID;

            //writing to cars_sold table --->commenting out for the moment
            //$GLOBALS['db']->addCar($needtofigureouthowtosendcarinfo);

            //writing to transaction table ---->adding car ID of 15 to just test
            $GLOBALS['db']->addTransaction($buyerID, 17, $paymentID);

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

$f3->route("GET /thank", function () {
    $view = new Template();
    echo $view->render("views/thank-you.html");
});



//Run f3
$f3->run();