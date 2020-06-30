<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{

    /**
     * Méthode de vérification des données de connexion
     * @return bool
     */
    public function login()
    {
        $errorsList = [];
        $this->show('login/login', [
            'errors' => $errorsList,
            
        ]);
    }

    public function loginPost()
    {
        global $router;

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = AppUser::findByEmail($email);

        if ($user === false) {
            $errorsList[] = "Veuillez indiquer une adresse email valide";
            $this->show('login/login', [
                'errors' => $errorsList,
            ]);
        } else {
            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    $_SESSION['connectedUser'] = $user;
                    header('Location: ' . $router->generate('main-home'));
                }else{
                    header('Location: ' . $router->generate('login'));
                }
            }
        }
    }

    public function logout()
    {   
        global $router;

        session_destroy();
        header('Location: ' . $router->generate('main-home'));
    }

    public function list(){

        $this->checkAuthorization(['admin']);
        $users = AppUser::findAll();

        $this->show('users/list', [
            'users' => $users,
        ]);

    }

    public function add(){

        $this->checkAuthorization(['admin']);

        $this->show('/users/add', [
            'user' => new AppUser(),
        ]);
    }

    public function addPost(){

        global $router;

        $this->checkAuthorization(['admin']);
        
        $emailPost = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $email = filter_var($emailPost , FILTER_VALIDATE_EMAIL);
        $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $user = new AppUser();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRole($role); 
        $user->setStatus($status);

        $succes = $user->insert();

        if($succes){
            $redirect = $router->generate('users-list');
        }else{
            $redirect = $router->generate('user-add');
        }
        header('Location: ' . $redirect);
    }

    public function update($userId){

        $user = AppUser::find($userId);
        $this->show('users/add', [
            'user' => $user,
        ]);


    }
}
