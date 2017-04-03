<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
          <?php
            
            include 'nav.php';
            
            if(isset($_POST['submit'])){
                
            $name=$_POST["Name"];
            $phone=$_POST["Phone"];
            if(isset($_POST["Role"]))
            $role=$_POST["Role"];
            else
                $role=NULL;
         
            
            $host="127.0.0.1";
            $username="root";
            $password="";
            
            $con=  mysql_connect($host,$username,$password);
            if($con){
                $db=  mysql_select_db('security',$con);
                $error=mysql_error();
                $query="";
                if($role!="Not Selected")
                    $query="INSERT INTO user_accounts(ID,Name,Phone,RoleName)VALUES(NULL,'$name','$phone','$role')";
                else
                    $query="INSERT INTO user_accounts(ID,Name,Phone,RoleName)VALUES(NULL,'$name','$phone',NULL)";
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
        // put your code here
        ?>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="post">
                <div class="form-group">
                  <label for="labelName">Name</label>
                  <input type="text" class="form-control" id="accountName" placeholder="Enter Name" name="Name">
                </div>
                <div class="form-group">
                  <label for="labelPhone">Phone</label>
                  <input type="text" class="form-control" id="phone" placeholder="721-678" name="Phone">
                </div>
                <div class="form-group">
                  <label for="RoleLbl">Choose Role</label>
                  <select class="form-control" id="roles" name="Role" data-bind="options:availableRoles">
                  </select>
                </div>
                 <button name="submit" type="submit" class="btn btn-default">Submit</button>
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
                            <th>Phone</th>
                            <th>Role</th>

                        </tr>
                    </thead>
                    <tbody data-bind="foreach: accounts">
                        <tr>
                            <td data-bind="text: name"></td>
                        <td data-bind="text: phone"></td>
                        <td data-bind="text: role"></td>
                        
                        </tr>
                    </tbody>
        </table>
        </div>
    </div>
</div>

         <script type="text/javascript">
            $(document).ready(function(){
               var vm={
                   availableRoles:ko.observableArray(),
                   accounts:ko.observableArray()
               };
               $.ajax({
                  url:'http://localhost:5180/SecurityDB/helpers/roles.php',
                  success:function(data){
                      var roles=[];
                      roles.push('Not Selected');
                      var datajs=JSON.parse(data);
                      for(var i=0;i<datajs.length;i++){
                          roles.push(datajs[i]);
                      }
                      vm.availableRoles(roles);
                  }
               });
               
               $.ajax({
                   url:'http://localhost:5180/SecurityDB/helpers/accounts.php',
                   success:function(data){
                       var accs=[];
                       var datajs=JSON.parse(data);
                       for(var i=0;i<datajs.length;i++){
                           accs.push(datajs[i]);
                       }
                      vm.accounts(accs);
                      console.log(vm.accounts());
                   }
               })
               ko.applyBindings(vm);
            });
        </script>
    </body>
</html>
