import {JWTClient} from "./JWTClient.js";


const jwtClient = new JWTClient(
    "http://localhost:8001", "/auth/login", "/auth/refresh");

async function requestData() {
    const response = await jwtClient.fetch("/dev/cart");
    const data = await response.json();
    console.log(data);
}

const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// login
console.log("Attempting login...");
if (await jwtClient.login("dr_john", "hashed_password")) {
    console.log("Login successful...");
}

// repeatedly request data
for (let i = 0; i < 10; i++) {
    await requestData();
    await sleep(5000);
}


