<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}

if ($_POST){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($_FILES ['image'] ['name'] != null ) {
        $file = 'images/'. ($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
            echo "<script>alert('Image must be png,jpg')</script>";
        }else{
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $sql = "UPDATE posts SET title = :title, content = :content, image = :image WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute(['title' => $title, 'content' => $content, 'image' => $image, 'id' => $id]);
            if ($result) {
            echo "<script>alert('Post successfully updated');window.location.href='index.php';</script>";

            }
        }  
    }else {
        $sql = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute(['title' => $title, 'content' => $content, 'id' => $id]);
            if ($result) {
            echo "<script>alert('Post successfully updated');window.location.href='index.php';</script>";
            }

    }

}

$sql = "SELECT * FROM posts WHERE id=".$_GET['id'];
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

?>

<?php include('header.html');?>


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result[0]['id']?>" >
              <div class="form-group">
                <label for="">Post Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Post Title" value="<?php echo $result[0]['title']?>" required>
              </div>
              <div class="form-group">
                <label for="content">Post Body</label>
                <textarea name="content" rows="8" cols="80" class="form-control" placeholder="Enter Post Content" required> <?php echo $result[0]['content']?> </textarea>
              </div>
              <div class="form-group">
                <label for="">Image</label> <br>
                <img src="images/<?php echo $result[0]['image']?>" width="150" height="150" alt=""> <br><br>
                <input type="file" name="image" value="">
              </div>
              <div class="form-goup">
                <button type="submit" name="submit" class="btn btn-primary" value="SUBMIT">Submit</button>
                <a href="index.php" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php include('footer.html');?>