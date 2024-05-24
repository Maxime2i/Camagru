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
                            <span class="info">Utilisateur : <?php echo '@', $username; ?> 
                                <?php
                                    if (strpos($images[$i]['liked_by'], ";" . $images[$i]['user_id'] . ";") !== false) {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="like.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    } else {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="unlike.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    }
                                ?>
                            </span>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="column">
                <?php for ($i = $halfway; $i < count($images); $i++): ?>
                    <?php $username = isset($usernames[$image['user_id']]) ? $usernames[$image['user_id']] : 'Utilisateur inconnu';?>
                    <div class="post">
                        <img src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                            <span class="info">Utilisateur : <?php echo '@', $username; ?>
                                <?php
                                    if (strpos($images[$i]['liked_by'], ";" . $images[$i]['user_id'] . ";") !== false) {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="like.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    } else {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="unlike.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    }
                                ?>
                            </span>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="pagination">
        <?php echo $currentPage; ?>
                <?php if ($currentPage > 1): ?>
                    <a href="?page=gallery&page_number=<?php echo $currentPage - 1; ?>">Précédent</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=gallery&page_number=<?php echo $i; ?>" <?php if ($i === $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=gallery&page_number=<?php echo $currentPage + 1; ?>">Suivant</a>
                <?php endif; ?>
            </div>
    </main>
</body>
<script>

document.addEventListener("DOMContentLoaded", function() {
    var likeButtons = document.querySelectorAll('.like');
    likeButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            
            var image_id = event.target.id;

            if (event.target.src.endsWith("unlike.png")) {
                event.target.src = "like.png";
                console.log(event.target.parentNode.querySelector('.nb_like'))
                
                var nbLikeSpan = event.target.parentNode.querySelector('.nb_like');
                nbLikeSpan.textContent = parseInt(nbLikeSpan.textContent) + 1;
            } else {
                var nbLikeSpan = event.target.parentNode.querySelector('.nb_like');
                nbLikeSpan.textContent = parseInt(nbLikeSpan.textContent) - 1;
                event.target.src = "unlike.png";
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'src/like_image.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Images saved:', xhr.responseText);
            };
            xhr.send('image_id=' + image_id);
        });
    });
});





</script>
</html>