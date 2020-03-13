<nav>
    <?php
        if(empty($_SESSION['user_id'])) {
    ?>
<!--            Les href sont mal gérés, selon l'action par lequel on commence, on peut avoir l'erreur 404-->
            <a href="./index.php?controller=users&action=register">Inscription</a>
            <a href="./index.php?controller=users&action=login">Se connecter</a>
    <?php
        }

        if (!empty($_SESSION['user_id']))
        {
    ?>
            <a href="./index.php?controller=groups&action=add">Créer un groupe</a>
            <a href="./index.php?controller=groups&action=listg">Liste de mes groupes</a>
            <a href="./index.php?controller=groups&action=modify">Modifier un groupe</a>
            <a href="./index.php?controller=messages&action=add">Écrire un message</a>
            <a href="./index.php?controller=messages&action=listm">Mes message</a>
            <a href="./index.php?controller=users&action=modify">Modifier le profil</a>
            <a href="./index.php?controller=users&action=logout">Se déconnecter</a>
    <?php
        }
    ?>
</nav>

<?php
