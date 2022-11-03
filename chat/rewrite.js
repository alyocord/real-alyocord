/*
 * Filename: c:\Users\user\real-alyocord\chat\rewrite.js
 * Path: c:\Users\user\real-alyocord
 * Created Date: Thursday, November 3rd 2022, 5:18:02 pm
 * Author: Aimee/Million1156
 * 
 * Copyright (c) 2022 Elym Holdings LLC
 * Purpose: Rewrite the chat to be more user friendly, less buggy, and more efficient to edit.
*/

// make an s3 connection to the chat server
var s3 = new AWS.S3({
    apiVersion: '2021-03-01',
    params: {Bucket: 'alyocord-chat'}
});
// get the chat log from the s3 bucket
s3.getObject({Key: 'chatlog.txt'}, function(err, data) {
    if (err) {
        console.log(err, err.stack);
    } else {
        console.log(data);
    }
});
// read the database 
var db = new AWS.DynamoDB({
    apiVersion: '2022-08-10',
    params: {Bucket: 'alyocord-chat'}
});
// read the db table from the bucket named alyocord-chat
db.getItem({Key: 'database.sqlite'}, function(err, data) {
    if (err) {
        console.log(err, err.stack);
    } else {
        console.log(data);
    }
});

// when a user sends a message, it will be sent to the s3 bucket
function send() {
    var message = document.getElementById("message").value;
    var username = document.getElementById("username").value;
    var params = {
        Bucket: 'alyocord-chat',
        Key: 'chatlog.txt',
        Body: message,
        ContentType: 'text/plain'
    };
    s3.putObject(params, function(err, data) {
        if (err) {
            console.log(err, err.stack);
        } else {
            console.log(data);
        }
    });
}

// if a profile picture is updated, it will be sent to the dynamodb table and s3 bucket
function updateProfilePicture() {
    var profilePicture = document.getElementById("profilePicture").value;
    var params = {
        Bucket: 'alyocord-chat',
        Key: 'database.sqlite',
        Body: profilePicture,
        ContentType: 'image/png'
    };
    s3.putObject(params, function(err, data) {
        if (err) {
            console.log(err, err.stack);
        } else {
            console.log(data);
        }
    });
}

// list all dynamodb tables
db.listTables({}, function(err, data) {
    if (err) {
        console.log(err, err.stack);
    } else {
        console.log(data);
    }
});

// internally print the chat log to the console if debug mode is enabled
function debug() {
    console.log("Chat log: " + s3.getObject({Key: 'chatlog.txt'}, function(err, data) {
        if (err) {
            console.log(err, err.stack);
        } else {
            console.log(data);
        }
    }));
}