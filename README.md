# Dealership
A website to buy cars
Created by Dallas and Oleg
- LOGIN TO ADMIN username: admin, password: @dm1n

## MVC Separation
- All the files are broken up between model, views, and classes

- All extra files are organized in separate directories and 
clearly stated what the files are
## Routes
- Each route to a page is defined in the controller
class using the fat free object to reroute or give errors

- Each html file is loaded through the Template class
## PDO
- in the database class a PDO object is created to delete,
update or insert data into our tables

- We have a buyers, cars_sold, payment_ype, transaction, and login tables
## Data Manipulation
- In our admin-page you can uncheck or check if the payment has been 
completed (Update data)

- You can check all the rows you want and then delete them (Delete data)

- All the data is put into data tables which is read straight from a database (View data)

- Any valid buyer information entered will be stored into the database
and displayed on the admin page (Add data)
## Commits
- All our commits are spread between each others branches and master
## OOP
- Has validation, database, controller classes

- database class is used within controller
## Comments
- All our code is commented and has headers for each file
##Validation
- Data is validated through server side in the controller class
which uses the validation class

- Data is also validated through javascript in the validation.js file
## JSON File
- We use a JSON file that's full of cars to determine which cars to show

- We write to the JSON file as well and modified it with extra fields

- The sold cars information is then added to the database to a specific buyer
