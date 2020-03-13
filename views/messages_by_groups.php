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

        <form method="post" action="./index.php?controller=groups&action=search" id="msgByGroupForm">
            <fieldset>
                <legend>add group</legend>
                <label for="title">title</label>
                <select name="group_id" id="title">
                    <option></option>
                    <?php foreach ($groups as $group) { ?>
                        <option value="<?= $group->id?>"><?= $group->title?></option>
                    <?php } ?>
                </select>
            </fieldset>
            <input type="submit" value="Chercher" class="button-primary">
        </form>

<!--        Ce que j'ai essayé de faire : -->
<!--        Afficher l'user_id et le content de chaque message du groupe sélectionner ci-dessus -->
        <?php if(isset($groups['user_id']) && isset($groups['content']))
            {
        ?>
            <h2>Liste des messages du groupe</h2>
            <table class="u-full-width">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Content</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($groups as $group) {
                    ?>
                    <tr>
                        <td><?= $group->user_id ?></td>
                        <td><?= $group->content ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        <?php
        }
        ?>
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