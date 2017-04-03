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
                $query="select * from privileges";
                $results=  mysql_query($query);
                if(!$results){
                    return NULL;
                }
                $privileges=array();
                $i=0;
                while($row=  mysql_fetch_array($results)){
                    $temp=array();
                    $temp['name']=$row['Name'];
                    $temp['type']=$row['type'];
                    $temp['description']=$row['description'];
                    $privileges[$i]=$temp;
                    $i++;
                }
                echo json_encode($privileges);
            }