<?php
    require_once(__DIR__.'/../models/Group.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function add() {
            $group = new Group();
            if (!empty($_POST)) {
                if ($group->add($_POST)){
                    $_SESSION['errors'] = [];
                    $_SESSION['success'] = 'Votre groupe a bien été créé';
                    include (__DIR__.'/../views/add_group.php');
                }else{
                    $_SESSION['errors'] = $group->errors;
                    $_SESSION['success'] = '';
                    include (__DIR__.'/../views/add_group.php');
                }
            } else {
                $_SESSION['errors'] = [];
                $_SESSION['success'] = '';
                include (__DIR__.'/../views/add_group.php');
            }
        }

        //Obligation d'afficher la liste des groupes avant de pouvoir "Modifier un groupe" ou "Écrire un message"
        //car cette fonction stock les groupes
        function listg() {
            $group = new Group();
            $_SESSION['errors'] = [];
            $groups = $group->findAll($_SESSION);
            $_SESSION['groups'] = $groups;
            include (__DIR__.'/../views/groups_list.php');
        }

        function modify() {
            $group = new Group();
            if (!empty($_POST)) {
                if ($group->modify($_POST)) {
                    $groups = $group->findAll($_SESSION);
                    $_SESSION['groups'] = $groups;
                    $_SESSION['errors'] = [];
                    $_SESSION['success'] = 'Votre nom de groupe a bien été modifié!';
                    include (__DIR__.'/../views/group_modify.php');
                } else {
                    $_SESSION['errors'] = $group->errors;
                    $_SESSION['success'] = '';
                    include (__DIR__.'/../views/group_modify.php');
                }
            } else {
                $_SESSION['errors'] = [];
                $_SESSION['success'] = '';
                include (__DIR__.'/../views/group_modify.php');
            }
        }

        function findall() {
            $group = new Group();
            $_SESSION['errors'] = [];
            $groups = $group->findAll($_SESSION);
            $_SESSION['groups'] = $groups;
            include (__DIR__.'/../views/messages_by_groups.php');
        }

        // Ce que j'ai essayé de faire :
        // Fonction qui me permettrai de récupérer tous les messages d'un groupe (l'id du groupe est dans le $_POST)
        // en appelant la fonction search() de la classe Group
        function search () {
            $group = new Group();
            $_SESSION['errors'] = [];
            $groups = $group->search($_POST);
            $_SESSION['groups'] = $groups;
            include (__DIR__.'/../views/messages_by_groups.php');
        }

        $arrayAvailableActionGroup = array(
            'add',
            'listg',
            'modify',
            'findall',
            "search"
        );

        if(in_array($action, $arrayAvailableActionGroup)) {
            call_user_func($action);
        }

    } catch (Exception $e) {
        echo('Exception');
        print_r($e);
    }