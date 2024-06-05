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
        <div class="images">
        <div class="gallery">
            <div class="column">
                <?php $halfway = ceil(count($images) / 2); ?>
                <?php for ($i = 0; $i < $halfway; $i++): ?>
                    <?php $username = isset($usernames[$image['user_id']]) ? $usernames[$image['user_id']] : 'Utilisateur inconnu'; ?>
                    <div class="post1">
                        <div class="imageAndInfo">
                        <img class="img" src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                            <span class="info">Utilisateur : <?php echo '@', $username; ?> 
                                <?php
                                    if (strpos($images[$i]['liked_by'], ";" . $images[$i]['user_id'] . ";") !== false) {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="src/assets/like.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    } else {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="src/assets/unlike.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    }
                                ?>
                            </span>
                        </div>
                    <div class="comments">
                        <div class="commentList">
                        <span class="commentInfo">Commentaires :</span>
                        <ul class="commentUl">
                            <?php foreach ($imageComments[$images[$i]['id']] as $comment): ?>
                                <li class="comment"><span class="commentUsername"><?php echo $comment['username']; ?> : </span><?php echo $comment['comment']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        </div>
                        <form action="?page=gallery" method="post" class="commentForm">
                            <input class="commentInput" type="hidden" name="image_id" value="<?php echo $images[$i]['id']; ?>">
                            <textarea class="commentArea1" name="comment" placeholder="..."></textarea>
                            <button type="submit" class="submitBtn"></button>
                        </form>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="column">
                <?php for ($i = $halfway; $i < count($images); $i++): ?>
                    <?php $username = isset($usernames[$image['user_id']]) ? $usernames[$image['user_id']] : 'Utilisateur inconnu';?>
                    <div class="post2">
                        <div class="imageAndInfo">
                        <img src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                            <span class="info">Utilisateur : <?php echo '@', $username; ?>
                                <?php
                                    if (strpos($images[$i]['liked_by'], ";" . $images[$i]['user_id'] . ";") !== false) {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="src/assets/like.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    } else {
                                        ?>
                                            <span class="spanLike">
                                                <span class="nb_like"><?php echo $images[$i]['nb_like']; ?></span> 
                                                <img id="<?php echo $images[$i]['id']; ?>" class="like" src="src/assets/unlike.png" alt="like" width="16" height="16">
                                            </span>
                                        <?php
                                    }
                                ?>
                            </span>
                            </div>
                            <div class="comments">
                        <div class="commentList">
                        <span class="commentInfo">Commentaires :</span>
                        <ul class="commentUl">
                            <?php foreach ($imageComments[$images[$i]['id']] as $comment): ?>
                                <li class="comment"><span class="commentUsername"><?php echo $comment['username']; ?> : </span><?php echo $comment['comment']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        </div>
                        <form action="?page=gallery" method="post" class="commentForm">
                            <input class="commentInput" type="hidden" name="image_id" value="<?php echo $images[$i]['id']; ?>">
                            <textarea class="commentArea2" name="comment" placeholder="..."></textarea>
                            <button type="submit" class="submitBtn"></button>
                        </form>
                        </div>
                    </div>
                    
                <?php endfor; ?>
            </div>
        </div>
            <div class="pagination">
                <span class="current-page"><?php echo $currentPage; ?></span> 
                <div class="pages">
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
            </div>
        </div>
        
    </main>
</body>
<script>

document.addEventListener("DOMContentLoaded", function() {
    var likeButtons = document.querySelectorAll('.like');
    likeButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            
            var image_id = event.target.id;

            if (event.target.src.endsWith("src/assets/unlike.png")) {
                event.target.src = "src/assets/like.png";
                console.log(event.target.parentNode.querySelector('.nb_like'))
                
                var nbLikeSpan = event.target.parentNode.querySelector('.nb_like');
                nbLikeSpan.textContent = parseInt(nbLikeSpan.textContent) + 1;
            } else {
                var nbLikeSpan = event.target.parentNode.querySelector('.nb_like');
                nbLikeSpan.textContent = parseInt(nbLikeSpan.textContent) - 1;
                event.target.src = "src/assets/unlike.png";
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