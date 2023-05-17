
<?php
      include 'connection/config.php';
      $state_id = $_POST["state_id"];
      $city_id = $_POST["city_id"];
      $result = mysqli_query($conn,"SELECT * FROM cities where state_id = $state_id");
   ?>
   <option value="">Select City</option>
   <?php
   while($row = mysqli_fetch_array($result)) {
         ?>
            <option value="<?php echo $row["name"];?>" 
               <?php if($row["name"] == $city_id){ echo 'selected'; }?>><?php echo $row["name"];?></option>
         <?php
   }
?>