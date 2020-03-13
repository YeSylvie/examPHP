<?php
    require_once(__DIR__.'/../classes/connection.class.php');

    Class Group {
        public $id;
//        public $title;
//        public $creator_id;
//        public $member_id;

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

        public function validate($data)
        {
            $this->errors = [];

            /* required fields */
            if (!isset($data['title'])) {
                $this->errors[] = 'Commence par entrer un titre pour le groupe avant de créer';
            }

            if (empty($data['name'])) {
                $this->errors[] = 'Entrer un nouveau nom de groupe';
            }

            if (count($this->errors) > 0) {
                return false;
            }
            return true;
        }

        function add($data) {
            if ($this->validate($data)) {
                $dbh = Connection::get();
                $sql = "insert into groups ( title, creator_id, member_id) values (:title, :creator_id, :member_id)";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                if ($sth->execute(array(
                    ':title' => $data['title'],
                    ':creator_id' => $data['user_id'],
                    ':member_id' => $data['user_id']
                ))) {
                    return true;
                } else {
                    // ERROR
                    // put errors in $session
                    $this->errors['J\'ai pas réussi à créer ton groupe, recommence!'];
                }
            }
        }

        public function findAll($data)
        {
            if(!empty($data['user_id'])) {
                $dbh = Connection::get();
                $sql = "select id, title from groups where creator_id = :user_id OR member_id = :user_id";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $sth->execute(array(
                    ':user_id' => $data['user_id']
                ));
                $groups = $sth->fetchAll(PDO::FETCH_CLASS);
                return $groups;
            }
        }

        public function modify($data)
        {
            if ($this->validate($data)) {
                $dbh = Connection::get();
                $sql = "UPDATE groups SET title = :title WHERE id = :group_id AND creator_id = :user_id";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                if ($sth->execute(array(
                    ':title' => $data['name'],
                    ':group_id' => $data['title'],
                    ':user_id' => $data['user_id']
                ))) {
                    return true;
                } else {
                    $this->errors['J\'ai pas réussi à modifier ton groupe, recommence!'];
                }
            }
        }

    }
