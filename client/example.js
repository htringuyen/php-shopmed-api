// suppose this is the page that show user's cart items
// Please follow timestamp below

// import JWTClient for making request
import {jwtClient, JWTClient} from "./JWTClient.js";


/************ Timestamp: 0 *****************/
// The page is loaded
// Because this is protected page, check if the refresh token is still valid

if (!jwtClient.stillHasTokenAfter(7200)) { // if token is not valid after 7200 seconds, redirect to login page
    // redirect to login page
    // because this is example, we will login here
    if (await jwtClient.login("dr_john", "hashed_password")) {
        console.log("Login successful...");
    }
    else {
        console.log("Login failed...");
    }
    /***** BIG NOTE: In actually situation, redirect to login page. This is just example *****/
}
else {
    console.log("Token is still valid... no need to login...");
}

/************ Timestamp: 1 *****************/
// make request to server to get cart items
const data = await jwtClient.fetch("/dev/cart")
    .then(response => response.json());

// or you can also use
// const data = await jwtClient.fetchJson("dev/cart");

// do something with data
// ...
console.log(data);


