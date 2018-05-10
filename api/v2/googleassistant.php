<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';


// Get a dog
$dog = getRandomDog();

// Set to JSON output
header('Content-Type: application/json');

// Parse a string already created
$json = '{
    "contextOut": [],
    "data": {
        "google": {
            "expect_user_response": false,
            "is_ssml": true,
            "permissions_request": null
        }
    },
    "displayText": null,
    "messages": [
        {
            "speech": "Here\'s your dog image.",
            "type": 0
        },
        {
            "displayText": null,
            "platform": "google",
            "textToSpeech": "Here\'s your dog image.",
            "type": "simple_response"
        },
        {
            "buttons": [],
            "formattedText": "Dog ID: ' . $dog->id . '",
            "image": {
                "accessibilityText": "A picture of a dog",
                "url": "' . $dog->url . '"
            },
            "platform": "google",
            "title": null,
            "type": "basic_card"
        }
    ],
    "source": "webhook",
    "speech": "Here\'s your dog image."
}';
echo $json;


?>

