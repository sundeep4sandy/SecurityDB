<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$account=  filter_input(INPUT_GET, 'account');
if(isset($account)){
    $host="127.0.0.1";
            $username="root";
            $password="";
        
          
          
          $con=  mysql_connect($host,$username,$password);
            if($con){
                $db=  mysql_select_db('security',$con);
                $query1="select RoleName from user_accounts where Name='$account'";
                $res=  mysql_query($query1);
                if(!$res){
                    return NULL;
                }
                $row=  mysql_fetch_row($res);
                $role=$row[0];
                $query1="select Name,type from privileges where rolename='$role'";
                $res1=  mysql_query($query1);
                if(!$res1){
                    return NULL;
                }
                $privileges="";
                while($row1=  mysql_fetch_array($res1)){
                    $privileges=$privileges.$row1["Name"].",";
                }
                $temp=  rtrim($privileges,",");
                echo json_encode($temp);
            }
}