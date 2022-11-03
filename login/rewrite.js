/*
 * Filename: c:\Users\S5205544\real-alyocord\login\rewrite.js
 * Path: c:\Users\S5205544\real-alyocord
 * Created Date: Thursday, November 3rd 2022, 5:38:47 pm
 * Author: Aimee/Million1156
 * Purpose: Rewrite the login page to be more user friendly, less buggy, and more efficient to edit.
 * Copyright (c) 2022 Elym Holdings LLC
 */
/* // import the aws sdk
var AWS = require('aws-sdk');
var s3 = new AWS.S3();
var db = new AWS.DynamoDB();
var ec2 = new AWS.ec2();

// import our aws secrets
var awsSecrets = require('./aws-secrets.json'); // grab our aws secrets from the json (this will be hidden in production envs for obvious reasons).
// set the region
AWS.config.update({region: 'us-east-1'}); // always set to us-east-1 because that's where the database is
// create the DynamoDB service object
var ddb = new AWS.DynamoDB({apiVersion: '2012-08-10'}); // ddb is old, what can i tell ya..
var params = { // create the params for calling createTable
    TableName: 'alyocord-chat',
    Item: {
        'username' : {S: username},
        'password' : {S: password.unhash()},
        'profilePicture' : {S: pfp},
        'email' : {S: email},
        'friends' : {S: friendslist},
        'friendRequests' : {S: friendRequests},
        'friendRequestsSent' : {S: friendRequestsSentId},
        'blockedUsers' : {S: blockedUsers},
        'blockedBy' : {S: 'notimplemented'},
        'status' : {S: userstatus},
        'statusMessage' : {S: statusMsg},
        'lastOnline' : {S: lastOnlineUTC}, // Format: '2022-11-03T17:38:47.000Z'
        'lastSeen' : {S: lastSeenUTC}, // Same format as before, this is done because the user can appear invisible. It's nice to store when they last ACTUALLY got online and right before they went invisible.
        'lastMessage' : {S: lastMsgUTC}, // This is the last message the user sent. This is helpful incase we ever implement an "unread" feature like Discord.
    }};
ddb.putItem(params, function(err, data) {
    if (err) {
        console.log("Error", err);
    } else {
        console.log("Success", data);
            
    }
});

// process login when the user clicks the login button
function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var params = {
        Bucket: 'database',
        Key: 'database.sqlite',
        Body: username, password,
        ContentType: 'text/plain'
    };
    db.putObject(params, function(err, data) {
        if (err) {
            console.log(err, err.stack);
        } else {
            console.log(data);
        }
    });
} */
