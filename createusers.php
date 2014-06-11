<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Create Users</title>
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
                <p>Create Users</p></br>
            </h1> 
        
        

    <form  enctype="multipart/form-data" action="createusers.php" method="POST">
            <input type="file" name="file5"/>Enter Path
            <input type="text" name="path5" value=""/> </br>Enter Domain name (e.g swifta.com)<input type="text" name="path6" value=""/></br>
            <input type="submit" name="submit5" value="Create Users" />
    </form>    
</br>


<?PHP

session_start();

$access = $_SESSION['access_token'];

function modify_email(){
    global $access, $org2,$email,$path6,$ping4,$matric_no,$var,$var2,$var3;
    $emailLength = count($email);
    
    $emailcast = $email;
    $var = $var +1;
    
    if ($var >= $emailLength){
        
        $var2 = $var2 + 1;
                for($i=0; $i<$var2;$i++){
                $var3 = $org2[1].($i+1); 
                
                }
        
    }else{
               
                for($i=0; $i<$var;$i++){
                $emailcast[0].=$emailcast[$i+1]; 
                } 
                $email1 = $emailcast[0];
                $primaryEmail1= $email1.".".$org2[1].'@'.$path6;
    }
    
    
    
    if($var >= $emailLength){
        $primaryEmail = $org2[2].".".$var3.'@'.$path6;;
    }else{
        $primaryEmail = $primaryEmail1;
    }
    
    
    //$primaryEmail = $email1.".".$var3.'@'.$path6;
    $data3 = array("name"=>array("familyName" => $org2[1], "givenName"=>$org2[2]),"password" => $org2[2].$org2[1],"primaryEmail" =>$primaryEmail, "changePasswordAtNextLogin" => "TRUE", "orgUnitPath"=> $ping4, "phone"=>array("value"=>$matric_no));
                                

                            $urla = 'https://www.googleapis.com/admin/directory/v1/users/'.$primaryEmail.'?access_token=' . $access;
                    $cha = curl_init($urla);

                curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cha, CURLOPT_FAILONERROR, false);
                curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
               
                            
                            $respa2 = curl_exec($cha);

                             $kayRespa2 = json_decode($respa2,TRUE);
                             
                            if (isset($kayRespa2['error']['message'])){
                            echo "AT LAST I got here";
                            echo $primaryEmail;
                            $urla = 'https://www.googleapis.com/admin/directory/v1/users' .  '?access_token=' . $access;
                            $cha = curl_init($urla);

                            curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($cha, CURLOPT_FAILONERROR, false);
                            curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($cha, CURLOPT_CONNECTTIMEOUT ,0);
                            curl_setopt($cha, CURLOPT_TIMEOUT, 400);
                            curl_setopt($cha, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                            ));
                            curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($data3));
                            $readResponse1 = curl_exec($cha); 
                               $writeResponse1 = json_decode($readResponse1,TRUE);
                               echo $writeResponse1;
                            
                        } else {
                            modify_email();
                               }
                            
}

function create_user(){
    
        global $access, $org2,$email,$path6,$ping4,$matric_no;
                                    
                            $urla = 'https://www.googleapis.com/admin/directory/v1/users' .  '?access_token=' . $access;
                            $cha = curl_init($urla);

                            curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($cha, CURLOPT_FAILONERROR, false);
                            curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($cha, CURLOPT_CONNECTTIMEOUT ,0);
                            curl_setopt($cha, CURLOPT_TIMEOUT, 400);
                            curl_setopt($cha, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                            ));

        $data2 = array("name"=>array("familyName" => $org2[1], "givenName"=>$org2[2]),"password" => $org2[2].$org2[1],"primaryEmail" =>$email[0].".".$org2[1].'@'.$path6, "changePasswordAtNextLogin" => "TRUE", "orgUnitPath"=> $ping4, "phone"=>array("value"=>$matric_no));

                            curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($data2));
                               $readResponse = curl_exec($cha); 
                               $writeResponse = json_decode($readResponse,TRUE);
                               echo $email[0].".".$org2[1].'@'.$path6;
                               echo $writeResponse;
    }                      


if(isset($_REQUEST['submit5'])){
    $target_path5 = "output1/";

    $target_path5 = $target_path5 . basename( $_FILES['file5']['name']); 
    echo $target_path5;
    if(move_uploaded_file($_FILES['file5']['tmp_name'], $target_path5)) {
        echo "The file ".  basename( $_FILES['file5']['name']). 
        " has been uploaded";
    } else{
            echo "There was an error uploading the file, please try again!";
          }

        $ping4 = "/";
        $path5 = "";
        $path5.= $_POST['path5'];
        $path5 = str_replace('"', "", $path5);
        $path5 = str_replace("'", "", $path5);
        $ping4 .= $path5;

        $path6 = "";
        $path6.= $_POST['path6'];
        $path6 = str_replace('"', "", $path6);
        $path6 = str_replace("'", "", $path6);

        trim($ping4);
        $ping4 = preg_replace("/[\\n\\r]+/", "", $ping4);

        $file5=fopen("$target_path5","r");


        while(!feof($file5))
        {
                
                $var =0;
                $var2 = 0;
                
                $org1  = fgets($file5);
                
                
                trim($org1);
                $org1 = preg_replace("/[\\n\\r]+/", "", $org1);

                $org2 = (array) explode(",",$org1);
               

                $email = (array)str_split($org2[2]);
                $matric_no = $org2[0];
                                
                $urla = 'https://www.googleapis.com/admin/directory/v1/users/'.$email[0].".".$org2[1].'@'.$path6 .'?access_token=' . $access;
                $cha = curl_init($urla);

                curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cha, CURLOPT_FAILONERROR, false);
                curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
                

                $respa1 = curl_exec($cha);

                $kayRespa1 = json_decode($respa1,TRUE);
                
               
                 
                       if (isset($kayRespa1['error']['message'])){
                            
                            create_user();
                            echo "I've created It";
                        } else {
                            modify_email();
                               }

        }
fclose($file5);
	
}

?>

<a href="index.php">Back </a> </br>
</div>
</body>
</html>
