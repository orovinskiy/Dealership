<?php
require_once ("config-dealership.php");

/**
 * Database class for Dealership
 * @author Dallas Sloan
 * @version 1.2
 * filename: database.php
 *
 * This is a class that creates a database object and queries the working database for the project
 * Class Database
 */
class Database
{
    //PDO object
    private $_dbh;
    private $_logged;

    /**
     * Constructor for the database class. Creates a new database object and sets the login status to false
     * Database constructor.
     */
    function __construct()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $this->_logged = 'false';
            //echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * function to create a new row in the buyers table within the database
     * @param $buyer buyer object which contains all the specific buyer information
     * @return string returns the primary key of the inserted buyer
     */
    function addBuyers($buyer)
    {
        //does the buyer already exist?
        $buyerExist = $this->getBuyer($buyer);
        if ($buyerExist){
            return $buyerExist['buyers_id'];
        }

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
    //function used to determine whether the buyer already exists in the database
    private function getBuyer($buyer)
    {
        //1. Define the query
        $sql = "SELECT buyers_id from buyers WHERE last_name = :lastName and first_name = :firstName";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':lastName', $buyer['lastName']);
        $statement->bindParam(':firstName', $buyer['firstName']);

        //4. Execute the statement
        $statement->execute();

        //5.get the results false means the buyer does not exist
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;

    }


    /**
     * Function to create a new payment row in the payment_type table within the database
     * @param $payment payment objecct which holds all the informatino about the payment being added
     * @return string returns the primary key of the payment_type that was added
     */
    function addPayment($payment)
    {
        //does the payment already exist?
        $paymentExist = $this->getPayment($payment);
        if ($paymentExist){
            return $paymentExist['card_id'];
        }

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

    //function to check if the payment info already exists in the database
    private function getPayment($payment)
    {
        //1. Define the query
        $sql = "SELECT card_id from payment_type WHERE card_number = :cardNumber and type = :type";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':cardNumber', $payment['cardNumber']);
        $statement->bindParam(':type', $payment['paymentMethod']);

        //4. Execute the statement
        $statement->execute();

        //5.get the results false means the buyer does not exist
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;

    }


    /**
     * Function to create a new row in the cars_sold table within the database
     * @param $car object which holds all the information pertaining to the car that was purchased
     * @return string the primary key of the row inserted into the cars_sold table
     */
    function addCar($car)
    {
        //1. Define the query
        $sql = "INSERT INTO cars_sold (cars_info, make, model, `year`, cost)
                VALUES(:cars_info, :make, :model, :year, :cost)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters ----> Have to work with Oleg to get the car object information
        $statement->bindParam(':cars_info', $car['Identification']['ID']);
        $statement->bindParam(':make', $car['Identification']['Make']);
        $statement->bindParam(':model', $car['Identification']['Model Year']);
        $statement->bindParam(':year', $car['Identification']['Year']);
        $statement->bindParam(':cost', $car['Identification']['Cost']);

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        echo "This is the Car ID: ".$id;
        return $id;

    }

    /**
     * function that creates a new row in our joining transaction table
     * @param $buyerID primary key from buyers table
     * @param $carID primary key from cars_sold table
     * @param $paymentID primary key from payment_type table
     * @return string the primary key of the row inserted into the transaction table
     */
    function addTransaction($buyerID, $carID, $paymentID)
    {
        //1. Define the query
        $sql = "INSERT INTO transaction (buyers_id, car_id, payment_id)
                VALUES(:buyers_id, :car_id, :payment_id)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':buyers_id', $buyerID);
        $statement->bindParam(':car_id', $carID);
        $statement->bindParam(':payment_id', $paymentID);

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;

    }

    //function to get all transactions

    /**
     * Function to get all rows from transactions table. Joins multiple tables together to return an object
     * of inforamtion concerning all transactions
     * @return array of information from transaction table as well as all linking tables.
     */
    function getTransactions()
    {
        //1. define the query
        $sql = "SELECT transaction.transaction_id, buyers.last_name, buyers.first_name, buyers.phone, buyers.email,
                buyers.city, buyers.state, buyers.zip, cars_sold.make, cars_sold.model, cars_sold.year, cars_sold.cost,
                 payment_type.type,
                transaction.sold, transaction.created_at
                FROM transaction
                JOIN buyers ON transaction.buyers_id = buyers.buyers_id
                JOIN cars_sold ON transaction.car_id = cars_sold.car_id
                JOIN payment_type ON transaction.payment_id = payment_type.card_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameter
        //no parameter for this function

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //function to check if login info is correct

    /**
     * Function to validate the username and password submitted upon logging in as admin
     * @param $username username input from login page
     * @param $password password input from login page
     * @return mixed either returns null if not valid or the username and password that was entered
     * (returned password is returned as a hash for security)
     */
    function getLogin($username, $password)
    {
        //hashing the password to md5 to match what is in the database
        $password = md5($password);
        //1. Define the query
        $sql = "SELECT username, password FROM login
                WHERE username = :username and password = :password";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    //updating sold column in transactions

    /**
     * Funciton to update the transaction table to mark whether or not the sale was completed
     * @param $sold boolean value to tell whether the sale is completed or not
     * @param $tid transaction_id to know which row to update
     */
    function updateSold($sold, $tid)
    {
        //define the query
        $sql = "UPDATE transaction SET sold = :sold where transaction_id = :tid ";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind parameter
        $statement->bindParam(':sold', $sold);
        $statement->bindParam(':tid', $tid);

        //execute the statement
        $statement->execute();

    }

    //function to delete a transaction row
    //deleting both transaction and car id
    /**
     * Function to delete a row from both the transaction table and cars_sold table
     * @param $tid transaction_id to know which row to delete from transaction table. Uses
     * transaction_id to link to cars_sold to know which row to delete from this table as well
     */
    function deleteTran($tid)
    {
        //define the query
        $sql = "DELETE transaction, cars_sold from transaction
JOIN cars_sold WHERE transaction.car_id = cars_sold.car_id and transaction.transaction_id = :tid;";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind parameter
        $statement->bindParam(':tid', $tid);

        //execute the statement
        $statement->execute();


    }




}
