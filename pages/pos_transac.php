<?php
include'../includes/connection.php';

session_start();

              $date = $_POST['date'];
              $customer = $_POST['customer'];
              $subtotal = $_POST['subtotal'];
              $lessvat = $_POST['lessvat'];
              $netvat = $_POST['netvat'];
              $addvat = $_POST['addvat'];
              $total = $_POST['total'];
              $cash = $_POST['cash'];
              $emp = $_POST['employee'];
              $rol = $_POST['role'];
              $type = $_POST['typeCom'];
              //imma make it trans uniq id
              $today = date("mdGis"); 
              
              $countID = count($_POST['name']);
              function debug_to_console($data) {
                $output = $data;
                if (is_array($output))
                    $output = implode(',', $output);
            
                echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
            }
              // echo "<table>";
              switch($_GET['action']){
                case 'add':  
                for($i=1; $i<=$countID; $i++)
                  {
                    // echo "'{$today}', '".$_POST['name'][$i-1]."', '".$_POST['quantity'][$i-1]."', '".$_POST['price'][$i-1]."', '{$emp}', '{$rol}' <br>";
                    $nom = $_POST['name'][$i-1];
                    $sqlquantity = "SELECT * FROM product WHERE NAME='{$nom}'";
                    $resulted = mysqli_query($db, $sqlquantity) or die (mysqli_error($db));
                    
                    while ($rows = $resulted->fetch_assoc()) {
                      $quan = $_POST['quantity'][$i-1];
                      echo $rows["QTY_STOCK"]." is the quantity in stock";
                      // echo "The product is : '{$nom}', the quantity in stock is : '{$rows}' and quantity entered is : '{$quan}' ";
                      if($rows["QTY_STOCK"]>=$quan){
                    $query = "INSERT INTO `transaction_details`
                               (`ID`, `TRANS_D_ID`, `PRODUCTS`, `QTY`, `PRICE`, `EMPLOYEE`, `ROLE`, `TYPE_ORDER`)
                               VALUES (Null, '{$today}', '".$_POST['name'][$i-1]."', '".$_POST['quantity'][$i-1]."', '".$_POST['price'][$i-1]."', '{$emp}', '{$rol}', '{$type}')";
                    $newQuantity = $rows["QTY_STOCK"]-$quan;
                    $updateQuery = " UPDATE product SET QTY_STOCK='{$newQuantity}' WHERE NAME='{$nom}'";
                    mysqli_query($db,$query)or die (mysqli_error($db));
                    if ($db->query($updateQuery) === TRUE) {
                      echo "Record updated successfully";
                    } else {
                      echo "Error updating record: " . $db->error;
                    }
                    $query111 = "INSERT INTO `transaction`
                    (`TRANS_ID`, `CUST_ID`, `NUMOFITEMS`, `SUBTOTAL`, `LESSVAT`, `NETVAT`, `ADDVAT`, `GRANDTOTAL`, `CASH`, `DATE`, `TRANS_D_ID`)
                    VALUES (Null,'{$customer}','{$countID}','{$subtotal}','{$lessvat}','{$netvat}','{$addvat}','{$total}','{$cash}','{$date}','{$today}')";
                    mysqli_query($db,$query111)or die (mysqli_error($db));
                         ?>
                         <script type="text/javascript">
                           alert("Commande reussite" );
                           window.location = "pos.php";
                        </script>
                        <?php
                        unset($_SESSION['pointofsale']);
                    break;
                      }else {
                        // echo "'{$row}'";
                        ?>
                       <script type="text/javascript">
                        alert("Insufficient quantity.");
                        window.location = "pos.php";
                      </script>
                        <?php
                      }
                    }
                  }
                   
              }
                    
               ?>
              
          </div>



























<?php
              // switch($_GET['action']){
              //   case 'add':     
              //       $query = "INSERT INTO transaction_details
              //                  (`ID`, `PRODUCTS`, `EMPLOYEE`, `ROLE`)
              //                  VALUES (Null, 'here', '{$emp}', '{$rol}')";
              //       mysqli_query($db,$query)or die ('Error in Database '.$query);
              //       $query2 = "INSERT INTO `transaction`
              //                  (`TRANS_ID`, `CUST_ID`, `SUBTOTAL`, `LESSVAT`, `NETVAT`, `ADDVAT`, `GRANDTOTAL`, `CASH`, `DATE`, `TRANS_D_ID`)
              //                  VALUES (Null,'{$customer}','{$subtotal}','{$lessvat}','{$netvat}','{$addvat}','{$total}','{$cash}','{$date}','{$today}'')";
              //       mysqli_query($db,$query2)or die ('Error in updating Database2 '.$query2);
              //   break;
              // }

              // mysqli_query($db,"INSERT INTO transaction_details
              //                 (`ID`, `PRODUCTS`, `EMPLOYEE`, `ROLE`)
              //                 VALUES (Null, 'a', '{$emp}', '{$rol}')");

              // mysqli_query($db,"INSERT INTO `transaction`
              //                 (`TRANS_ID`, `CUST_ID`, `SUBTOTAL`, `LESSVAT`, `NETVAT`, `ADDVAT`, `GRANDTOTAL`, `CASH`, `DATE`, `TRANS_DETAIL_ID`)
              //                 VALUES (Null,'{$customer}',{$subtotal},{$lessvat},{$netvat},{$addvat},{$total},{$cash},'{$date}',(SELECT MAX(ID) FROM transaction_details))");

              // header('location:posdetails.php');

            ?>
<!--  <script type="text/javascript">
      alert("Transaction successfully added.");
      window.location = "pos.php";
      </script> -->