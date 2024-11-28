<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create_p0st.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <title>Chewsday | Create New Post</title>
</head>
<body>
<div class="background">
  
    <div class="question_container">
        <h1>Create A New Post</h1>
        <form method="POST" action="create_post_action.php" enctype="multipart/form-data">
            <label for="title">Title: </label>
            <input type="text-post" name="title" id="title" required>
            
            <label for="content">Content: </label>
            <textarea name="content" id="content" required></textarea>  

            <label for="module_id">Select module: </label>
            <select name="module_id" id="module_id" required="">
                              <option value="1">GENERAL</option>
                              <option value="14">HTML</option>
                              <option value="12">JAVA</option>
            </select>
            
            <label for="image">Upload Image:</label> 
            <input type="file" name="image" id="image">
            <button type="submit">Create New Post</button>
        </form>
        <a href="home.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
