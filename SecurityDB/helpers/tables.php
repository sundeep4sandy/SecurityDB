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
                $query="select * from tables";
                $results=  mysql_query($query);
                if(!$results){
                    return NULL;
                }
                $tables=array();
                $i=0;
                while($row=  mysql_fetch_array($results)){
                    $tables[$i]=$row["Name"];
                    $i++;
                }
                mysql_close();
                echo json_encode($tables);
            }