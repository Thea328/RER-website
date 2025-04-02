<?php
require("db.php");
require("fpdf.php");
if (isset($_POST['Submit'])) {
   $entityname = $_POST['entityname'];
   $date = $_POST['date'];
   $fundcluster = $_POST['fundcluster'];
   $rerno = $_POST['rerno'];
   $receivedfrom = $_POST['receivedfrom'];
   $officedesignation = $_POST['officedesignation'];
   $words = $_POST['words'];
   $figures = $_POST['figures'];
   $inpayment = $_POST['inpayment'];
   $payeename = $_POST['payeename'];
   $payeeaddress = $_POST['payeeaddress'];
   $witnessname = $_POST['witnessname'];
   $witnessaddress = $_POST['witnessaddress'];

   if ($conn) {
    #SQL query to insert data into the database
    $query = "INSERT INTO infor (entityname, date, fundcluster, rerno, receivedfrom, officedesignation, words, figures, inpayment, payeename, payeeaddress, witnessname, witnessaddress) 
    VALUES ('$entityname', '$date', '$fundcluster', '$rerno', '$receivedfrom', '$officedesignation', '$words', '$figures', '$inpayment', '$payeename', '$payeeaddress', '$witnessname', '$witnessaddress')";
    if (mysqli_query($conn, $query)) {
      echo "Record inserted successfully!";
    
    } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  
  } else {
    echo "Connection failed: " . mysqli_connect_error();
  }
}

  mysqli_close($conn);
  
  $pdf = new FPDF('P', 'mm', 'A4');
  $pdf->AddPage();
  $pdf->SetFont("Arial", "B", 12);

  // Title
  $pdf->Cell(0, 10, "REIMBURSEMENT EXPENSE RECEIPT", 0, 1, 'C');
  $pdf->Ln(5);

  // Receipt border
  $pdf->SetLineWidth(0.5);
  $pdf->Rect(10, 25, 190, 143, 'C');
    
  // Header Section
  $pdf->SetFont("Arial", "", 11);
  $pdf->Cell(105, 8, "Entity Name: " . $entityname, 1, 0);
  $pdf->Cell(85, 8, "Fund Cluster: " . $fundcluster, 1, 1);
  $pdf->Cell(105, 8, "Date: " . $date, 1, 0);
  $pdf->Cell(85, 8, "RER No.: " . $rerno, 1, 1);
  $pdf->Ln(5);

  // RECEIVED FROM SECTION
  $pdf->SetFont("Arial", "", 11);
  $pdf->SetY(42); 
  $pdf->Cell(40, 7, "RECEIVED from", 0, 0, 'R');
  $pdf->Cell(130, 7, "____________________________________________________________", 0, 1);
    
  // Received from input
  $pdf->SetXY(55, 42); 
  $pdf->Cell(140, 7, $receivedfrom, 0, 1);

  $pdf->SetFont("Arial", "I", 9);
  $pdf->SetXY(90,46);
  $pdf->Cell(40,7, "(Name)",0,1,'C');

  // Additional underline for Official Designation
  $pdf->SetXY(10, 54); 
  $pdf->SetFont("Arial", "", 11);
  $pdf->Cell(130, 7, "____________________________________________________________________  the amount", 0, 1);
  $pdf->SetFont("Arial", "I", 9);
  $pdf->SetXY(70, 59); 
  $pdf->Cell(40, 7, "(Official Designation)", 0, 1);

  $pdf->SetFont("Arial", "", 11);
  $pdf->SetXY(20, 54);
  $pdf->Cell(120, 7, $officedesignation, 0, 1);

  // Amount Section
  $pdf->SetXY(10, 69);
  $pdf->Cell(5, 7, "of", 0, 0);
  $pdf->Cell(110, 7, "__________________________________________", 0, 0);
  $pdf->Cell(5, 7, "(P", 0, 0);
  $pdf->Cell(40, 7, "______________________ )", 0, 1);

  // Amount input
  $pdf->SetXY(35, 68);
  $pdf->Cell(110, 9, $words, 0, 1);
  $pdf->SetXY(133, 69);
  $pdf->Cell(40, 7, $figures, 0, 1);

  // Amount Labels
  $pdf->SetFont("Arial", "I", 9);
  $pdf->SetY(75);
  $pdf->Cell(80, 3, "(In Words)", 0, 0, 'R');
  $pdf->Cell(80, 3, "(in Figures)", 0, 1, 'R');

  /// Payment Purpose Section with 3 underlined cells
  $pdf->Ln(3); // Add some space
  $pdf->SetFont("Arial", "", 11);
        
  // Label for Payment Purpose
  $pdf->Cell(40, 7, "in payment for", 0, 0);
  $pdf->SetX(40); // Move to the right to start underlined cells
        
  // Create 3 underlined cells for Payment Purpose input
  $pdf->Cell(55, 7, "________________________________________________________________", 0, 1); // First cell with underline
  $pdf->SetXY(90, 85);
  $pdf->SetFont("Arial", "I", 9);
  $pdf->Cell(80, 7, "(Payments for subsistence, services,)", 0, 1);
        
  $pdf->SetXY(10, 93);
  $pdf->Cell(55, 7, "_______________________________________________________________________________________________________", 0, 1); // Second cell with underline
  $pdf->SetXY(80, 97);
  $pdf->SetFont("Arial", "I", 9);
  $pdf->Cell(80, 7, "(rental or transportation should show inclusive dates,)", 0, 1);
        
  $pdf->SetXY(10, 105);
  $pdf->Cell(90, 7, "_______________________________________________________________________________________________________", 0, 1); // Third cell with underline
  $pdf->SetXY(80, 110);
  $pdf->SetFont("Arial", "I", 9);
  $pdf->Cell(80, 7, "(purpose, distance, inclusive points of travel, etc.)", 0, 1);
        
  // Position for the input text that will span across the 3 cells
  $pdf->SetXY(90, 90); // Position for input (adjust the Y position if needed)
        
  // MultiCell to allow wrapping of text across three lines if needed
  $pdf->SetFont("Arial", "", 11);
  // Splitting text manually into three lines for correct positioning
  $max_chars_first_line = 65; // Adjust this based on underline length
  $max_chars_second_line = 70;
  $max_chars_third_line = 70;

  $first_line = substr($inpayment, 0, $max_chars_first_line);
  $second_line = substr($inpayment, $max_chars_first_line, $max_chars_second_line);
  $third_line = substr($inpayment, $max_chars_second_line * 2, $max_chars_third_line);

  // Print first part of the text aligned with the first underline
  $pdf->SetXY(40, 81);
  $pdf->Cell(140, 7, $first_line, 0, 1);

  // Print second part aligned with the second underline
  $pdf->SetXY(10, 92.5);
  $pdf->Cell(140, 7, $second_line, 0, 1);

  // Print third part aligned with the third underline
  $pdf->SetXY(10, 104.5);
  $pdf->Cell(140, 7, $third_line, 0, 1);

   // Payee Section
   $pdf->SetXY(10, 117);
   $pdf->SetFont("Arial", "B", 12);
   $pdf->Cell(0, 8, "PAYEE", 'T', 1, 'C');
   $pdf->SetFont("Arial", "", 11);
   $pdf->Cell(50, 8, "Name/Signature: " , 0, 0);
   $pdf->SetX(45);
   $pdf->Cell(90, 8, "_____________________________________________________________ " , 0, 1);
   $pdf->SetXY(50, 125);
   $pdf->Cell(90, 8, $payeename, 0, 1);

   $pdf->SetXY(10, 135); // Move down for Address section (adjust as needed)
   $pdf->Cell(50, 8, "Address: ", 0, 0); // Left-aligned label for Address
   $pdf->SetX(30); // Move to the right for address line
   $pdf->Cell(90, 8, "___________________________________________________________________ ", 0, 1); // Address line

  // Set the Address of the Payee
   $pdf->SetXY(40, 135); // Position for the Payee's Address (adjust Y position)
   $pdf->Cell(90, 8, $payeeaddress, 0, 1); // Out

  // Witness Section
  $pdf->SetFont("Arial", "B", 12);
  $pdf->Cell(0, 8, "WITNESS", 'T', 1, 'C');
  $pdf->SetFont("Arial", "", 11);
  $pdf->Cell(50, 8, "Name/Signature: ", 0, 0);
  $pdf->SetXY(45,150);
  $pdf->Cell(90, 8, "_____________________________________________________________" , 0, 1);
  $pdf->SetXY(50, 150);
  $pdf->Cell(90, 8, $witnessname, 0, 1);

  $pdf->SetXY(10, 160); // Move down for Address section (adjust as needed)
  $pdf->Cell(50, 8, "Address: ", 0, 0); // Left-aligned label for Address
  $pdf->SetX(30); // Move to the right for address line
  $pdf->Cell(90, 8, "____________________________________________________________________ ", 0, 1); // Address line

  // Set the Address of the Payee
  $pdf->SetXY(40, 160); // Position for the Payee's Address (adjust Y position)
  $pdf->Cell(90, 8, $witnessaddress, 0, 1); // Out
  ob_clean();
  $pdf->Output();
  exit();
  ?>