<?php

function send_mail($to) {
//The url you wish to send the POST request to
$url = "http://localhost:5001/mail/send";

//The data you want to send via POST
$fields = [
	'subject'      => "Deelnemen aan de speurtocht",
	'html' 		   => "<html>test</html>",
	'text'         => '',
	'to'		   => "$to",
	'from'		   => "p11k3t@lesonline.nu"
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post\
$result = curl_exec($ch);
echo $result;
}