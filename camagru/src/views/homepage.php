<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/homepage.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
       
        <div>
            <h2>Creer un montage !</h2>
            <div class="images">
        
                
                    <div class="image">
                        <img src="src/filtre1.png" alt="Image">
                    </div>
               
            </div>
        </div>

        <div>
            <h2>Photos recentes</h2>
            <div class="images">
        
                <?php foreach ($images as $image): ?>
                    <div class="image">
                        <img src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <h2>Photos recentes</h2>
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