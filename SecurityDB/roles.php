<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Roles</title>
    </head>
    <body>
        <?php
        // put your code here
        
        include 'nav.php';
        
        $host="127.0.0.1";
            $username="root";
            $password="";
        $submit=filter_input(INPUT_POST,'submit');
        if(isset($submit)){
          $role=filter_input(INPUT_POST, 'RoleName');
          $description=  filter_input(INPUT_POST, 'Description');
          
          $con=  mysql_connect($host,$username,$password);
            if($con){
                $db=  mysql_select_db('security',$con);
                $query="INSERT INTO user_roles(RoleName,description)VALUES('$role','$description')";
                $result=mysql_query($query);
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
                mysql_close();
           }
        }
      
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST">
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" placeholder="Enter role name" name="RoleName" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="Description" placeholder="Enter a few words..."></textarea>
                        </div>
                        <input type="submit" class="btn btn-default" value="Submit" name="submit"/>
                        
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
                                <th>Role Name</th>
                                <th>Description</th>
                            </tr>
                        
                        </thead>
                        <tbody data-bind="foreach:roles">
                            <tr>
                                <td data-bind="text:name"></td>
                                <td data-bind="text:description"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var vm={
                  roles:ko.observableArray()  
                };
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/roles_complete.php',
                    success:function(data){
                        var roles=[];
                        var datajs=JSON.parse(data);
                        for(var i=0;i<datajs.length;i++){
                            roles.push(datajs[i]);
                        }
                        vm.roles(roles);
                    }
                })
                ko.applyBindings(vm);
            })
         </script>
    </body>
</html>