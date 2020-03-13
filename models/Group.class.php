<?php
    require_once(__DIR__.'/../classes/connection.class.php');

    Class Group {
        public $id;
        public $title;
        public $creator_id;
        public $member_id;

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
                $this->login = $user->login;
                $this->password = $user->password;
                $this->firstname = $user->firstname;
                $this->lastname = $user->lastname;
                $this->photo = $user->photo;
            }
        }

        public function validate($data)
        {
            $this->errors = [];

            /* required fields */
            if (!isset($data['title'])) {
                $this->errors[] = 'Commence par entrer un titre pour le groupe avant de créer';
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

    }
