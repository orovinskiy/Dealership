/**
 * This gets all the cars that have not been sold yet and
 * populates the listing page. It sends the json information
 * to objectHandler.php then recieves back html which it then puts
 * into specific divs.
 * @author Oleg Rovinskiy
 * @version 1.0
 */

//This makes sure the html is all loaded before populating it with cars
$(document).ready(function(){

    /**
     * This function checks for 10 cars that are not sold then it
     * puts them into the listings page
     */
    function getCars(){
        $.getJSON('model/cars.json',function(info){

            //this gets 10 different cars
            let i = 0;
            //this makes sure we get the cars that are not sold
            let j = 0;
            //this iterates throw each div
            let index = 0;

            while(i < 10 && j < info.length){
                if(!info[j]['Sold']){
                    //console.log(info[j][0]['Sold']);
                    info[j].key = j;


                    $.post("model/objectHandler.php",info[j],function(result){
                        $("#car"+index).html(result);
                        console.log(index);
                        index++;
                    });
                    j++;
                    i++;
                }
                else{
                    j++;
                }
            }
        });
    }

    getCars();

    //repopulates the page each 30 minutes making sure all the
    //cars are up to date
    setInterval(function(){
       getCars();
    },300000);

});

