<a href="<?= $router->generate('users-list'); ?>" class="btn btn-success float-right">Retour</a>
<?php if ($user !== null && $user->getId() !== null) : ?>
    <h2>Modifier un utilisateur</h2>
<?php else :?>
    <h2>Ajouter un utilisateur</h2>
<?php endif ?>
        
<form action="" method="POST" class="mt-5">
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control"
            name="email" id="email" 
            placeholder="Email de l'utilisateur"
            value="<?=$user->getEmail()?>">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" 
            id="password"  name="password" 
            placeholder="password" aria-describedby="subtitleHelpBlock"
            value="<?=$user->getPassword()?>">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            Sera affiché sur la page d'accueil comme bouton devant l'image
        </small>
    </div>
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input type="text" class="form-control" 
            id="firstname" name="firstname" 
            placeholder="Alain" 
            aria-describedby="pictureHelpBlock"
            value="<?=$user->getFirstname()?>">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="lastname">Nom de famille</label>
        <input type="text" class="form-control" 
            id="lastname" name="lastname" 
            placeholder="Terrieur" 
            aria-describedby="pictureHelpBlock"
            value="<?=$user->getLastname()?>">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="custom-select" id="role" name="role" value="<?= $user->getRole(); ?>" aria-describedby="statusHelpBlock">
            <option value="admin">admin</option>
            <option value="catalog-manager">catalog-manager</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit
        </small>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="custom-select" id="status" name="status" value="<?= $user->getStatus(); ?>" aria-describedby="statusHelpBlock">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>
