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
                $_SESSION['success'] = '';
                include (__DIR__.'/../views/add_group.php');
            }
        }

        function listg() {
            $group = new Group();
            $_SESSION['errors'] = [];
            $groups = $group->findAll($_SESSION);
            $_SESSION['groups'] = $groups;
            include (__DIR__.'/../views/groups_list.php');
        }

        $arrayAvailableActionGroup = array(
            'add',
            'listg'
        );

        if(in_array($action, $arrayAvailableActionGroup)) {
            call_user_func($action);
        }

    } catch (Exception $e) {
        echo('Exception');
        print_r($e);
    }