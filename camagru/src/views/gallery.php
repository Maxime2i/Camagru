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
                                    $likedBy = json_decode($images[$i]['liked_by'], true);
                                    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                                    if ($userId !== null && in_array($userId, $likedBy)) {
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
                        <?php if ($images[$i]['description']): ?>
                            <div class="description">
                                <?php echo htmlspecialchars($images[$i]['description']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="comments">
                            <div class="commentList">
                            <span class="commentInfo">Commentaires :</span>
                            <ul class="commentUl">
                                <?php foreach ($imageComments[$images[$i]['id']] as $comment): ?>
                                    <li class="comment"><span class="commentUsername"><?php echo htmlspecialchars($comment['username']); ?> : </span><?php echo htmlspecialchars($comment['comment']); ?></li>
                                <?php endforeach; ?>
                               
                            </ul>
                            </div>
                            <form class="commentForm">
                                <input class="commentInput" type="hidden" name="image_id" value="<?php echo $images[$i]['id']; ?>">
                                <textarea class="commentArea1" name="comment" placeholder="..."></textarea>
                                <button type="submit" class="submitBtn">Envoyer</button>
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
                        <img class="img" src="src/uploads/<?php echo $images[$i]['img']; ?>" alt="<?php echo $images[$i]['user_id']; ?>">
                            <span class="info">Utilisateur : <?php echo '@', $username; ?>
                                <?php
                                     $likedBy = json_decode($images[$i]['liked_by'], true);
                                     $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                                     if ($userId !== null && in_array($userId, $likedBy)) {
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
                        <?php if ($images[$i]['description']): ?>
                            <div class="description">
                                <?php echo htmlspecialchars($images[$i]['description']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="comments">
                            <div class="commentList">
                            <span class="commentInfo">Commentaires :</span>
                            <ul class="commentUl">
                                <?php foreach ($imageComments[$images[$i]['id']] as $comment): ?>
                                    <li class="comment"><span class="commentUsername"><?php echo htmlspecialchars($comment['username']); ?> : </span><?php echo htmlspecialchars($comment['comment']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            </div>
                            <form action="?page=gallery" method="post" class="commentForm">
                                <input class="commentInput" type="hidden" name="image_id" value="<?php echo $images[$i]['id']; ?>">
                                <textarea class="commentArea2" name="comment" placeholder="..."></textarea>
                                <button type="submit" class="submitBtn">Envoyer</button>
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

                <?php
                // Nombre maximum de pages à afficher
                $maxPagesToShow = 5;
                $startPage = max(1, $currentPage - intval($maxPagesToShow / 2));
                $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

                // Ajuster le startPage si l'endPage est proche de totalPages
                $startPage = max(1, $endPage - $maxPagesToShow + 1);

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a  class="numberPage" href="?page=gallery&page_number=<?php echo $i; ?>" <?php if ($i === $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
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

            // Appel AJAX au contrôleur
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '?page=gallery&action=like', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Réponse du serveur:', xhr.responseText);
                } else {
                    console.error('Erreur lors de la requête:', xhr.status);
                }
            };
            xhr.send('image_id=' + image_id);

         
        });
    });

    // Gestion des commentaires
    var commentForms = document.querySelectorAll('.commentForm');
    commentForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            console.log(form)
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '?page=gallery&action=comment', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Ajouter le nouveau commentaire à la liste
                        var commentList = form.previousElementSibling.querySelector('.commentUl');
                        var newComment = document.createElement('li');
                        newComment.className = 'comment';
                        newComment.innerHTML = '<span class="commentUsername">' + response.username + ' : </span>' + response.comment;
                        commentList.appendChild(newComment);
                        
                        // Réinitialiser le formulaire
                        form.reset();
                    } else {
                        alert('Erreur lors de l\'ajout du commentaire : ' + response.message);
                    }
                } else {
                    console.error('Erreur lors de la requête:', xhr.status);
                }
            };
            xhr.send(formData);
        });
    });
});





</script>
</html>