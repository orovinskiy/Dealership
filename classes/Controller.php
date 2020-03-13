<?php


class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home(){
        $view = new Template();
        echo $view->render("views/home.html");
    }

    function buyCar($item){
        $file = file_get_contents('model/cars.json');
        $jsonCar = json_decode($file,true);
        $jsonCar = $jsonCar[$item];
        //var_dump($jsonCar);

        $this->_f3->set('make',$jsonCar['Identification']['Model Year']);
        $this->_f3->set('pic',$jsonCar['Identification']['Make']);
        $this->_f3->set('cost',$jsonCar['Identification']['Cost']);
        $this->_f3->set('transmission',$jsonCar['Engine Information']['Transmission']);
        $this->_f3->set('engine',$jsonCar['Engine Information']['Engine Type']);
        $this->_f3->set('horse',$jsonCar['Engine Information']['Engine Statistics']['Horsepower']);
        $this->_f3->set('driveline',$jsonCar['Engine Information']['Driveline']);
        $this->_f3->set('classification',$jsonCar['Identification']['Classification']);
        $this->_f3->set('highway',$jsonCar['Fuel Information']['Highway mpg']);
        $this->_f3->set('city',$jsonCar['Fuel Information']['City mph']);
        $this->_f3->set('fuel',$jsonCar['Fuel Information']['Fuel Type']);
        $this->_f3->set('id',$item);

        $view = new Template();
        echo $view->render("views/carDetails.html");
    }

    function listings(){
        $view = new Template();
        echo $view->render("views/lists.html");
    }

    function payment(){
        //instantiate a new validator object
        $validate = new Validator();
        $file = file_get_contents('model/cars.json');
        $jsonCar = json_decode($file,true);
        $jsonCar = $jsonCar[$_GET['id']];
        //add json car info to hive
        $this->_f3->set("car",$jsonCar);


        //var_dump($jsonCar);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //add to hive to make form sticky
            $this->_f3->set('payment',$_POST);
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
                $this->_f3->reroute("/thank");
            }
            else{
                //Data was not valid
                //Get errors and add to f3 hive
                $this->_f3->set('errors', $validate->getErrors());
            }
        }
        $view = new Template();
        echo $view->render("views/payment-form.html");
    }

    function thanks(){
        $view = new Template();
        echo $view->render("views/thank-you.html");
    }

}