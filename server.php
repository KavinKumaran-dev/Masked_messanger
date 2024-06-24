<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>server</title>
</head>
<body>
    <?php
      $conn = mysqli_connect("localhost","root","","chatapp3");
      if($conn == false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      $content = $_GET['msg'];
      $time = time();
      $name = $_GET['name'];
      $id = (int) $_GET['id'];
      $toId = (int) $_GET['toId'];
      if(strlen($content) != 0){
      $sql = "INSERT INTO send_message (message,timestamp,sent_id,receiver_id) VALUES ('$content',NOW(),'$id','$toId')";
      $sql1 = "INSERT INTO receive_message (message,timestamp,receive_id,sender_id) VALUES ('$content',NOW(),'$toId','$id')";
      if(mysqli_query($conn,$sql)){
        $sql4 = "SELECT * FROM user  WHERE user_id = $toId";
        $user_name = "";
        if($res5 = $conn->query($sql4)){
          while($row3 = $res5->fetch_assoc()){
              $user_name = $row3['user_name'];
          }
        }
          echo "<table><thead><tr><th>Received from $user_name </th><th>Time</th></tr></thead><tbody>";
          $sql2 = "SELECT * FROM receive_message WHERE receive_id = $id AND sender_id = $toId";
          if($res1 = $conn->query($sql2)){
          while($row = $res1->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row['message']."</td>";
            echo "<td>".$row['timestamp']."</td>";
            echo "</tr>";
          }
        }
      }
      if(mysqli_query($conn,$sql1)){
        echo "<table><thead><tr><th>Sent (You) </th><th>Time</th></tr></thead><tbody>";
        $sql3 = "SELECT * FROM send_message WHERE sent_id = $id AND receiver_id = $toId";
        if($res2 = $conn->query($sql3)){
        while($row1 = $res2->fetch_assoc()){
          echo "<tr>";
          echo "<td>".$row1['message']."</td>";
          echo "<td>".$row1['timestamp']."</td>";
          echo "</tr>";
        }
      }
      echo "</tbody></table>";
      }
    }
    else{
      $sql4 = "SELECT * FROM user  WHERE user_id = $toId";
        $user_name = "";
        if($res5 = $conn->query($sql4)){
          while($row3 = $res5->fetch_assoc()){
              $user_name = $row3['user_name'];
          }
        }
          echo "<table><thead><tr><th>Received from $user_name </th><th>Time</th></tr></thead><tbody>";
          $sql2 = "SELECT * FROM receive_message WHERE receive_id = $id AND sender_id = $toId";
          if($res1 = $conn->query($sql2)){
          while($row = $res1->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row['message']."</td>";
            echo "<td>".$row['timestamp']."</td>";
            echo "</tr>";
          }
        }
        echo "<table><thead><tr><th>Sent (You) </th><th>Time</th></tr></thead><tbody>";
        $sql3 = "SELECT * FROM send_message WHERE sent_id = $id AND receiver_id = $toId";
        if($res2 = $conn->query($sql3)){
          while($row1 = $res2->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row1['message']."</td>";
            echo "<td>".$row1['timestamp']."</td>";
            echo "</tr>";
          }
          echo "</tbody></table>";
      }
    }
    ?>
</body>
</html>
