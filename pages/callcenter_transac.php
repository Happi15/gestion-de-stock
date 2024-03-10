<?php
include'../includes/connection.php';

?>
            <?php
              $employee = $_POST['callcenteragent'];
              $callcenterdep = $_POST['callcenter_dep'];         
              mysqli_query($db,"UPDATE employee SET DEPARTEMENT_ID='".$callcenterdep."' WHERE EMPLOYEE_ID='".$employee."';");
              header('location:callcenter_departement.php');
            ?>