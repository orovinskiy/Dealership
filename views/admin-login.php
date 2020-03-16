<?php
//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

?>
<include href="views/navbar.html">


        <div class="jumbotron text-center"> <!-- Header -->
            <h1 class="display-4">Admin Login</h1>
            <p>Admins, Please login below</p>
        </div>
        <div class="container divCol text-center"> <!--full form div -->
            <form method="post" action="#">
                <div class="form-group mt-2">
                    <label class="h2" for="username">Username: </label>
                    <input class="" type="text" id="username" name="username">
                    <check if="{{ @errors['username'] }}">
                        <p class="err-validate">{{ @errors['username'] }}</p>
                    </check>

                </div>

                <div class="form-group">
                    <label class="h2"  for ="password">&nbsp;Password:</label>
                    <input type="password" id="password" name="password">
                    <check if="{{ @errors['password'] }}">
                        <p class="err-validate">{{ @errors['password'] }}</p>
                    </check>

                </div>
                <button class="btn btn-primary mb-3" type="submit" id="login" name="submit" value="submit">Login</button>
                <check if ="{{ @loginError }}">
                    <p class="err-validate">{{ @loginError }}</p>
                </check>
            </form>
        </div>

