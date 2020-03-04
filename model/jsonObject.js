$(document).ready(function(){

    function getCars(){
        $.getJSON('model/cars.json',function(info){

            //this gets 10 different cars
            let i = 0;
            //this makes sure we get the cars that are not sold
            let j = 0;
            //this iterates throw each div
            let index = 0;

            while(i < 10 && j < info.length){
                if(!info[j][0]['Sold'][0]){
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
            console.log(info);
        });
    }

    getCars();

    setInterval(function(){
       getCars();
    },300000);

});

