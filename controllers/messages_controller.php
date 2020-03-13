<?php
    require_once(__DIR__.'/../models/Message.class.php');

    try {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        function add() {
            $message = new Message();
            if (!empty($_POST)) {
                if ($message->add($_POST)){
                    $_SESSION['errors'] = [];
    //                    header('./index.php?controller=groups&action=listg');
                    include (__DIR__.'/../views/messages_list.php');
                }else{
                    $_SESSION['errors'] = $message->errors;
                    include (__DIR__.'/../views/add_messages.php');
                }
            } else {
                include (__DIR__.'/../views/add_messages.php');
            }
        }

        function listm() {
            $message = new Message();
            $_SESSION['errors'] = [];
            $messages = $message->findAll($_SESSION);
            $_SESSION['groups'] = $messages;
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