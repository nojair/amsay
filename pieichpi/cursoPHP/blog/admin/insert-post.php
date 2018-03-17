<?php
$result = false;

if (!empty($_POST)) {
    $sql = 'INSERT INTO blog_posts (title, content) VALUE (:title, :content)';
    $query = $pdo->prepare($sql);
    $result = $query->execute([
        'title' => $_POST['title'],
        'content' => $_POST['content']
    ]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>myBlog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Blog Title</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h2>New Post</h2>
                <p>
                    <a class="btn btn-default" href="posts.php">Back</a>
                </p>
                <?php
                    if ($result) {
                        echo '<div class="alert alert-success">Post Saved!</div>';
                    }
                ?>
                <form action="insert-post.php" method="post">
                    <div class="form-group">
                        <label for="inputTitle">Title</label>
                        <input type="text" class="form-control" name="title" id="inputTitle">
                    </div>
                    <textarea class="form-control" name="content" id="inputContent" cols="5" rows="10"></textarea>
                    <br>
                    <input class="btn btn-primary" type="submit" value="Save">
                </form>
            </div>
            <div class="col-md-4">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse quia facere rem molestias nostrum, excepturi atque, consequuntur doloribus, ducimus ipsa nihil veniam debitis pariatur quisquam voluptatibus amet. Laudantium, soluta dolore.
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <footer>
                    This a footer <br>
                    <a href="index.php">Admin Panel</a>
                </footer>
            </div>
        </div>
    </div>    
</body>
</html>