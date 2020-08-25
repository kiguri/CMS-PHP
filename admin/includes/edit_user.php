<?php //EDIT USER

    //SHOW DATA EDIT OF AN ID
    if(isset($_GET['edit_user'])) {
        $the_user_id = $_GET['edit_user'];
        //SHOW DATA EDIT OF AN ID
        $query = "SELECT * FROM users WHERE user_id = {$the_user_id}";
        $select_user_by_id = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_user_by_id)) {
            $user_id         = $row['user_id'];
            $username        = $row['username'];
            $user_password   = $row['user_password'];
            $user_firstname  = $row['user_firstname'];
            $user_lastname   = $row['user_lastname'];
            $user_email      = $row['user_email'];
            $user_image      = $row['user_image'];
            $user_role       = $row['user_role'];
        }  
    }

    //UPDATE USER
    if(isset($_POST['edit_user'])) {


        $user_firstname  = $_POST['user_firstname'];
        $user_lastname   = $_POST['user_lastname'];
        $user_role       = $_POST['user_role'];

        // $post_image         = $_FILES['image']['name'];
        // $post_image_temp    = $_FILES['image']['tmp_name'];

        $username        = $_POST['username'];
        $user_email      = $_POST['user_email'];
        $user_password   = $_POST['user_password'];


        // move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}' ";
        $query .= "WHERE user_id = {$the_user_id}";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);

        header("Location: users.php");
        
    }


?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value='subscriber'><?php echo $user_role ?></option>
            <?php //SHOW PULLDOWN ROLE
                if($user_role == 'admin') {
                    echo "<option value='subscriber'>subscriber</option>";
                } else {
                    echo "<option value='admin'>admin</option>";
                }
            ?>
        </select>
    </div>

    
    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->

    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input value="<?php echo $user_password; ?>" type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary"
            name="edit_user" value="Edit User">
    </div>

</form>