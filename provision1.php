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
        

<?php

session_start();

#echo $_SESSION['access_token'];
//echo "Create organisation units" . "</br></br></br>";

//echo $_SESSION['access_token'] . "</br></br></br>";

$access = $_SESSION['access_token'];
#echo "reading files" . "</br></br>";



?>

<?php
#create main organisation unit student.aaua.edu.ng

if($_GET['org'] == 1){

echo "Checking primary organisation if group (file 1) exist:" . "</br></br>";
$target_path1 = "output1/";
//$_SESSION['path'] = $target_path;
$target_path = $target_path1 . basename( $_FILES['file1']['name']); 
//echo $target_path;
if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['file1']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}

$file=fopen($target_path,"r");
$org1 = fgets($file);
trim($org1);
$org1 = preg_replace("/[\\n\\r]+/", "", $org1);
fclose($file);


$url = 'https://www.googleapis.com/admin/directory/v1/customer/my_customer/orgunits/' . $org1 .  '?access_token=' . $access;
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_FAILONERROR, false);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 


// Send the request & save response to $resp
$resp = curl_exec($ch);
$json = json_decode($resp, true);

#echo $respo;

if (isset($json["name"])){
$respo = $json["name"];
echo $respo . ":	organisation unit exist.</br>"; 
}

elseif($json['error']['message'] === 'Org unit not found') {

//echo $org1 . ":	Organisation unit does not exist on google apps" . $json['error']['message']. "</br></br>";

//create new org
$urla = 'https://www.googleapis.com/admin/directory/v1/customer/my_customer/orgunits' .  '?access_token=' . $access;
$cha = curl_init($urla);

curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cha, CURLOPT_FAILONERROR, false);
curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'POST');

curl_setopt($cha, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
));

$data = array("name" => "$org1","The sales support team" => "description", "parentOrgUnitPath" => "/","blockInheritance" => "false");

curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($data)
);



$respa = curl_exec($cha);

echo $org1. " Organization unit has been created.".'</br>';
echo $respa;




}
else {
	
	echo $json['error']['message'];
}


}
?>


<?php

if($_GET['org'] == 2){
#create main organisation unit student.aaua.edu.ng
    
    
$target_path2 = "output1/";

$target_path2 = $target_path2 . basename( $_FILES['file2']['name']); 
echo $target_path2;
if(move_uploaded_file($_FILES['file2']['tmp_name'], $target_path2)) {
    echo "The file ".  basename( $_FILES['file2']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}


//echo "provision sub orginazations</br></br>"; 
	
//$file1=fopen("$target_path1","r");
//while(!feof($file1))
//{
$ping1 = "/";
$path2 = "";
$path2.= $_POST["path2"];
$path2 = str_replace('"', "", $path2);
$path2 = str_replace("'", "", $path2);
$ping1 .= $path2;
echo $ping1."</br>";

trim($ping1);
$ping1 = preg_replace("/[\\n\\r]+/", "", $ping1);



echo $ping1;
	$file2=fopen("$target_path2","r");
	while(!feof($file2))
	{
		$org1  = fgets($file2);
		trim($org1);
		$org1 = preg_replace("/[\\n\\r]+/", "", $org1);
		//create new org for sub group 2
		$urla = 'https://www.googleapis.com/admin/directory/v1/customer/my_customer/orgunits' .  '?access_token=' . $access;
		$cha = curl_init($urla);
		
		curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cha, CURLOPT_FAILONERROR, false);
		curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'POST');
		
		curl_setopt($cha, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json'
		));
		
		$data = array("name" => "$org1","description" => "$org1", "parentOrgUnitPath" => "$ping1","blockInheritance" => "false");
		
		curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($data)
		);
		
		
		
		$respa = curl_exec($cha);
		
		
		echo $respa;
	}
	fclose($file2);
	
	
	
	
}
//fclose($file1);
//}
?>


        
        
        </br>
        <a href="index.php">Back </a> </br>
        <a href="createusers.php"> Create Users </a>
    </br>
        
</div>
</body>
</html>
