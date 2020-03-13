<?php
//session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
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

        <h2>Mes messages</h2>
        <table class="u-full-width">
            <thead>
            <tr>
                <th>id</th>
                <th>content</th>
                <th>user_id</th>
                <th>group_id</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($messages as $message) {
                ?>
                <tr>
                    <td><?= $message->id ?></td>
                    <td><?= $message->content ?></td>
                    <td><?= $message->user_id ?></td>
                    <td><?= $message->group_id ?></td>
                    <td><a href="./index.php?controller=messages&action=suppr&msg_id=<?= $message->id?>">Supprimer</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
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