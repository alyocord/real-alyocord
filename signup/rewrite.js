/*
 * Filename: c:\Users\S5205544\real-alyocord\signup\rewrite.js
 * Path: c:\Users\S5205544\real-alyocord
 * Created Date: Thursday, November 3rd 2022, 7:08:46 pm
 * Author: Aimee/Million1156
 * Do not use this as a reference for your own code, as it is not finished yet.
 * I will be working on this in the future, but for now, it is not finished.
 * If needed, this can be deleted. I am storing everything in the old github for now though since I feel like it.
 * Copyright (c) 2022 Elym Holdings LLC
 */
/* Commented out as code is not in use. Do not use this for the rewrite unless I say so. // import aws sdk  
const AWS = require('aws-sdk');
import { Auth } from 'aws-amplify'; // Testing if Amplify can be used in the future (as currently, the system we have is wack asf)
const s3 = new AWS.S3({
    apiVersion: '2021-03-01',
    params: {Bucket: 'alyocord-chat'}
});
const ddb = new AWS.DynamoDB({
    apiVersion: '2022-08-10',
    params: {Bucket: 'alyocord-chat'}
});
// create a function that will create a user
function signUp() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var email = document.getElementById("email").value;
    var defaultpfp = "https://alyocord.s3.us-east-1.amazonaws.com/default.png";
    var params = {
        Bucket: 'alyocord-chat',
        Key: 'profilePictures',
        Body: username,password,email,
        ContentType: 'text/plain'
    };
    s3.putObject(params, function(err, data) {
        if (err) {
            console.log(err, err.stack);
        } else {
            console.log(data);
        }
    });
    Auth.signUp({
        username: username,
        password: password,
        attributes: {
            email: email,
            profilePicture: defaultpfp
        }
    })
    .then(data => console.log(data))
    .catch(err => console.log(err));
}

// when the user has signed up, log them in using the credentials they just created
function signIn() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    Auth.signIn(username, password)
    .then(data => console.log(data))
    .catch(err => console.log(err));
}

// when the user has signed in, redirect them to the chat page
function redirect() {
    window.location.href = "https://alyocord.com/chat";
}

//make this all work together
function signUpAndSignIn() {
    signUp();
    signIn();
    redirect();
}
*/
