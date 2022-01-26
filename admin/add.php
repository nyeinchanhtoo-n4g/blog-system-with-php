<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}

if ($_POST){
  $file = 'images/'. ($_FILES['image']['name']);
  $imageType = pathinfo($file,PATHINFO_EXTENSION);

  if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
    echo "<script>alert('Image must be png,jpg')</script>";
  }else{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $file);
    $sql = "INSERT INTO posts (title, content, image, author_id) VALUES (:title, :content, :image , :author_id)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(['title' => $title, 'content' => $content, 'image' => $image , 'author_id' => $_SESSION['user_id']]);
    if ($result) {
      echo "<script>alert('Post added successfully');window.location.href='index.php';</script>";

    }
  }
}

?>

<?php include('header.html');?>


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form action="add.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="">Post Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
              </div>
              <div class="form-group">
                <label for="content">Post Body</label>
                <textarea name="content" rows="8" cols="80" class="form-control" placeholder="Enter Blog Post" required></textarea>
              </div>
              <div class="form-group">
                <label for="">Image</label> <br>
                <input type="file" name="image" value="" required>
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