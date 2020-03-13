<?php
//session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$groups = isset($_SESSION['groups']) ? $_SESSION['groups'] : [];
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://hedinoamane.fr/_css/normalize.css"/>
    <link rel="stylesheet" href="https://hedinoamane.fr/_css/skeleton.css"/>
    <style>
        fieldset {
            border: 0.25rem solid rgba(225, 225, 225, 0.5);
            border-radius: 4px;
            padding: 1rem 2rem;
        }

        .errors {
            color: #ff5555;
        }

        .success {
            color: limegreen;
        }
    </style>
</head>

<body>
<?php require_once(__DIR__.'/../components/nav.php') ?>
<div class="container">

    <div class="row">

        <ul class="errors">
            <?php
            foreach ($errors as $error) {
                echo("<li>" . $error . "</li>");
            }
            ?>
        </ul>

        <ul class="success">
            <?php
            if (!empty($success)) {
                echo("<li>" . $success . "</li>");
            }
            ?>
        </ul>

        <form method="post" action="./index.php?controller=groups&action=modify" id="modifyGroupForm">
            <fieldset>
                <legend>Modifier un groupe</legend>
                <label for="groupOldName">Nom du groupe à modifier</label>
                <select name="title" id="groupeOldName">
                    <option></option>
                    <?php foreach ($groups as $group) { ?>
                        <option value="<?= $group->id?>"><?= $group->title?></option>
                    <?php } ?>
                </select>
                <label for="groupNewName">Nouveau nom</label>
                <input type="text" id="groupNewName" name="name" value="">
            </fieldset>
            <input type="submit" value="Envoyer" class="button-primary">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        </form>
    </div>

    <div class="row">
        <div class="column">
            $_SESSION
            <pre><?php print_r($_SESSION) ?></pre>
        </div>

    </div>

    <div class="row">
        <div class="one-half column">
            $_GET
            <pre><?php print_r($_GET) ?></pre>
        </div>
        <div class="one-half column">
            $_POST :
            <pre><?php print_r($_POST) ?></pre>
        </div>
    </div>

</div>
</body>
</html>