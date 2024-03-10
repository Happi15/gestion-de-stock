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



$query = 'SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME,d.Name FROM employee e JOIN departement d ON e.DEPARTEMENT_ID=d.DEPARTEMENT_ID';
$result = mysqli_query($db, $query) or die (mysqli_error($db));

    while ($row = mysqli_fetch_assoc($result)) {
                         
        echo '<tr>';
        echo '<td>'. $row['FIRST_NAME'].'</td>';
        echo '<td>'. $row['LAST_NAME'].'</td>';
        echo '<td>'. $row['Name'].'</td>';


    }
            $id = $_GET['id'];
      ?>
  <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Employee</h4>
            </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="callcenter_departement.php"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back </a>
            <div class="card-body">
          
            <form role="form" method="post" action="dep_edit1.php">
              <input type="hidden" name="id" value="<?php echo $zz; ?>" />
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 First Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="First Name" name="firstname" value="<?php echo $fname; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Last Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lname; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Departement:
                </div>
                <div class="col-sm-9">
                  <select class='form-control' name='Name' required>
                    <option value="" disabled selected hidden>Select Departement</option>
                    <option value="a">Callcenter A</option>
                    <option value="b">Callcenter B</option>
                    <option value="c">Callcenter C</option>

                  </select>
                </div>
              </div>
              


              <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>    
              </form>  
                    
            </div>
          </div></center>

<?php
include'../includes/footer.php';
?>