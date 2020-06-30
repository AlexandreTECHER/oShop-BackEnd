<div class="row mt-5">
    <div class="col-12 col-md-6">

            <?php if($errors > 0) : ?>
                <?php foreach($errors as $error) : ?>
                    <div class="alert">
                        <?= $error ?>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
            <form action="" method="POST" class="mt-5">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="xxx@mail.fr">

                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="oshop1234">

                <button type="submit" class="btn btn-primary btn-block mt-5">Connexion</button>
            </form>
    </div>
</div>