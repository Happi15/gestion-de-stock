<?php
require("../lib/fpdf186/fpdf.php");
include'../includes/connection.php';






 $query = 'SELECT *, FIRST_NAME, LAST_NAME, PHONE_NUMBER, EMPLOYEE, ROLE
              FROM transaction T
              JOIN customer C ON T.`CUST_ID`=C.`CUST_ID`
              JOIN transaction_details tt ON tt.`TRANS_D_ID`=T.`TRANS_D_ID`
              WHERE TRANS_ID ='.$_GET['id'];
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
        while ($row = mysqli_fetch_assoc($result)) {
          $fname = $row['FIRST_NAME'];
          $lname = $row['LAST_NAME'];
          $pn = $row['PHONE_NUMBER'];
          $date = $row['DATE'];
          $tid = $row['TRANS_D_ID'];
          $cash = $row['CASH'];
          $sub = $row['SUBTOTAL'];
          $less = $row['LESSVAT'];
          $net = $row['NETVAT'];
          $add = $row['ADDVAT'];
          $grand = $row['GRANDTOTAL'];
          $role = $row['EMPLOYEE'];
          $roles = $row['ROLE'];
          $type = $row['TYPE_ORDER'];
        }
        

        $pdf = new FPDF('p','mm', 'A4');
        $pdf -> AddPage();
        $pdf ->SetFont('Arial','B', '14');
// cell  definition


$pdf -> SetFont('Arial','','16');
// Invoice head
$pdf -> Cell(130, 5, "Glovec", 0, 0);
$pdf -> Cell(60,5,"Facture",0,1);
// Invoice header info
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(130, 5, 'Logbessou Pharmacie de la paix', 0, 0);
$pdf -> Cell(60, 5, '', 0, 1);

$pdf -> Cell (130, 5, 'Douala, Cameroun', 0, 0);
$pdf -> Cell(15, 5, 'Date :', 0, 0);
$pdf -> Cell(45 , 5, $date, 0, 1);

$pdf -> Cell (130, 5, 'Phone : 699775588/677550022', 0, 0);
$pdf -> Cell(28, 5, 'Commande #', 0, 0);
$pdf -> Cell(32 , 5, $tid, 0, 1);

$pdf -> Cell (130, 5, '', 0, 0);
$pdf -> Cell(28, 5, "Expedition", 0, 0);
$pdf -> Cell(32 , 5, $type, 0, 1);

$pdf -> Cell (130, 5, '', 0, 0);
$pdf -> Cell(28, 5, "Vendeur", 0, 0);
$pdf -> Cell(32 , 5, $role, 0, 1);

// space
$pdf -> Cell(190, 10, '', 0, 1);

// Billing address
$pdf -> Cell(100, 5, 'Livrer a ?', 0,1);

// add dummy cell  ay beggining of each line for indentation
$pdf -> Cell(10, 5, '', 0,0);
$pdf -> Cell(90, 5, $fname.' '.$lname, 0, 1);

$pdf -> Cell(10, 5, '', 0,0);
$pdf -> Cell(90, 5, $pn, 0, 1);

// space
$pdf -> Cell(190, 10, '', 0, 1);

// invoice contents
$pdf -> SetFont('Arial', 'B', 12);
$pdf -> Cell( 100, 5, 'Produits', 1, 0, '' );
$pdf -> Cell( 25, 5, 'Quantite', 1, 0);
$pdf -> Cell( 35, 5, 'Prix', 1, 0 );
$pdf -> Cell( 30, 5, 'Total', 1, 1 );

$pdf -> SetFont( 'Arial', '', 12);
// nubers are right aligned so we give 'R' after a new line parameter
$query = 'SELECT *
                     FROM transaction_details
                     WHERE TRANS_D_ID ='.$tid;
            $result = mysqli_query($db, $query) or die (mysqli_error($db));
            while ($row = mysqli_fetch_assoc($result)) {
                $Sub =  $row['QTY'] * $row['PRICE'];
                $pdf -> Cell (100, 5, $row['PRODUCTS'], 1, 0);
                $pdf -> Cell(25, 5, $row['QTY'], 1, 0);
                $pdf -> Cell(35 , 5,  $row['PRICE'], 1, 0, 'R');
                $pdf -> Cell( 30, 5, $Sub, 1, 1, 'R' );
                
            }

// Summary

$pdf -> Cell( 130, 5, '',0, 0 );
$pdf -> Cell( 25, 5, 'SubTotal', 0, 0 );
$pdf -> Cell( 10, 5, 'CFA', 1, 0 );
$pdf -> Cell( 25, 5, $cash, 1, 1, 'R' );

$pdf -> Cell( 130, 5, '',0, 0 );
$pdf -> Cell( 25, 5, 'Total ', 0, 0 );
$pdf -> Cell( 10, 5, 'CFA', 1, 0 );
$pdf -> Cell( 25, 5, $cash, 1,1, 'R' );

// Little message
$pdf -> Cell( 190, 5, '', 0, 1 );
$pdf -> Cell( 190, 5, '', 0, 1 );


$pdf -> Cell( 130, 5, '', 0, 0 );
$pdf -> Cell( 60, 5, 'Signature Client', 0, 1);

$pdf -> Cell( 190, 25, '', 0, 1 );

$pdf -> SetFont( 'Arial', 'B', '12' );

$pdf -> Cell( 190, 5, 'Glovec vous remerci(e) pour votre commande / Glovec thanks you for your order',0,1);

$pdf ->Output();
?>