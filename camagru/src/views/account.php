<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/account.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="divInfo">
            <h2>My infos</h2>
                <form class="formInfo" action="index.php?page=account&action=update" method="post">
                    <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Update" name="submit">
                </form>
        </div>
        <div class="divImage">
            <h2>My images</h2>
                <div class="images">
                    <?php foreach ($images as $image): ?>
                        <div class="image">
                            <img src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                        </div>
                    <?php endforeach; ?>
                </div>
        </div>
            

        
    </main>
</body>
</html>