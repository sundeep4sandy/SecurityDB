<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Privileges</title>
    </head>
    <body>
        <?php
        // put your code here
        include 'nav.php';
        $host="127.0.0.1";
            $username="root";
            $password="";
        
            $privilege=  filter_input(INPUT_POST,'privilege');
            $desc=  filter_input(INPUT_POST, 'description');
            $type=  filter_input(INPUT_POST, 'type');
            $role=  filter_input(INPUT_POST, 'role');
            $table=filter_input(INPUT_POST,'table');
            
            $submit=filter_input(INPUT_POST,'submit');
            if(isset($submit)){
                 $con=  mysql_connect($host,$username,$password);
                    if($con){
                        $db=  mysql_select_db('security',$con);
                        if($type=="Account"){
                                if($role!="Not Selected")
                                    $query="insert into privileges values('$privilege','$type','$desc','$role')";
                                else
                                    $query="insert into privileges values('$privilege','$type','$desc',NULL)";
                                $result=  mysql_query($query);
                                if($result){
                                        echo '<script language="javascript">';
                                        echo 'alert("Database updated")';
                                        echo '</script>';
                             }
                                    else{
                                       echo '<script language="javascript">';
                                        echo 'alert("Failed to insert")';
                                        echo '</script>';
                                    }
                      }
                      else{
                          if($role!="Not Selected" && $table!="Not Selected"){
                              $query1="insert into privileges values('$privilege','$type','$desc','$role')";
                              $res1=mysql_query($query1);
                              $query2="insert into rlnprv_roles_tbl values('$privilege','$role','$table')";
                              $res2=  mysql_query($query2);
                              if($res1&&$res2){
                                    echo '<script language="javascript">';
                                        echo 'alert("Database updated")';
                                        echo '</script>';
                              }
                              else{
                                  $err=  mysql_error();
                                  echo '<script language="javascript">';
                                        echo "alert('$err'')";
                                        echo '</script>';
                              }
                          }
                      }
                mysql_close();
                    }
            }
          
         
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="post">
                        <div class="form-group">
                            <label>Privilege</label>
                            <input type="text" name="privilege" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Choose type</label>
                            <select name="type" class="form-control" data-bind="value:Type" >
                                <option>Account</option>
                                <option>Relation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select data-bind="options:availableRoles" name="role" class="form-control"></select>
                        </div>
                        <div class="form-group" data-bind="visible:tableDropdownVisible ">
                             <label>Table</label>
                            <select data-bind="options:availableTables" name="table" class="form-control"></select>
                        </div>
                        <input type="submit" name="submit" value="Submit" class="btn btn-default"/>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach:privileges">
                            <tr>
                                <td data-bind="text:name"></td>
                                <td data-bind="text:type"></td>
                                <td data-bind="text:description"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var viewmodel={
                  availableRoles:ko.observableArray(),
                  tableDropdownVisible:ko.observable(false),
                  availableTables:ko.observableArray(),
                  Type:ko.observable(),
                  privileges:ko.observableArray()
                };
                
                viewmodel.Type.subscribe(function(){
                    var type=viewmodel.Type();
                    if(type=="Relation"){
                        viewmodel.tableDropdownVisible(true);
                    }
                    else{
                        viewmodel.tableDropdownVisible(false);
                    }
                })
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/roles.php',
                    success:function(data){
                        var roles=[];
                        roles.push('Not Selected')
                        var datajs=JSON.parse(data);
                        for(var i=0;i<datajs.length;i++){
                            roles.push(datajs[i]);
                        }
                        
                        viewmodel.availableRoles(roles);
                    }
                });
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/tables.php',
                    success:function(data){
                        var tables=[];
                        tables.push('Not Selected');
                        var datajs=JSON.parse(data);
                        for(var i=0;i<datajs.length;i++){
                            tables.push(datajs[i]);
                        }
                        viewmodel.availableTables(tables);
                    }
                })
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/privileges_complete.php',
                    success:function(data){
                        var privileges=[];
                        var datajs=JSON.parse(data);
                        for(var i=0;i<datajs.length;i++){
                            privileges.push(datajs[i]);
                        }
                        viewmodel.privileges(privileges);
                    }
                })
                ko.applyBindings(viewmodel);
            })
        </script>
    </body>
</html>
