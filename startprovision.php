<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>start provision</title>
<style>
                .borderOne{
                    padding: 15px;
                    border: 5px solid;
                    width: 700px;
                    height: 600px;
                    background-color: #9385ED;
                    color: #000000;
                    
                    position: fixed;
                    margin-left: 420px;
                }
                .image1{
                    border: 4px solid;
                    margin-left: 55px;
                    width: 580px;
                    height: 90px;
                }
                input.search{
                    width: 22em;  height: 4em;
                    margin-left: 210px;
                    border-radius: 12px;
                }
                
            </style>


</head>

<body bgcolor=#CFCED0>
    <div   class ="borderOne">
        
        <div class="image1" >
                <img  src="img/Gapps.png" />
        </div >
            <h1>
                <p>Create Organisation Units</p></br>
            </h1> 
        
        <p>Make sure the PathName exists on your domain for Organisation Units before you enter it. Enter Path format is "SWIFTA/STAFF" without the quotation mark</p></br>
    </br>
       <?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start(); 

if(isset($_GET['code'])){

echo "Successfully generated request code</br>";

//echo "<div id='txt1'>" . $_GET['code'] . "</div>" . "</br></br>";
$code =  $_GET['code'];

//echo "requesting for access token";
}
else{

echo "code generation failed";


}

?>








<?php 
if($_GET['state'] =="final" || $_GET['state'] =="group" || $_GET['state'] =="user"){
$url = 'https://accounts.google.com/o/oauth2/token';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_FAILONERROR, false);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded'
));

curl_setopt($ch, CURLOPT_POSTFIELDS,
    'code=' . urlencode($code) . '&' .
    'client_id=' . urlencode('630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com') . '&' .
    'client_secret=' . urlencode('RjvdVDT3umVO-Aj9Qtrnr8r8') . '&' .
    'redirect_uri=' . urlencode('http://localhost/gappsprovisioning/startprovision.php') . '&' .
    'grant_type=authorization_code'
);


// Send the request & save response to $resp
$resp = curl_exec($ch);
// Close request to clear up some resources


$json = json_decode($resp, true);
$access_token = $json['access_token'];
$refresh_token = $json['refresh_token'];


curl_close($ch);


if (isset($access_token)){

	//session_start();
	
	$_SESSION['access_token'] = $access_token;
	$_SESSION['refresh_token'] = $refresh_token;

echo "Refresh and Access tokens has been generated";

}




}

if($_GET['state'] == "group"){
echo "group";




$data3= "https://accounts.google.com/o/oauth2/auth?"; 

$data3 .="response_type=code&";
$data3 .="redirect_uri=" . urlencode("http://localhost/gappsprovisioning/startprovision.php") ."&";

$data3 .="client_id=630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com" ."&";

$data3 .="scope=" . urlencode("https://www.googleapis.com/auth/admin.directory.group") ."&"; #orgunit user


$data3 .="approval_prompt=force&";
$data3 .="state=user&"; # final group user
$data3 .="access_type=offline&";

$data3 .="include_granted_scopes=true"; #true


header('Location: ' . $data3);

}
if($_GET['state'] == "user"){
echo "org grant successfull";
echo "group grant successfull";



$data4= "https://accounts.google.com/o/oauth2/auth?"; 

$data4 .="response_type=code&";
$data4 .="redirect_uri=" . urlencode("http://localhost/gappsprovisioning/startprovision.php") ."&";

$data4 .="client_id=630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com" ."&";

$data4 .="scope=" . urlencode("https://www.googleapis.com/auth/admin.directory.user") ."&"; #orgunit user


$data4 .="approval_prompt=force&";
$data4 .="state=final&"; # final group user
$data4 .="access_type=offline&";

$data4 .="include_granted_scopes=true"; #true


header('Location: ' . $data4);
//enctype="multipart/form-data"
}



?> 
    </br>
    </br>
        

            <form  enctype="multipart/form-data" action="provision1.php?org=1" method="POST">
            <input type="file" name="file1" />
            <input type="submit" name="submit1" value="Provision First OrgUnit" />
        </form>
        </br>
        <form enctype="multipart/form-data" action="provision1.php?org=2" method="POST">
            <input type="file" name="file2"/>Enter Path
            <input type="text" name="path2" value=""/>
            <input type="submit" name="submit2" value="Provision Second OrgUnit"/>
        </form>
        </br>
        
<a href="createusers.php"> Create Users </a>
</div>
</body>
</html>