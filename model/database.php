<?php
require_once ("config-dealership.php");

class Database
{
    //PDO object
    private $_dbh;

    function __construct()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function addBuyers($buyer)
    {
        //1. Define the query
        $sql = "INSERT INTO buyers (last_name, first_name, phone, email, address, address_two, city, state, zip)
                VALUES(:lname, :fname, :phone, :email, :address, :address_two, :city, :state, :zip)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':lname', $buyer['lastName']);
        $statement->bindParam(':fname', $buyer['firstName']);
        $statement->bindParam(':phone', $buyer['phoneNumber']);
        $statement->bindParam(':email', $buyer['email']);
        $statement->bindParam(':address', $buyer['address']);
        $statement->bindParam(':address_two', $buyer['address2']);
        $statement->bindParam(':city', $buyer['city']);
        $statement->bindParam(':state', $buyer['state']);
        $statement->bindParam(':zip', $buyer['zipCode']);

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;


    }

    function addPayment($payment)
    {
        //1. Define the query
        $sql = "INSERT INTO payment_type (card_number, `name`, exp_month, exp_year, cvv, `type`)
                VALUES(:card_number, :name, :exp_month, :exp_year, :cvv, :type)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':card_number', $payment['cardNumber']);
        $statement->bindParam(':name', $payment['cardName']);
        $statement->bindParam(':exp_month', $payment['monthExp']);
        $statement->bindParam(':exp_year', $payment['yearExp']);
        $statement->bindParam(':cvv', $payment['cvv']);
        $statement->bindParam(':type', $payment['paymentMethod']);

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;


    }

    function addCar($car)
    {
        //1. Define the query
        $sql = "INSERT INTO cars_sold (cars_id, make, model, `year`, cost)
                VALUES(:cars_id, :make, :model, :year, :cost";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters ----> Have to work with Oleg to get the car object information
        /*$statement->bindParam(':cars_id', $car['cardNumber']);
        $statement->bindParam(':make', $car['cardName']);
        $statement->bindParam(':model', $car['monthExp']);
        $statement->bindParam(':year', $car['yearExp']);
        $statement->bindParam(':cost', $car['cvv']);*/

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;

    }

    function addTransaction($buyerID, $carID, $paymentID)
    {
        //1. Define the query
        $sql = "INSERT INTO transaction (buyers_id, cars_id, payment_id)
                VALUES(:buyers_id, :cars_id, :payment_id)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':buyers_id', $buyerID);
        $statement->bindParam(':cars_id', $carID);
        $statement->bindParam(':payment_id', $paymentID);

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;

    }


}
