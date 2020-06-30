<?php

namespace App\Controllers;

class CoreController
{

    /**
     * Vérification du rôle de l'utilisateur
     * @param array
     */
    public function checkAuthorization($grantedRoles)
    {

        global $router;

        if (!isset($_SESSION['connectedUser'])) {
            header('Location: ' . $router->generate('main-home'));
        }

        $user = $_SESSION['connectedUser'];
        $isAuthorized = in_array($user->getRole(), $grantedRoles);

        if ($isAuthorized) {
            echo 'Vous pouvez entrer !';
        } else {
                http_response_code('403');
                header('Location: ' . $router->generate('main-home'));
                exit;
            }

        }
    
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = [])
    {

        global $router;

        $viewVars['currentPage'] = $viewName;


        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';

        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        extract($viewVars);

        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}
