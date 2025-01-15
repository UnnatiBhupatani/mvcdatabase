<?php
session_start();
require_once 'StudentController.php';
//include 'conntest.php';
$stud = new StudentController();
//$connobj=new Conntest();


$error = [
    'pid' => '',
    'name' => '',
    'email' => '',
    'gender'=>'',
    'city'=>'',
    ];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
      //  $s_id = $_POST['s_id'];
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender =isset($_POST['gender']) ? $_POST['gender'] :'';
        $city=isset($_POST['city']) ? $_POST['city']:'';
     // $subjects[]=isset($_POST['subjects']) ? $_POST['subjects']:[];

       

        if (isset($_POST['update_index']) ) {


            $old_pid=$_POST['old_pid'];
        $error=$stud->updateStudentById($old_pid,$pid,$name,$email,$gender,$city);
            if(empty(array_filter($error))){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();}
            
        } else {
            $error=$stud->addStudent($pid, $name, $email,$gender,$city,);
            

            //print_r($stud);
           if(empty(array_filter($error))){
           
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();

            }}
        }

if (isset($_GET['delete'])) {
    $pid = $_GET['delete'];
    $result = $stud->deleteStudentByID($pid);
    if ($result) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
        }
        else{
            echo "pid not found";
        }
}
$updateData = null;
$result = $stud->display();

if (isset($_GET['update']) && isset($_GET['pid'])) {
    $updateData =$result->fetch_assoc();
    if (!$updateData) {
        echo "<p style='color: red;'>Student with PID {$_GET['pid']} not found.</p>";
    }

}

if(isset($_GET['clear'])){
  
    header("Location: " . $_SERVER['PHP_SELF']);
exit();

}

// session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC</title>
</head>
<body>
    <form method="POST" action="">

        <h2>Student Detail</h2>
        
            <?php  if(isset($updateData)): ?>
                
         <input type="hidden" name="old_pid" value="<?php  echo htmlspecialchars($updateData[0]) ?> ">
          <input type="hidden" name="update_index" value="1 ">
            <?php endif; ?>
           
 <!-- sid<input type="text" name="s_id"><br><br> -->
    PID:<input type="text" name="pid" value="<?php  if(isset($_POST['pid'])) {echo   htmlspecialchars($_POST['pid']);}elseif (isset($updateData)){ echo  htmlspecialchars($updateData['pid']);}?>">
            <span style="color:red"><?php echo isset($error['pid']) ? $error['pid'] : ''; ?></span><br><br>

    Name:<input type="text" name="name" value="<?php if (isset($_POST['name'])) {echo htmlspecialchars($_POST['name']);} elseif (isset($updateData)) {echo htmlspecialchars($updateData['name']);}?>">
        <span style="color:red"><?php echo isset($error['name']) ? $error['name'] : ''; ?></span><br><br>

    Email:<input type="text" name="email" value="<?php if (isset($_POST['email'])) {echo htmlspecialchars($_POST['email']);} elseif (isset($updateData)) {echo htmlspecialchars($updateData['email']);}?>">
        <span style="color:red"><?php echo isset($error['email']) ? $error['email'] : ''; ?></span><br><br>

    Gender: <input type="radio" name="gender" value="male" <?php if(isset($_POST['gender']) && $_POST['gender'] === 'male'){echo 'checked';} 
    elseif(isset($updateData) && $updateData['gender'] === 'male'){if(isset($_POST['gender'])&& $_POST['gender'] ==='male'){echo 'checked';}else echo 'checked';}?>>Male

    <input type="radio" name="gender" value="female" <?php if(isset($_POST['gender']) && $_POST['gender'] === 'female'){echo 'checked';} 
    elseif(isset($updateData) && $updateData['gender'] === 'female'){if(isset($_POST['gender'])&& $_POST['gender'] ==='female'){echo 'checked';}else echo 'checked';}?>>feMale


        
        <span style="color:red"><?php echo isset($error['gender']) ? $error['gender'] : ''; ?></span><br><br>

         

         City:<select id="city" name="city" >

         <option value="" <?php echo (!isset($_POST['city']))? 'selected':'';?>>select city</option>

            <option value="ahmedabad" <?php  if(isset($_POST['city']) && $_POST['city']=== 'ahmedabad'){echo 'selected';} elseif(isset($updateData) && $updateData['city'] === 'ahmedabad') echo 'selected'; ?>>ahmedabad</option>

             <option value="baroda" <?php  if(isset($_POST['city']) && $_POST['city']=== 'baroda'){echo 'selected';} elseif(isset($updateData) && $updateData['city'] === 'baroda') echo 'selected'; ?>>baroda</option>

            </select><span style="color:red"><?php echo isset($error['city']) ? $error['city'] : ''; ?></span><br><br>
       

         <button name="submit"><?php echo isset($updateData) ? 'Update' : 'Submit'; ?></button>
         <a href="" name="clear">clear</a>
         

    </form>
    <?php



?>


<table border="1" width="60%">
    <tr>
        <th>PID</th>
        <th>Name</th>
        <th>Email</th>
        <th>gender</th>
        <th>city</th>
      
        <th>update</th>
        <th>delete</th>
    </tr>
    <?php 
    
        $result = $stud->display();
                
            while($row=$result->fetch_assoc()):
    ?>

    <tr>
        <td><?php echo $row['pid']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['city']; ?></td>
        
      
       
<td><a href="?update&pid=<?php echo htmlspecialchars($row['pid']); ?>">Update</a></td>

        <td><a href="?delete=<?php echo $row['pid']; ?>">Delete</a></td>
<?php endwhile; ?>
     </tr>
    <?php ?>
  </table>
</body>
</html>
