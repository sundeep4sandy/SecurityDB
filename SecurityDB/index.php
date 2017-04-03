<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Security Database</title>
    </head>
    <body>
                <?php
        include "nav.php";
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Roles and privileges</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Privileges</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach:rolePrivileges">
                            <tr>
                                <td data-bind="text:role"></td>
                                <td data-bind="text:privileges"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <h2>Accounts and privileges</h2>
                <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Privileges</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach:accountPrivileges">
                            <tr>
                                <td data-bind="text:name"></td>
                                <td data-bind="text:privileges"></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
        <script type="text/javascript">
        
            $(document).ready(function(){
               
               var vm={
                   rolePrivileges:ko.observableArray(),
                   accountPrivileges:ko.observableArray()
               };
               
               $.ajax({
                   url:'http://localhost:5180/SecurityDB/helpers/role_privileges.php',
                   success:function(data){
                       var role_privileges=[];
                       var datajs=JSON.parse(data);
                       for(var i=0;i<datajs.length;i++){
                           role_privileges.push(datajs[i]);
                       }
                       vm.rolePrivileges(role_privileges);
                       console.log(vm.rolePrivileges());
                   }
               })
               
               $.ajax({
                   url:'http://localhost:5180/SecurityDB/helpers/owners.php',
                   success:accountsRetrieved
               });
               var accounts=[];
               var privileges=[];
               var account_privileges=[];
               function accountsRetrieved(data){
                   var datajs=JSON.parse(data);
                 for(var i=0;i<datajs.length;i++){
                     accounts.push(datajs[i]);
                 }
                 for(var i=0;i<accounts.length;i++){
                     getPrivilegesForAccount(accounts[i],i);
                 }
               };
               
               function getPrivilegesForAccount(account,i){
                   $.ajax({
                       url:'http://localhost:5180/SecurityDB/helpers/privileges_account.php?account='+account,
                       success:function(data){
                           temp=[];
                           temp['name']=account;
                           temp['privileges']=JSON.parse(data);
                           account_privileges.push(temp);
                           vm.accountPrivileges(account_privileges);
                       }
                   })
                
               }
               ko.applyBindings(vm);
            });
            
        </script>
    </body>
    
</html>
