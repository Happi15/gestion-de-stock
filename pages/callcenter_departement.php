<?php
include'../includes/connection.php';

include'../includes/sidebar.php';
  $query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
  $result = mysqli_query($db, $query) or die (mysqli_error($db));
  
  while ($row = mysqli_fetch_assoc($result)) {
            $Aa = $row['TYPE'];
                   
  if ($Aa=='User'){
?>
  <script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
  </script>
<?php
  }           
}
 ?>
 
 <div class="card shadow mb-4">
        
 <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Call Center departement&nbsp;<a  href="#" data-toggle="modal" data-target="#callcenterModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
               <thead>
                   <tr>
                   <th>First Name</th>
                   <th>Last Name</th>
                     <th>Departement </th>
                     <th>Date</th>
                     <th>Number of Orders</th>
                     <th>Operations</th>
                   </tr>
               </thead>
          <tbody>


          <?php                  
        
        $query = 'SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME,d.Name FROM employee e JOIN departement d ON e.DEPARTEMENT_ID=d.DEPARTEMENT_ID AND d.Name like "%Call Center%"';
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
        $date = time();
        $date = date("y-m-d", $date);
        $dateTime = date("Y-m-d");
            while ($row = mysqli_fetch_assoc($result)) {
              $queries = "SELECT count(PRODUCTS) as orders FROM transaction t, transaction_details dt where dt.TRANS_D_ID=t.TRANS_D_ID AND dt.EMPLOYEE='{$row['FIRST_NAME']}' AND t.DATE='$dateTime'";
              $results = mysqli_query($db, $queries) or die (mysqli_error($db)); 
                  while($rows = mysqli_fetch_assoc($results)){
                    echo '<tr>';
                    echo '<td>'. $row['FIRST_NAME'].'</td>';
                    echo '<td>'. $row['LAST_NAME'].'</td>';
                    echo '<td>'. $row['Name'].'</td>';
                    echo '<td>'. $date.'</td>';
                    if($rows['orders']<60){
                      echo '<td style="color: red">'. $rows['orders'].'</td>';
                    }else {
                      echo '<td style="color: green">'. $rows['orders'].'</td>';
                    }
                    
                   
                  
                    echo '<td align="right"> <div class="btn-group">
                    <a type="button" class="btn btn-primary bg-gradient-primary" href="dep_searchfrm.php?action=edit & id='.$row['EMPLOYEE_ID'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                  <div class="btn-group">
                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                    ... <span class="caret"></span></a>
                  <ul class="dropdown-menu text-center" role="menu">
                      <li>
                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="dep_edit.php?action=edit & id='.$row['EMPLOYEE_ID']. '">
                          <i class="fas fa-fw fa-edit"></i> Edit
                        </a>
                      </li>
                  </ul>
                  </div>
                </div> </td>';
            echo '</tr> ';
                  }          
                
        }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>

<?php
include'../includes/footer.php';
?>

