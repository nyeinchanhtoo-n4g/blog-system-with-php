<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("Location: login.php");
}

?>

<?php include('header.html');?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <?php 
                
                $sql = "SELECT * FROM posts ORDER BY id DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();
                ?>
              <div class="card-body">
                <div>
                  <a href="add.php" type='button' class="btn btn-success">Create New Post</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">NO.</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     if($result){
                       $i = 1;
                      foreach($result as $value){
                    ?>
                      <tr>
                        
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['title']?></td>
                      <td><?php echo substr($value['content'],0,100); ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['id']?>" type='button' class="btn btn-info">Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['id']?>" type='button' class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete')">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                      $i++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<?php include('footer.html');?>