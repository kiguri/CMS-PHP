<?php
    if(isset($_POST['checkBoxArr'])) {
        foreach($_POST['checkBoxArr'] as $postValueId) {
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options) {
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_published = mysqli_query($connection, $query);
                    confirmQuery($update_to_published);
                    break;
                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_draft = mysqli_query($connection, $query);
                    confirmQuery($update_to_draft);
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $update_to_delete = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete);
                    break;
                case 'clone':   
                    $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                    $select_post_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($select_post_query)) {
                        $post_title       = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_author      = $row['post_author'];
                        $post_image       = $row['post_image'];
                        $post_tags        = $row['post_tags'];
                        $post_content     = $row['post_content'];
                        $post_status      = $row['post_status'];
                    }
                    $query = "INSERT INTO posts(post_category_id, post_title, post_author,
                    post_date, post_image, post_content, post_tags,
                    post_status) ";
                    $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', 
                    now(), '{$post_image}', '{$post_content}', '{$post_tags}',
                    '{$post_status}')";
                    $copy_query = mysqli_query($connection, $query);
                    confirmQuery($copy_query);
            }
        }
    }

?>


<form action="" method="post">
<table class="table table-bordered table-hover">
    <div style="padding: 0" id="bulkOptionsContainer" class="col-xs-2">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Total views </th>
        </tr>
    </thead>
    <tbody>
    
    <?php //SHOW ALL posts
        $query = "SELECT * FROM posts ";
        $query .= "ORDER BY post_id DESC";
        $select_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id            = $row['post_id'];
            $post_author        = $row['post_author'];
            $post_title         = $row['post_title'];
            $post_category_id   = $row['post_category_id'];
            $post_status        = $row['post_status'];
            $post_image         = $row['post_image'];
            $post_tags          = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date          = $row['post_date'];
            $post_views_count   = $row['post_views_count'];
            echo "<tr>";
            ?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArr[]'
                value='<?php echo $post_id ?>'></td>
        <?php    
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";
            //SHOW Category title
            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            $select_categories_id = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                    echo "<td>{$cat_title}</td>";
                }        
            echo "<td>{$post_status }</td>";
            echo "<td><img width='85'src='../images/{$post_image}' alt='{$post_image}'></td>";
            echo "<td>{$post_tags}</td>";
            
            //count comments
            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_query = mysqli_query($connection, $query);
            $count_comments = mysqli_num_rows($send_comment_query);
            echo "<td>{$count_comments}</td>";
            
            echo "<td>{$post_date}</td>";
            echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Bạn có chắc muốn xóa?')\" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<td><a href='posts.php?resetView={$post_id}'>{$post_views_count}</a></td>";
            echo "</tr>";
        }
        ?>            
    </tbody>
</table>
</form>
<?php
    //DELETE POST
    if(isset($_GET['delete'])) {
        $the_post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
        $delete_post_query = mysqli_query($connection, $query);
        //DELETE COMMENT RELATE THIS POST
        $query = "DELETE FROM comments WHERE comment_post_id = {$the_post_id}";
        $delete_comment_query = mysqli_query($connection, $query);
        header("Location: posts.php"); 
    }
    //RESET VIEWS
    if(isset($_GET['resetView'])) {
        $the_post_id = $_GET['resetView'];
        $the_post_id= mysqli_real_escape_string($connection, $the_post_id);
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id} ";
        $reset_views_query = mysqli_query($connection, $query);
        header("Location: posts.php"); 
    }

?>
