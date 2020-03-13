<nav>
    <a href="../index.php?controller=users&action=register">Inscription</a>
    <a href="../index.php?controller=users&action=login">Se connecter</a>
    <?php
        if (!empty($_SESSION['user_id']))
        {
    ?>
            <a href="./index.php?controller=groups&action=add">Créer un groupe</a>
            <a href="./index.php?controller=groups&action=listg">Liste de mes groupes</a>
            <a href="./index.php?controller=messages&action=add">Écrire un message</a>
            <a href="./index.php?controller=users&action=modify">Modifier le profil</a>
            <a href="./index.php?controller=users&action=logout">Se déconnecter</a>
    <?php
        }
    ?>
</nav>

<?php
