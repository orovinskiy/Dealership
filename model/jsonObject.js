$(document).ready(function(){
    $.getJSON('model/cars.json',function(info){
        let i = 0;
        let j = 0;
        while(i < 10 && j < info.length){
            if(!info[j][0]['Sold'][0]){
                console.log(info[j][0]['Sold']);
                $.post("model/objectHandler.php",info[j],function(result){
                    $(".col-12").html(result);
                });
                for( let engine in info[i]['Engine Information']){
                    if(typeof(info[i]['Engine Information'][engine]) !== 'object')
                        console.log(engine+" : "+info[i]['Engine Information'][engine]);
                    else{
                        for(let power in info[i]['Engine Information'][engine]){
                            console.log(power+" : "+info[i]['Engine Information'][engine][power]);
                        }
                    }
                }
                console.log(j+"---------------------");
                j++;
                i++;
            }
            else{
                j++;
            }
        }
        //console.log(info);
    });
});

