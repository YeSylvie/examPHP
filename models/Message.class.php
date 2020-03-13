<?php
    require_once(__DIR__.'/../classes/connection.class.php');

    Class Message {
        public $id;

        public $errors = [];

        public function __construct($id = null)
        {
            if (!is_null($id)) {
                $this->get($id);
            }
        }

        public function get($id = null)
        {
            if (!is_null($id)) {
                $dbh = Connection::get();
                //print_r($dbh);

                $stmt = $dbh->prepare("select * from users where id = :id limit 1");
                $stmt->execute(array(
                    ':id' => $id
                ));
                // recupere les users et fout le resultat dans une variable sous forme de tableau de tableaux
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                $user = $stmt->fetch();

                $this->id = $user->id;
            }
        }

        public function findAll($data)
        {
            if(!empty($data['user_id'])) {
                $dbh = Connection::get();
                $sql = "select * from messages where user_id = :user_id";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $sth->execute(array(
                    ':user_id' => $data['user_id']
                ));
                $messages = $sth->fetchAll(PDO::FETCH_CLASS);
                return $messages;
            }

        }

        public function validate($data)
        {
            $this->errors = [];

            /* required fields */
            if (!isset($data['content']) && mpty($data['content'])) {
                $this->errors[] = 'Commence par entrée un message avant d\'envoyer';
            }

            if (empty($data['groupe'])) {
                $this->errors[] = 'Faut choisir un groupe';
            }

            if (count($this->errors) > 0) {
                return false;
            }
            return true;
        }

        public function add($data) {
            if ($this->validate($data)) {
                $dbh = Connection::get();
                $sql = "insert into messages ( user_id, group_id, content) values (:user_id, :group_id, :content)";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                if ($sth->execute(array(
                    ':user_id' => $data['user_id'],
                    'group_id' => $data['groupe'],
                    ':content' => $data['content']
                ))) {
                    return true;
                } else {
                    // ERROR
                    // put errors in $session
                    $this->errors['Le message ne peut pas être ajouté, recommence!'];
                }
            }
        }
    }
