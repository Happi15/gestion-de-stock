<?php

include'../includes/connection.php';

			$zz = $_POST['id'];
			$fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $dep = $_POST['departement'];
            $hdate = $_POST['hireddate'];
           
	 			$query = 'UPDATE employee e join departement d on e.DEPARTEMENT_ID=d.DEPARTEMENT_ID set FIRST_NAME="'.$fname.'",
					LAST_NAME="'.$lname.'",
					DEPARTEMENT="'.$dep.'", HIRED_DATE ="'.$hdate.'" WHERE
					EMPLOYEE_ID ="'.$zz.'"';
					$result = mysqli_query($db, $query) or die(mysqli_error($db));

							
?>	
	<script type="text/javascript">
			alert("You've Update Employee Successfully.");
			window.location = "callcenter_departement.php";
		</script>