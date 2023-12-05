# Dat Hang: Luu Do Giai Thuat
DataHangAlgo at: https://docs.google.com/document/d/1hF4Fq4SAoDQJfXBvJ9qbX-d97abjjam0Esy7aqzyCmg/edit?usp=sharing

# Slimmvc docs
Read the documentation of custom framework at: https://docs.google.com/document/d/1m_5TR5PAt9_EF-MQhtRRYaiR1doNU1Sz9QfnTEeec00/edit?usp=sharing

# run the app

## Setup database
- run scripts in directory sql to create database shopmed and populate testing data
- go to the file /config/database.php to check configurations

## Run server
- go to the file composer.json and install required package, in JetBrains IDE just click 'Install' for all setup
- run the command 'serve' inside 'scrip' section of composer.json to run php built-in server
- request to http://localhost:8001 to check the successfull installing message 'Hello World'

## Play Example with Postman
- go to Postman or other http-exchange tools
- make post request to http://localhost:8001/dev/login with Authorization Header set to Basic and username/password get from database
- make get request to http://localhost:8001/dev/cart with Authorization Header set to Bearer and token get from above step

## write first endpoint
- go to /app/Controller directory and create Controller class to handle some event (reference example controllers)
- go to /app/routes.php file and define the endpoint that will be handled by above Controller
- test new endpoint with any http exchange tool
