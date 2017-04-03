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
                $query="select * from user_roles";
                $results=  mysql_query($query);
                if(!$results){
                    return null;
                }
                 $i=0;
                while($row=  mysql_fetch_array($results)){
                    $roles[$i]=$row["RoleName"];
                    $i++;
                }
                $role_privileges=array();
                $j=0;
                for($i=0;$i<count($roles);$i++){
                    $query1="select Name,type from privileges where rolename='$roles[$i]'";
                    $res=mysql_query($query1);
                    $temp="";
                    
                    while($row=  mysql_fetch_array($res)){
                        $temp=$temp.$row["Name"].",";
                    }
                    $temp1=rtrim($temp,",");
                    
                    $temp2=array();
                    $temp2['role']=$roles[$i];
                    $temp2['privileges']=$temp1;
                    $role_privileges[$j]=$temp2;
                    $j++;
                }
                echo json_encode($role_privileges);
            }