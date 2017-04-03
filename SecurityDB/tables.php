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
        // put your code here
        include 'nav.php';
        $host="127.0.0.1";
            $username="root";
            $password="";
        
          $submit=  filter_input(INPUT_POST, 'submit');
          if(isset($submit)){
            $user=filter_input(INPUT_POST,'Owner');
            $name=  filter_input(INPUT_POST, 'Table');
            $desc=  filter_input(INPUT_POST, 'Description');
            $con=  mysql_connect($host,$username,$password);
            if($con){
                $db=  mysql_select_db('security',$con);
                $query="select ID from user_accounts where Name='$user'";
                $res=mysql_query($query);
                $row=mysql_fetch_row($res);
                $id=$row[0];

                $query="INSERT INTO tables VALUES('$name','$desc',$id)";
                $result=mysql_query($query);
                $err=  mysql_error();
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
          }
        
        ?>
       <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST">
                        <div class="form-group">
                            <label>Table</label>
                            <input type="text" placeholder="Enter table name" name="Table" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="Description" placeholder="Enter a few words..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select owner</label>
                            <select class="form-control" name="Owner" data-bind="options:availableOwners" ></select>
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
                                <th>Table Name</th>
                                <th>Description</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach:tables">
                            <tr>
                                <td data-bind="text:name"></td>
                                <td data-bind="text:description"></td>
                                <td data-bind="text:owner"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
            $(document).ready(function(){
                var viewmodel={
                    availableOwners:ko.observableArray(),
                    tables:ko.observableArray()
                };
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/owners.php',
                    success:function(data){
                       var owners=[];
                       var datajs=JSON.parse(data);
                       for(var i=0;i<datajs.length;i++){
                           owners.push(datajs[i]);
                       }
                       viewmodel.availableOwners(owners);
                    }
                });
                
                $.ajax({
                    url:'http://localhost:5180/SecurityDB/helpers/tables_complete.php',
                    success:function(data){
                        var tables=[];
                        var datajs=JSON.parse(data);
                        for(var i=0;i<datajs.length;i++){
                            tables.push(datajs[i]);
                        }
                        viewmodel.tables(tables);
                    }
                })
                ko.applyBindings(viewmodel);
            })
        
        </script>
    </body>
</html>
