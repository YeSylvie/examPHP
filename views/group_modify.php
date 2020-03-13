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

        .success {
            color: limegreen;
        }
    </style>
</head>

<body>
<?php require_once(__DIR__.'/../components/nav.php') ?>
<div class="container">

    <div class="row">

        <ul class="success">
            <?php
            if (!empty($success)) {
                echo("<li>" . $success . "</li>");
            }
            ?>
        </ul>

        <h2>Modifier un groupe </h2>
        <table class="u-full-width">
            <thead>
            <tr>
                <th>Nom du groupe</th>
                <th>Nouveau nom du groupe</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($groups as $group) {
                ?>
                <tr>
                    <td><?= $group->id ?></td>
                    <td><?= $group->title ?></td>
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