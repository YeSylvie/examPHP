<?php
    require_once(__DIR__.'/../models/Message.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function add() {
            $message = new Message();
            if (!empty($_POST)) {
                if ($message->add($_POST)){
                    $_SESSION['errors'] = [];
                    $_SESSION['success'] = 'Votre message est bien ajouté';
//                    include (__DIR__.'/../views/messages_list.php');
                    include (__DIR__.'/../views/add_message.php');
                }else{
                    $_SESSION['errors'] = $message->errors;
                    $_SESSION['success'] = '';
                    include (__DIR__.'/../views/add_message.php');
                }
            } else {
                $_SESSION['success'] = '';
                include (__DIR__.'/../views/add_message.php');
            }
        }

        function listm() {
            $message = new Message();
            $_SESSION['errors'] = [];
            $messages = $message->findAll($_SESSION);
            $_SESSION['messages'] = $messages;
            include (__DIR__.'/../views/messages_list.php');
        }

        $arrayAvailableActionMessage = array(
            'add',
            'listm'
        );

        if(in_array($action, $arrayAvailableActionMessage)) {
            call_user_func($action);
        }

    } catch (Exception $e) {
        echo('Exception');
        print_r($e);
    }