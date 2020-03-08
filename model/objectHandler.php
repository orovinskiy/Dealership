<?php

//error reporting..
ini_set("display_errors", 1);
error_reporting(E_ALL);

//$key = array_key_first($_POST);
//var_dump($_POST); '.$_POST["key"].'
echo '
        <section class="text-dark mb-5 card">
            <img class="card-img-top img-fluid" 
            src="images/carPics/'.$_POST["Identification"]["Make"].'.jpg" alt="LinkedIn Profile">
            <div class="card-body">
                <h3 class="card-title">'.$_POST["Identification"]["Model Year"].'</h3>
                <p class="card-text"></p>
                <p class="card-text">This bad boy is '.$_POST["Engine_Information"]["Driveline"].' and
                 its horsepower is at '.$_POST["Engine_Information"]["Engine Statistics"]["Horsepower"].'.
                 Still not sold? Click the button below for more information!
                 </p>
                <div class="card-footer">
                    <form action="buy/'.$_POST["key"].'" method="post">
                        <button class="text-light card-link btn btn-dark btn-block" type="submit">Go to Page</button>
                    </form>
                </div> 
            </div>
        </section> <!-- Card -->
    
        ';