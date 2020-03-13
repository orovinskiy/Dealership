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
    'WV' => 'West Virginia','WI' => 'Wisconsin','WY' => 'Wyoming',));
//creating array of months
$f3->set("months", array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'));

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
    $file = file_get_contents('model/cars.json');
    $jsonCar = json_decode($file,true);
    $jsonCar = $jsonCar[$_GET['id']];
    //add json car info to hive
    $f3->set("car",$jsonCar);


    //var_dump($jsonCar);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        var_dump($_POST);
        //add to hive to make form sticky
        $f3->set('payment',$_POST);
        //check to ensure form is valid
        if($validate->validForm()){
            //writing to cars_sold table --->commenting out for the moment
            $carID = $GLOBALS['db']->addCar($jsonCar);

            //writing info to buyer table
            $buyerID = $GLOBALS['db']->addBuyers($_POST);

            //writing to payment_type table
            $paymentID = $GLOBALS['db']->addPayment($_POST);
            echo $paymentID;

            //check to see if car has already been purchased
            if($carID == 00){
                echo"this car has been sold";
            }
            else {
                //writing to transaction table
                $GLOBALS['db']->addTransaction($buyerID, $carID, $paymentID);
            }

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

$f3->route("GET /thank", function ($f3) {
    $view = new Template();
    echo $view->render("views/thank-you.html");
});



//Run f3
$f3->run();