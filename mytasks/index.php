<?php
    $conn = new mysqli('localhost','root','','spl');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="with=device-width, initial-scale=1.0">
                <title>Project Board</title>
                <link rel="stylesheet" href="styles.css">
                <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    </head>


<body>
<?php
    session_start();
    $message = '';

    if(isset($_SESSION['username']))
        $message = $_SESSION['username'];
?>

<?php
    $taskname = $taskdes = $priority = $taskstatus = $due = '';
    $projId = $_SESSION['projectID'];
    if(isset($_POST['addprojectsubmit']))
    {
        $taskname = htmlspecialchars($_POST['taskname']);
        $taskdes = htmlspecialchars($_POST['description']);
        $priority = $_POST['priority'];
        $taskstatus = $_POST['status'];
        $due = $_POST['duetime'];

        if(!empty($taskname) && !empty($taskdes) && !empty($priority) && !empty($taskstatus))
        {
            $query = mysqli_query($conn, "INSERT INTO `tasks` (`taskName`, `taskDes`, `priority`, `status`, `members`, `due`, `projID`) VALUES ('$taskname', '$taskdes', '$priority', '$taskstatus', '1', '$due', '$projId')");
            $name = $message;
            $fetch = mysqli_query($conn,"select id from users where username = '$name';");
            $row=mysqli_fetch_assoc($fetch);
            $userID = $row['id'];
            echo $userID;
            $fetch =mysqli_query($conn, "select taskID from tasks where taskName = '$taskname' and projID = '$projId';");
            $row=mysqli_fetch_assoc($fetch);
            $taskID = $row['taskID'];
            echo $taskID;
            echo$projId;
            $query = mysqli_query($conn, "INSERT INTO `taskmembers` (`userID`, `taskID`) VALUES ($userID, $taskID)");
            header('Location: '.$_SERVER['PHP_SELF'].'?success'); 
        }  
        
    }
?>




<?php
    $fetch = mysqli_query($conn, "SELECT * FROM tasks WHERE projID = $projId");
    $tasks = mysqli_fetch_all($fetch, MYSQLI_ASSOC);
?>

<?php
    if(isset($_POST['deletetasksubmit']))
    {
        $selected = htmlspecialchars($_POST['deltask']);
        $del = mysqli_query($conn, "DELETE FROM `tasks` WHERE taskName = '$selected' AND projID = $projId");
        header('Location: '.$_SERVER['PHP_SELF'].'?success');
    }
?>

<?php
    if(isset($_POST['viewtasksubmit']))
    {
        $selectedview = htmlspecialchars($_POST['viewtask']);
        $view = mysqli_query($conn, "SELECT * FROM `tasks` WHERE taskName = '$selectedview' AND projID = $projId");
        $row = mysqli_fetch_assoc($view);
        $_SESSION['taskName'] = $row['taskName'];
        $_SESSION['taskID'] = $row['taskID'];
        header('Location: ../taskpageadmin/index.php');
    }
?>
<!--  section of the whole page -->
<section class="header">

     <!-- side nav bar begin here -->
     <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx bxl-c-plus-plus icon'></i> -->
        <div class="logo_name">EnzOrg</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <!-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> -->
      <li>
        <a href="../dashboard/index.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
         <span class="tooltip">Dashboard</span>
      </li>
      <li>
       <a href="../profile/index.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">My Profile</span>
       </a>
       <span class="tooltip">My Profile</span>
     </li>
     <li>
       <a href="../mytasks/index.php">
         <i class='bx bx-task' ></i>
         <span class="links_name">My Tasks</span>
       </a>
       <span class="tooltip">My Tasks</span>
     </li>
     <!-- <li>
       <a href="#">
         <i class='bx bx-pie-chart-alt-2' ></i>
         <span class="links_name">Analytics</span>
       </a>
       <span class="tooltip">Analytics</span>
     </li>
     <li>
       <a href="#">
         <i class='bx bx-folder' ></i>
         <span class="links_name">File Manager</span>
       </a>
       <span class="tooltip">Files</span>
     </li>
     <li>
       <a href="#">
         <i class='bx bx-cart-alt' ></i>
         <span class="links_name">Order</span>
       </a>
       <span class="tooltip">Order</span>
     </li> -->
     <li>
       <a href="../helpandsupport/index.php">
         <i class='bx bx-support'></i>
         <span class="links_name">Help & Support</span>
       </a>
       <span class="tooltip">Help & Support</span>
     </li>
     <li>
       <a href="../contact/index.php">
         <i class='bx bxs-contact'></i>
         <span class="links_name">Contact</span>
       </a>
       <span class="tooltip">Contact</span>
     </li>
     
    </ul>
  </div>
<!-- add section here-->
  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); 
  });

  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
   }
  }
  </script>


    <!--  nav bar begins here -->
    <nav>
        <div class="project__name"><p>My Tasks</p></div>
        <div class="nav-links">
            <ul>
                <!-- elements of nav bar  -->
                <li><a href="../Homepage/index.php">HOME</a></li>
                <li><a href="../login/index.php">LOG OUT</a></li>
                <!-- Write profile name here -->
                <?php echo '<li><a href="../profile/index.php">'.$message.'</a></li>';?>
                <li><a href="../about/index.php">ABOUT</a></li>
                <li><a href="../contact/index.php">CONTACT</a></li>
            </ul>
        </div>
    </nav>

    <!-- task entry form here  -->
<div class="row_project">

    <div class="col_project_list">
        <h1>Task list</h1>
        <div style="height: 500px; overflow: auto">
            <table border="1" width="1000"  height="400" class="project_show_table" >
                <tr>
                    <th>Task name</th>
                    <th>Priority</th>
                    <th>Members</th>
                    <th>Status</th>
                    <th>Due</td>
                </tr>
            
                <?php foreach($tasks as $task):?>
                    <tr align="center">
                        <td><?php echo $task['taskName']?></td>
                        <td><?php echo $task['priority']?></td>
                        <td><?php echo $task['members']?></td>
                        <td><?php echo $task['status']?></td>
                        <td><?php echo $task['due']?></td>
    
                        
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>


    


</section>



    
<script>


let popupOpen = document.getElementById("popup_add");

function openPopupAdd(){
    popupOpen.classList.add("open-popup-add");
}
function closePopupAdd(){
    popupOpen.classList.remove("open-popup-add");
}



let popup = document.getElementById("popup_delete");

function openPopup(){
    popup.classList.add("open-popup");
}
function closePopup(){
    popup.classList.remove("open-popup");
}





</script>



</body>







</html>