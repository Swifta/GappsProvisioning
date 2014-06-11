<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    
    <head>
        <meta charset="UTF-8">
        
        <title>GApps Provisioning Web App</title>
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
                <marquee ><p>Welcome to GAPPS Provisioning Web App</p></marquee>
            </h1> 
            <h2><p> Instructions </p></h2>
            <p>1. You must be an administrator with full priviledge on your domain</p>
            <p>2. To create organisations on your domain, enter the names according to the stage/level that you want to create.</p>
            <p>3. To create USERS, supply a text file with the format below</p>
            </br>
            </br>
            
            <?php
                    require_once 'Google/Client.php';

                    require_once 'Google/Service/Admin.php';

                     require_once 'Google/Service/Directory.php';
                    require_once 'Google/Http/Request.php';

                    //$client_id ="630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com";
                    //$client_secret ="RjvdVDT3umVO-Aj9Qtrnr8r8";
                    //$redirect_uri ="http://localhost/project/kay2.php";

                    //$client = new Google_Client();
                    //$client->setClientId($client_id);
                    //$client->setClientSecret($client_secret);
                    //$client->setRedirectUri($redirect_uri);
                    //$client->setScopes("https://www.googleapis.com/auth/admin.directory.user","https://www.googleapis.com/auth/admin.directory.orgunit");
                    //if(isset($_POST["launch"])){
                    //$authUrl = $client->createAuthUrl();
                        
                    //echo "Welcome to the Provisioning Web Application for Google Apps Admin";        
                    // put your code here
                    //}
                    $data ="https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri=http%3A%2F%2Flocalhost%2Fgappsprovisioning%2Fstartprovision.php";
                        $data2= "https://accounts.google.com/o/oauth2/auth?"; 

                        $data2 .="response_type=code&";
                        $data2 .="redirect_uri=" . urlencode("http://localhost/gappsprovisioning/startprovision.php") ."&";

                        $data2 .="client_id=630317041952-3t34uu44ojgtovsmno1ue88l82vnp1cb.apps.googleusercontent.com" ."&";

                        $data2 .="scope=" . urlencode("https://www.googleapis.com/auth/admin.directory.orgunit") ."&"; #orgunit user


                        $data2 .="approval_prompt=force&";
                        $data2 .="state=group&"; # final group user
                        $data2 .="access_type=offline&"; 

                        $data2 .="include_granted_scopes=true"; #true

                        $query_string = 'foo=' . urlencode($data);
                        echo '<h2><p><a href="'. $data2 .'" style="margin-left: 220px">Launch Application</a></p></h2></br></br>';
        ?>
        </div>
        
        
    </body>
</html>
