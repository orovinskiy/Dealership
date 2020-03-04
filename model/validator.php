<?php


/**
 * Class for validation
 */
class Validator
{
    private $_errors;

    function __construct()
    {
        $this->_errors = array();
    }

    function getErrors()
    {
        return $this->_errors;
    }

    function validForm()
    {
        //to be filled out
        $this->validFirst($_POST['firstName']);
        $this->validLast($_POST['lastName']);
        $this->validNumber($_POST['phoneNumber']);
        $this->validEmail($_POST['email']);
        $this->validAddress($_POST['address']);
        $this->validCity($_POST['city']);
        $this->validState($_POST['state']);
        $this->validZip($_POST['zipCode']);
        $this->validName($_POST['cardName']);
        $this->validCardNumber($_POST['cardNumber']);
        $this->validMonth($_POST['monthExp']);
        $this->validYear($_POST['yearExp']);
        $this->validCVV($_POST['cvv']);

        //If the $errors array is empty, then we have valid data
        return empty($this->_errors);

    }

    private function validFirst($first)
    {
        //First name are required
        if (empty($first)){
            $this->_errors['first'] = "First name is required";
        }
    }

    private function validLast($last)
    {
        //First name are required
        if (empty($last)){
            $this->_errors['last'] = "Last name is required";
        }
    }

    private function validNumber($number)
    {
        //remove basic phone characters
        $number = str_replace(" ", "", $number);
        $number = preg_replace('/-/', "", $number);
        $number = preg_replace('/\(/', "", $number);
        $number = preg_replace('/\)/', "", $number);
        $number = preg_replace('/_/', "", $number);
        //echo "<p>$id</p>"; for de-bugging purposes

        if(empty($number) || !ctype_digit($number) || strlen($number) != 10){
            $this->_errors['number'] = "Valid contact number is required";
        }

    }

    private function validEmail($email)
    {
        if(empty($email) && !preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email)){
            $this->_errors['email'] = "Valid email is required";
        }
    }

    private function validAddress($address)
    {
        if(empty($address)){
            $this->_errors['address'] = "Address is required";
        }
    }

    private function validCity($city)
    {
        if(empty($city)){
            $this->_errors['city'] = "City is required";
        }
    }

    private function validState($state)
    {
        if($state === "none"){
            $this->_errors['state'] = "State is required";
        }
    }

    private function validZip($zip)
    {
        if(empty($zip) || !ctype_digit($zip)){
            $this->_errors['zip'] = "Zip code is required";
        }
    }

    private function validname($name)
    {
        if(empty($name)){
            $this->_errors['name'] = "Name on card is required";
        }
    }

    private function validCardNumber($cardNumber)
    {
        if(empty($cardNumber) || !ctype_digit($cardNumber) || strlen($cardNumber) != 16){
            $this->_errors['cardNumber'] = "Valid card number is required";
        }
    }

    private function validMonth($month)
    {
        if($month === "none"){
            $this->_errors['month'] = "Expiring month is required";
        }
    }

    private function validYear($year)
    {
        if($year === "none"){
            $this->_errors['year'] = "Expiring year is required";
        }
    }

    private function validCVV($cvv)
    {
        if(empty($cvv) || !ctype_digit($cvv) || strlen($cvv) != 3){
            $this->_errors['cvv'] = "Valid CVV number is required";
        }
    }
}