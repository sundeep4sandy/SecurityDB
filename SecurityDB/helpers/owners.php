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
                if(!$results){
                    return NULL;
                }
                $owners=array();
                $i=0;
                while($row=  mysql_fetch_array($results)){
                    $owners[$i]=$row["Name"];
                    $i=$i+1;
                }
                echo json_encode($owners);
            }