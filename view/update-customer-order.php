<?php include('../control/sessioncontrol.php');
      require_once ('../model/model.php');
      $successfulMessage = $errorMessage = "";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>update Order</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="header">
        <h2>Online Ticket System</h2></strong>
    </div>
    <div class="main-body">
      <p><a href="../view/home-page.php" class="link-hvr">← Back to Home</a>
      <p>
      <h1>UPDATE ORDER</h1>

      <?php
        $order_id = $_GET['order_id'];
        //Db connect";
        $connection = new db();
        $conn=$connection->OpenCon();
        $userQuery=$connection->ShowOrder($conn,"orders",$order_id);   

        //$conn->query($sql);
        echo "<table border='1'>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Customer Number</th>
            <th>Movie Name</th>
            <th>Category</th>
            <th>Show Date</th>
            <th>Show Time</th>
            <th>Amount Paid</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>";

        if($userQuery->num_rows > 0)
        {
          while($row=$userQuery->fetch_assoc())
          { 
            $order = $row['order_id'];
            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['number']. "</td>";
            echo "<td>" . $row['movie_name'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['amount'] ." TK". "</td>";
            echo "<td>" . $row['payment_method']. "</td>";
            echo "<td style='color: cyan'>" . $row['status']. "</td>";
            echo "<td>" . $row['order_date']. "</td>";
            echo "<td> 
                      <form action='' method='post'>
                        <select name='status' id='status'>
                          <option value='Ticket Confirmed'>Ticket Confirm</option>
                          <option value='Ticket Canceled'>Ticket Cancel</option>
                          <option value='Ticket Blocked'>Ticket Block</option>
                          <option value='Money Refunded'>Money Refund</option>
                        </select>
                        <input type='submit' name='order_update' value='Update'>
                      </form>
                   </td>";
            echo "</tr>";
          }
          echo "</table>";
        }

        if(isset($_POST['order_update']))
        {
            $order_id = $order;
            $update_status = $_POST['status'];

            $userQuery2=$connection->UpdateOrderDetails($conn,"orders",$update_status, $order_id);
            $flag=1;
            if($flag==1)
            {
              header("location: ../view/view-update-Order-Details.php");
              $successfulMessage = "Order Data Updated"; 
            }
            else
            { 
              $errorMessage = "error occurred while updating"; 
            }
            $conn->close();
        }
      ?>
      
					<p style="color:green;"><?php echo $successfulMessage; ?></p>
					<p style="color:red;"><?php echo $errorMessage; ?></p>
    </div>
    <br><br><br><br><br><br>

    <?php include 'footer.php' ; ?>
</body>

</html>