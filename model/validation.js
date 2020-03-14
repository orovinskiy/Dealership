

document.getElementById('pay').onsubmit = validate;

//All the regex and arrays used in validation
let phone = /^(\((\d{3})\)|(\d{3}))\s*[-\/.]?\s*(\d{3})\s*[-\/.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/;
let email = /^\w+[\w-.]*@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/;
let name = /^[a-z]{2,30}$/i;
let zip = /^\d{5}$/;
let cardNumber = /^\d{4}(-|\s)?\d{4}(-|\s)?\d{4}(-|\s)?\d{4}$/;
let fullName = /^[a-z]{2,30}\s[a-z]{2,30}$/i;
let cvv = /^\d{3}$/;
let states = ['AL','AK','AZ','AR', 'CA','CO','CT','DE','DC', 'FL','GA','HI','ID','IL','IN',
    'IA','KS','KY','LA','ME','MD', 'MA','MI','MN','MS','MO', 'MT','NE','NV','NH','NJ',
    'NM','NY','NC','ND','OH', 'OK','OR','PA','RI','SC', 'SD','TN','TX','UT','VT','VA',
    'WV','WI','WY','WA'];
let months = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
let years = ['2020','2021','2022','2023','2024','2025','2026'];

function validate(){
    let isValid = true;
    let errors = document.getElementsByClassName('javaErr');

    //Removes all the error messages
    for (let i = 0; i < errors.length; i++){
        errors[i].innerHTML = '';
    }
    window.scrollTo(0, 0);

    //Error messages
    let errorName = 'Only letters are allowed';
    let errorPhone = 'Only USA phone numbers allowed';
    let errorEmail = 'Make sure your email looks like this: example@mail.com';
    let errorAddy = 'Please provide an address';
    let errorCity = 'Please provide a city (Only letters allowed)';
    let errorState = 'Select a valid state';
    let errorZip = 'Can only be 5 numbers long';
    let errorCard = 'Must be 12 digits long';
    let errorMonth = 'Select a valid month';
    let errorYear = 'Select a valid year';
    let errorCVV = 'Must be 3 digits long';

    //Personal Info
    //Validates first name
    if(!validInput(name,$('span[id="fName"]'),$('input[id="firstName"]').val(),errorName)){ isValid = false}

    //Validates last name
    if(!validInput(name,$('span[id="lName"]'),$('input[id="lastName"]').val(),errorName)){ isValid = false}

    //Validates phone number
    if(!validInput(phone,$('span[id="phone"]'),$('input[id="phoneNumber"]').val(),errorPhone)){ isValid = false}

    //Validates Email
    if(!validInput(email,$('span[id="emailErr"]'),$('input[id="email"]').val(),errorEmail)){ isValid = false}

    //Checks if the address is empty
    if(!isEmpty($('span[id="addy"]'),$('input[id="address"]').val(),errorAddy)){ isValid = false}

    //Validates the city
    if(!validInput(name,$('span[id="cityErr"]'),$('input[id="city"]').val(),errorCity)){ isValid = false}

    //Validates the state. Makes sure its correct
    if(!validSelect($('span[id="stateErr"]'),$('select[id="state"]').val(),states,errorState)){ isValid = false}

    //Validates the zip code
    if(!validInput(zip,$('span[id="zipErr"]'),$('input[id="zipCode"]').val(),errorZip)){ isValid = false}

    //Card Info
    //Validates the name on the card
    if(!validInput(fullName,$('span[id="cardNameErr"]'),$('input[id="cardName"]').val(),errorName)){ isValid = false}

    //Validates the card number
    if(!validInput(cardNumber,$('span[id="cardNumErr"]'),$('input[id="cardNumber"]').val(),errorCard)){ isValid = false}

    //Validates the card expiration month
    if(!validSelect($('span[id="monthErr"]'),$('select[id="monthExp"]').val(),months,errorMonth)){ isValid = false}

    //Validates the cards expiration year
    if(!validSelect($('span[id="yearErr"]'),$('select[id="yearExp"]').val(),years,errorYear)){ isValid = false}

    //Validates the CVV code
    if(!validInput(cvv,$('span[id="cvvErr"]'),$('input[id="cvv"]').val(),errorCVV)){ isValid = false}

    return isValid;
}

function validInput(phoneRegex,error,input,errorMessage){
    input = input.trim();
    let match = new RegExp(phoneRegex);

    if(match.test(input)){
        return true;
    }
    error.html(errorMessage);
    return false;
}

function isEmpty(error,input,errorMessage){
    input = input.trim();
    if(input === ""){
        error.html(errorMessage);
        return false;
    }
    return true;
}

function validSelect(error,input,searchArray,errorMessage){
    input = input.trim();
    if(input === ""){
        return false;
    }

    if(searchArray.indexOf(input) === -1){
        error.html(errorMessage);
        return false;
    }
    return true;
}
