<?php
    require_once(__DIR__.'/../models/Group.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function add() {
            $group = new Group();
            if (!empty($_POST)) {
                if ($group->add($_POST)){
                    $_SESSION['errors'] = [];
//                    header('./index.php?controller=groups&action=listg');
                    include (__DIR__.'/../views/groups_list.php');
                }else{
                    $_SESSION['errors'] = $group->errors;
                    include (__DIR__.'/../views/add_group.php');
                }
            } else {
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