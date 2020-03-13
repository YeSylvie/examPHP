<?php
    require_once(__DIR__.'/../models/User.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function register() {
            $user = new User();
            if (!empty($_POST)) {
                if ($user->save($_POST)){
                    $_SESSION['errors'] = [];
                    include (__DIR__.'/../views/users_list.php');
                } else {
                    $_SESSION['errors'] = $user->errors;
                    include(__DIR__.'/../views/users_register.php');
                }
            } else {
                include(__DIR__.'/../views/users_register.php');
            }
        }

        function login() {
            $user = new User();
            if (!empty($_POST)) {
                if ($user->login($_POST)){
                    $_SESSION['errors'] = [];
                    include (__DIR__.'/../views/add_group.php');
                }else{
                    $_SESSION['errors'] = $user->errors;
                    include (__DIR__.'/../views/users_login.php');
                }
            } else {
                include (__DIR__.'/../views/users_login.php');
            }
        }

        function logout() {
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            include (__DIR__.'/../views/users_login.php');
        }

        $arrayAvailableActionUser = array(
            'register',
            'login',
            'logout'
        );

        if(in_array($action, $arrayAvailableActionUser)) {
            call_user_func($action);
        }

    } catch (Exception $e) {
        echo('Exception');
        print_r($e);
    }
