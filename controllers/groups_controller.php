<?php
    require_once(__DIR__.'/../models/Group.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function add() {
            $group = new Group();
            if (!empty($_POST)) {
                echo'ouiii';
                die;
                if ($group->add($_POST)){
                    $_SESSION['errors'] = [];
                    include (__DIR__.'/../views/page_group.php');
                }else{
                    $_SESSION['errors'] = $group->errors;
                    include (__DIR__.'/../views/add_group.php.php');
                }
            } else {
                include (__DIR__.'/../views/add_group.php.php');
            }
        }

        $arrayAvailableActionGroup = array(
            'add'
        );

        if(in_array($action, $arrayAvailableActionGroup)) {
            call_user_func($action);
        }

    } catch (Exception $e) {
        echo('Exception');
        print_r($e);
    }