<div class="span8">

    {* COMMENTAIRE *}
    {if isset($unlucky)}
        <div class='alert alert-error' role='alert'> <!-- notif succés-->
            <strong> Identifiants incorrects ! </strong>
        </div>
    {/if}    
    
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article" >
            
            <div class="clearfix">
                <label for="titre"> Email </label>
                <div class="input"><input type="text" name="email" id="email" value=""></div>
            </div>

            <div class="clearfix">
                <label for="texte"> Mot de passe</label>
                <div class="input"><input type="password" name="mdp" id="mdp" value=""></div>
            </div>

            <div class="form-actions">
                <input type="submit" name="connecter" value="connecter" class="btn btn-large btn-primary">
            </div>

        </form>
</div>