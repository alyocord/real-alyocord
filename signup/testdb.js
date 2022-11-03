/*
 * Filename: c:\Users\S5205544\real-alyocord\signup\testdb.js
 * Path: c:\Users\S5205544\real-alyocord
 * Created Date: Thursday, November 3rd 2022, 8:18:27 pm
 * Author: Aimee/Million1156
 * 
 * Copyright (c) 2022 Elym Holdings LLC
 */
// create an ec2 instance
/* var AWS = require('aws-sdk');
var ec2 = new AWS.EC2({
    apiVersion: '2022-08-10',
    params: {Bucket: 'alyocord-chat'}
});
// create a new ec2 instance
ec2.runInstances({
    ImageId: 'ami-0d5d9d301c853a04a',
    InstanceType: 't2.micro',
    MinCount: 1,
    MaxCount: 1
}, function(err, data) {
    if (err) { console.log("Could not create instance", err); return; }
    var instanceId = data.Instances[0].InstanceId;
    console.log("Created instance", instanceId);
    // Add tags to the instance
    params = {Resources: [instanceId], Tags: [
        {Key: 'Name', Value: 'SDK Sample'}
    ]};
    ec2.createTags(params, function(err) {
        console.log("Tagging instance", err ? "failure" : "success");
    });
});
// create a new dynamodb table
var db = new AWS.DynamoDB({
    apiVersion: '2022-08-10',
    params: {Bucket: 'alyocord-chat'}
});
// create a new table in the db
db.createTable({
    AttributeDefinitions: [
        {
            AttributeName: 'username',
            AttributeType: 'S'
        },
        {
            AttributeName: 'password',
            AttributeType: 'S'
        }
    ],
    KeySchema: [
        {
            AttributeName: 'username',
            KeyType: 'HASH'
        },
        {
            AttributeName: 'password',
            KeyType: 'RANGE'
        }
    ],
    ProvisionedThroughput: {
        ReadCapacityUnits: 5,
        WriteCapacityUnits: 5
    },
    TableName: 'alyocord-chat'
}, function(err, data) {
    if (err) {
        console.log("Error", err);
    } else {
        console.log("Table Created", data);
    }
}
// create a new s3 bucket
var s3 = new AWS.S3({
    apiVersion: '2021-03-01',
    params: {Bucket: 'alyocord-chat'}
});
// create a new bucket in the s3 bucket
s3.createBucket({
    Bucket: 'alyocord-chat'
}, function(err, data) {
    if (err) {
        console.log("Error", err);
    } else {
        console.log("Bucket Created", data.Location);
    }
}
// create a new lambda function
var lambda = new AWS.Lambda({
    apiVersion: '2022-08-10',
    params: {Bucket: 'alyocord-chat'}
});
// create a new lambda function
lambda.createFunction({
    Code: {
        ZipFile: 'var AWS = require('aws-sdk'); var s3 = new AWS.S3(); exports.handler = function(event, context) { var bucket = event.Records[0].s3.bucket.name; var key = event.Records[0].s3.object.key; var params = { Bucket: bucket, Key: key }; s3.getObject(params, function(err, data) { if (err) { console.log(err, err.stack); // an error occurred } else { console.log(data); // successful response } }); }'
    },
    FunctionName: 'alyocord-chat',
    Handler: 'index.handler',
    Role: 'arn:aws:iam::123456789012:role/lambda_basic_execution',
    Runtime: 'nodejs12.x',
    Timeout: 3,
    MemorySize: 128
}, function(err, data) {
    if (err) {
        console.log("Error", err);
    } else {
        console.log("Function Created", data.FunctionArn);
    }
}
*/
