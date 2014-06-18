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
set_time_limit(0);
session_start();

$access = $_SESSION['access_token'];
$refresh = $_SESSION['refresh_token'];



function add_aliases(){
    global $org2, $databaseEmail, $path6, $access, $alias;
                    $matric1_no = preg_replace('/\//','',$org2[0]);
                    $alias = $matric1_no.'@'.$path6;
                 $aliases = array("alias"=>$alias);   
                $urlar = 'https://www.googleapis.com/admin/directory/v1/users/'.$databaseEmail.'/aliases' .  '?access_token=' . $access;
                            $char = curl_init($urlar);

                            curl_setopt($char, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($char, CURLOPT_FAILONERROR, false);
                            curl_setopt($char, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($char, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($char, CURLOPT_CONNECTTIMEOUT ,0);
                            curl_setopt($char, CURLOPT_TIMEOUT, 400);
                            curl_setopt($char, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                            ));
                            curl_setopt($char, CURLOPT_POSTFIELDS, json_encode($aliases));
                            $readResponse4 = curl_exec($char); 
                               $writeResponse4 = json_decode($readResponse4,TRUE);
                               //echo $writeResponse4;

                
}

function save_to_database(){
    global $org2, $databaseEmail,$level,$dbDept, $alias;
    
            
            $user_name = "root";
            $password = "";
            $database = "babcock_uni";
            $server = "127.0.0.1";
            
            
            $db_handle = mysql_connect($server, $user_name, $password);
            $db_found = mysql_select_db($database, $db_handle);

            if ($db_found) {

                $SQL = "INSERT INTO studentlist (Surname, Firstname, Alias, Email, Password, Matric_NO, Department, Level) VALUES ('$org2[1]','$org2[2]','$alias','$databaseEmail','$org2[5]','$org2[0]','$dbDept','$level')";

                $result = mysql_query($SQL);

                mysql_close($db_handle);

                //print "Records added to the database";

                }
                else {

                print "Database NOT Found ";
                mysql_close($db_handle);

                }

}

function modify_email(){
    global $access, $org2,$email,$path6,$ping4,$matric_no,$var,$var2,$var3,$databaseEmail;
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
                $primaryEmail1= $email1.$org2[1].'@'.$path6;
    }
    
    
    
    if($var >= $emailLength){
        $primaryEmail = $org2[2].$var3.'@'.$path6;;
    }else{
        $primaryEmail = $primaryEmail1;
    }
    
    $databaseEmail = $primaryEmail;
    
    $data3 = array("name"=>array("familyName" => $org2[1], "givenName"=>$org2[2]),"password" => $org2[5],"primaryEmail" =>$primaryEmail, "changePasswordAtNextLogin" => "TRUE", "orgUnitPath"=> $ping4, "phone"=>array("value"=>$matric_no));
                                

                            $urla = 'https://www.googleapis.com/admin/directory/v1/users/'.$primaryEmail.'?access_token=' . $access;
                    $cha = curl_init($urla);

                curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cha, CURLOPT_FAILONERROR, false);
                curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
               
                            
                            $respa2 = curl_exec($cha);

                             $kayRespa2 = json_decode($respa2,TRUE);
                             
                            if (isset($kayRespa2['error']['message'])){
                            //echo "AT LAST I got here";
                            //echo $primaryEmail;
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
                               //echo $writeResponse1;
                            
                        } else {
                            modify_email();
                               }
                            
}

function create_user(){
    
        global $access, $org2,$email,$path6,$ping4,$matric_no, $databaseEmail;
                                    
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

        $data2 = array("name"=>array("familyName" => $org2[1], "givenName"=>$org2[2]),"password" => $org2[5],"primaryEmail" =>$email[0].$org2[1].'@'.$path6, "changePasswordAtNextLogin" => "TRUE", "orgUnitPath"=> $ping4, "phone"=>array("value"=>$matric_no));

                            curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($data2));
                               $readResponse = curl_exec($cha); 
                               $writeResponse = json_decode($readResponse,TRUE);
                               //echo $email[0].$org2[1].'@'.$path6;
                               //echo $writeResponse;
                               $databaseEmail = $email[0].$org2[1].'@'.$path6;
    }                      


if(isset($_REQUEST['submit5'])){
    $target_path5 = "output1/";
    $databaseEmail = "";
    $target_path5 = $target_path5 . basename( $_FILES['file5']['name']); 
    echo $target_path5;
    if(move_uploaded_file($_FILES['file5']['tmp_name'], $target_path5)) {
        echo "The file ".  basename( $_FILES['file5']['name']). 
        " has been uploaded";
        
        
        $alias="";
        
        $path5 = "";
        $path5.= $_POST['path5'];
        $path5 = str_replace('"', "", $path5);
        $path5 = str_replace("'", "", $path5);
        //$ping4 .= $path5;
        
        
        
        $path6 = "";
        $path6.= $_POST['path6'];
        $path6 = str_replace('"', "", $path6);
        $path6 = str_replace("'", "", $path6);
        
        //trim($ping4);
        //$ping4 = preg_replace("/[\\n\\r]+/", "", $ping4);

        $file5=fopen("$target_path5","r");


        while(!feof($file5))
        {
                
                $var =0;
                $var2 = 0;
                $ping4 = "/";
                $org1  = fgets($file5);
                
                
                trim($org1);
                $org1 = preg_replace("/[\\n\\r]+/", "", $org1);

                $org2 = (array) explode(",",$org1);
               $org2[0] = trim($org2[0]);
               $org2[1] = trim($org2[1]);
               $org2[2] = trim($org2[2]);
               $org2[3] = trim($org2[3]);
               $org2[4] = trim($org2[4]);
               $org2[5] = trim($org2[5]);
               
               
               
               //to get the level and Dept, explode the path that was entered, $path5
                    $dbVar = (array) explode("/",$path5);
                    //$level= $dbVar[1];
                    $level = $org2[6];
                    $index = count($dbVar);
                    $dbDept= $dbVar[$index-1];
                    $dbVar[1] = $org2[6];
                    $truepath = implode ("/",$dbVar);
                    $ping4 .= $truepath;
                    trim($ping4);
                    $ping4 = preg_replace("/[\\n\\r]+/", "", $ping4);

                $email = (array)str_split($org2[2]);
                $matric_no = $org2[0];
                                
                $urla = 'https://www.googleapis.com/admin/directory/v1/users/'.$email[0].$org2[1].'@'.$path6 .'?access_token=' . $access;
                $cha = curl_init($urla);

                curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cha, CURLOPT_FAILONERROR, false);
                curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
                

                $respa1 = curl_exec($cha);

                $kayRespa1 = json_decode($respa1,TRUE);
                
               
                 
                       if (isset($kayRespa1['error']['message'])){
                            
                                    if($kayRespa1['error']['message'] === 'Invalid Credentials'){




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
                                                         'client_id=' . urlencode('630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com') . '&' .
                                                         'client_secret=' . urlencode('RjvdVDT3umVO-Aj9Qtrnr8r8') . '&' .
                                                         'refresh_token=' . urlencode($refresh) . '&' .
                                                         'grant_type=refresh_token'
                                         );


                                         // Send the request & save response to $resp
                                         $respert = curl_exec($ch);
                                         // Close request to clear up some resources
                                         echo $respert. "</br></br>";



                                         $kayRespa12 = json_decode($respert, true);
                                         $_SESSION['access_token'] = $kayRespa12['access_token'];
                                         $access = $_SESSION['access_token'];



                                         //retry previous call

                                         $urla = 'https://www.googleapis.com/admin/directory/v1/users/'.$email[0].$org2[1].'@'.$path6 .'?access_token=' . $access;
                                         $cha = curl_init($urla);

                                         curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                                         curl_setopt($cha, CURLOPT_FAILONERROR, false);
                                         curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                                         curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');


                                         $respa1 = curl_exec($cha);

                                         $kayRespa1 = json_decode($respa1,TRUE);

                                
                                    }else{

                                        create_user();
                                        //echo "I've created It";
                                        add_aliases();
                                        save_to_database();
                                    }
                            
                        } else {
                            modify_email();
                            add_aliases();
                            save_to_database();
                               }

        }
fclose($file5);
   echo "I've created It";     
    } else{
            echo "There was an error uploading the file, please try again!";
          }
        
	
}

?>

<a href="index.php">Back </a> </br>
</div>
</body>
</html>
