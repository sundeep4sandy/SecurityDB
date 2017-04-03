<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$host="127.0.0.1";
            $username="root";
            $password="";
        
          
          
          $con=  mysql_connect($host,$username,$password);
            if($con){
                $db=  mysql_select_db('security',$con);
                $query="select * from user_accounts";
                $results=mysql_query($query);
                $accounts=array();
                $i=0;
                while($row=  mysql_fetch_array($results)){
                    $acc=array();
                    $acc['name']=$row["Name"];
                    $acc['phone']=$row["Phone"];
                    $acc['url']="update_accounts.php?id=".$row["ID"];
                    $role=$row["RoleName"];
                    if($role==NULL)
                        $acc['role']="Not Selected";
                    else
                        $acc['role']=$role;
                    $accounts[$i]=$acc;
                    $i++;
                }
                echo json_encode($accounts);
            }