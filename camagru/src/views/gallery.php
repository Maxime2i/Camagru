<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/gallery.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="gallery">
            <div class="column">
                <?php $halfway = ceil(count($images) / 2); ?>
                <?php for ($i = 0; $i < $halfway; $i++): ?>
                    <?php $username = isset($usernames[$image['user_id']]) ? $usernames[$image['user_id']] : 'Utilisateur inconnu'; ?>
                    <div class="post">
                        <img src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                        <span class="info">Utilisateur : <?php echo '@', $username; ?> <img id="<?php echo $image['img']; ?>" class="like" src="unlike.png" alt="like" width="16" height="16"></span>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="column">
                <?php for ($i = $halfway; $i < count($images); $i++): ?>
                    <?php $username = isset($usernames[$image['user_id']]) ? $usernames[$image['user_id']] : 'Utilisateur inconnu';?>
                    <div class="post">
                        <img src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                        <span class="info">Utilisateur : <?php echo '@', $username; ?> <img id="<?php echo $image['img']; ?>" class="like" src="unlike.png" alt="like" width="16" height="16"></span>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </main>
</body>
<script>

document.addEventListener("DOMContentLoaded", function() {
    var likeButtons = document.querySelectorAll('.like');
    likeButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            
           
            var imageSrc = event.target.parentNode.previousElementSibling.src;
            console.log('Image cliquée:', imageSrc, event.target.src);
            // Vous pouvez maintenant utiliser l'URL de l'image pour effectuer des actions comme ajouter un like, etc.


            if (event.target.src.endsWith("unlike.png")) {
                event.target.src = "like.png"; // Si l'image du like est 'like.png', la changer en 'unlike.png'
            } else {
                event.target.src = "unlike.png"; // Sinon, la changer en 'like.png'
            }
        });
    });
});





</script>
</html>