<?php
    require_once(__DIR__.'/../classes/connection.class.php');

    Class User
    {
        public $id;
        public $login;
        public $password;
        public $firstname;
        public $lastname;
        public $photo;

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
            if (!isset($data['login'])) {
                $this->errors[] = 'champ login vide';
            }
            if (!isset($data['password'])) {
                $this->errors[] = 'champ password vide';
            }

            /* tests de formats */
            if (isset($data['login'])) {
                if (empty($data['login'])) {
                    $this->errors[] = 'champ login vide';
                    // si name > 50 chars
                } else if (mb_strlen($data['login']) > 45) {
                    $this->errors[] = 'champ login trop long (45max)';
                }
            }

            if (isset($data['password'])) {
                if (empty($data['password'])) {
                    $this->errors[] = 'champ password vide';
                    // si name > 50 chars
                } else if (mb_strlen($data['password']) < 8) {
                    $this->errors[] = 'champ password trop court (8 min)';
                } else if (mb_strlen($data['password']) > 20) {
                    $this->errors[] = 'champ password trop long (20 max)';
                }
            }

            if (isset($data['firstname'])) {
                if (empty($data['firstname'])) {
                    $this->errors[] = 'champ firstname vide';
                    // si name > 50 chars
                } else if (mb_strlen($data['firstname']) < 2) {
                    $this->errors[] = 'champ firstname trop court (8 min)';
                } else if (mb_strlen($data['firstname']) > 45) {
                    $this->errors[] = 'champ firstname trop long (20 max)';
                }
            }

            if (isset($data['lastname'])) {
                if (empty($data['lastname'])) {
                    $this->errors[] = 'champ lastname vide';
                    // si name > 50 chars
                } else if (mb_strlen($data['lastname']) < 2) {
                    $this->errors[] = 'champ lastname trop court (8 min)';
                } else if (mb_strlen($data['lastname']) > 45) {
                    $this->errors[] = 'champ lastname trop long (20 max)';
                }
            }

//            if(isset($data['photo'])) {
//                $dossier = './upload/';
//                $fichier = basename($_FILES['photo']['name']);
//                $extensions = array('.png', '.gif', '.jpg', '.jpeg'); //format autorisé
//                $extension = strrchr($_FILES['photo']['name'], '.');
//                //Début des vérifications de sécurité...
//                if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
//                {
//                    $erreurUpload = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
//                }
//                if(!isset($erreurUpload)) //S'il n'y a pas d'erreur, on upload
//                {
//                    //On formate le nom du fichier ici...
//                    $fichier = strtr($fichier,
//                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
//                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
//                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
//
//                    if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $fichier)) {
////                        $data['photo'] = $fichier;
//                    }
//                    else //Sinon (la fonction renvoie FALSE).
//                    {
//                        echo 'Echec de l\'upload !';
//                    }
//                }
//                else
//                {
//                    echo $erreurUpload;
//                }
//            }

            if (count($this->errors) > 0) {
                return false;
            }
            return true;
        }

        private function loginExists($login = null)
        {
            if (!is_null($login)) {

                $dbh = Connection::get();
                $sql = "select count(id) from users where login = :login";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $sth->execute(array(
                    ':login' => $login
                ));
                if ($sth->fetchColumn() > 0) {
                    $this->errors[] = 'Login déjà pris!';
                    return true;
                }
            }
            return false;

        }

        public function save($data)
        {
            if ($this->validate($data)) {
                if (isset($data['id']) && !empty($data['id'])) {
                    // update
                } elseif ($this->loginExists($data['login'])) {
                    return false;
                }

                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                /* syntaxe avec preparedStatements */
                $dbh = Connection::get();
                $sql = "insert into users (login, password, firstname, lastname) values (:login, :password, :firstname, :lastname)";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                if ($sth->execute(array(
                    ':login' => $data['login'],
                    ':password' => $hashedPassword,
                    ':firstname' => $data['firstname'],
                    ':lastname' => $data['lastname']
//                    ':photo' => $data['photo']
                ))
                ) {
                    return true;
                } else {
                    $this->errors[] = 'Pas réussi a créer le user';
                }
            }
            return false;
        }

        public function login($data)
        {
            if ($this->validate($data)) {
                $dbh = Connection::get();
                $sql = "select id, password from users where login = :login limit 1";
                $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $sth->execute(array(
                    ':login' => $data['login']
                ));
                $user = $sth->fetch(PDO::FETCH_OBJ);
                if (password_verify($data['password'], $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    return true;
                } else {
                    $this->errors[] = 'CASSE TOI !';
                }
            }
            return false;
        }

    }