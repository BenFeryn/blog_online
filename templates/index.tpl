<div class="span8">
    {*----------- CONNEXION -------------*}
    {if isset($cookie)}
        <div class='alert alert-success' role='alert'/> <!-- notif succés-->
            <strong> Vous êtes connecté </strong>
        </div>
    {/if} 
    {*----------- DECONNEXION -------------*}
    {if isset($deconnexion)}
        <div class='alert alert-info' role='alert'/> <!-- notif info-->
            <strong> Vous êtes déconnecté </strong>
        </div>
    {/if} 
    {*----------- ERREUR DE CONNEXION -------------*}
    {if isset($erreurdeco)}
        <div class='alert alert-error' role='alert'/> <!-- notif erreur-->
            <strong> Vous devez vous connecter </strong>
        </div>
    {/if}
    
    {*----------- SI IL Y A UN ID DE COMMENTAIRE -------------*}
    {if isset($idcommentaire) }
        
        {* ------------- SI IL Y A UN COMMENTAIRE ------------- *}
        {if $count > 0}
            
        {* ------------AFFICHE DE L'ARTICLE---------------- *}
        <h2>{$tab_recherches[0]['titre']}</h2>
        <img src="img/{$idcommentaire}.jpg" width="100px" alt="{$tab_recherches[0]['titre']}"/>
        <p style="text-align: justify;"> {$tab_recherches[0]['texte']} </p>
        
        <h1> Commentaire</h1>
        {* ------------AFFICHAGE DES COMMENTAIRES CORRESPONDANT A L'ARTICLE------------- *}
        
        {foreach from=$tab_recherches item=value}
            <div class="panel panel-default">
                <div class="form-group">
                    <p> De <strong>{$value['pseudo']}</strong></p>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p> {$value['commentaire']} </p>
                    </div>
                </div>
             </div>   
        {/foreach}
        <div class="pagination">
            <ul>
                <li><a>Page </a></li> 
                
                {for $foo=1 to $nbpagetotal}
                    <li class="active"> <a href="index.php?com={$idcommentaire}&p={$foo}">{$foo}</a></li>
                {/for}
              
            </ul>
        </div> 
        
        {* ------------AFFICHAGE DU FORMULAIRE ---------------- *}
        <form action="index.php" method="post" enctype="multipart/form-data" id="form_commentaire" name="form_commentaire" >
            <div class="form-group">
                <div class="input"><input type="hidden" name="id_article" id="id_article" value="{$idcommentaire}"></div>
                {* 
                Si en valeur je mets "$tab_articles[0]['id']", la valeur est fausse: elle correspond à l'id du premier commentaire.
                J'ai pas encore réussi à résoudre ce probleme.
                *}
            </div>
            <div class="form-group">
                <label for="titre"> email </label>
                <div class="input"><input type="email" required name="email" id="email"></div>
            </div>

            <div class="form-group">
                <label for="texte"> Pseudo </label>
                <div class="input"><textarea name="pseudo"  id="pseudo"></textarea></div>
            </div>

            <div class="form-group">
                <label for="commentaire">Commentaire </label>
                <div class="input"><textarea name="commentaire" required id="texte"></textarea></div>
            </div>

            <div class="form-actions">
                <input type="submit" name="envoyer" value="envoyer" class="btn btn-large btn-primary">
            </div>
            
        </form>
            
            {* ------------SI L'ARTICLE NE POSSEDE AUCUN COMMENTAIRE ------------- *}
        {else}
            <h2>{$tab_articles[0]['titre']}</h2>
            <img src="img/{$tab_articles[0]['id']}.jpg" width="100px" alt="{$tab_articles[0]['titre']}"/>
            <p style="text-align: justify;"> {$tab_articles[0]['texte']} </p>
        
            <form action="index.php" method="post" enctype="multipart/form-data" id="form_commentaire" name="form_commentaire" >
                <div class="form-group">
                    <div class="input"><input type="hidden" name="id_article" id="id_article" value="{$tab_articles[0]['id']}"></div>
                </div>
                <div class="form-group">
                    <label for="email"> email </label>
                    <div class="input"><input type="email" required name="email" id="email"></div>
                </div>

                <div class="form-group">
                    <label for="pseudo"> Pseudo </label>
                    <div class="input"><textarea name="pseudo"  id="pseudo"></textarea></div>
                </div>

                <div class="form-group">
                    <label for="commentaire">Commentaire </label>
                    <div class="input"><textarea name="commentaire"  id="texte"></textarea></div>
                </div>

                <div class="form-actions">
                    <input type="submit" name="envoyer" value="envoyer" class="btn btn-large btn-primary">
                </div>

            </form>
        {/if}
        
        {* ------QUAND ON ARRIVE SUR LA PAGE D'ACCEUIL------- *}
    {else}
      
    {foreach from=$tab_articles item=value}
        <h2> {$value['titre']}</h2> 
        <img src="img/{$value['id']}.jpg" width="100px" alt="{$value['titre']}"/>
        <p style="text-align: justify;"> {$value['texte']} </p>
        <p><em><u>Publié le : {$value['date_fr']}</u></em> </p>
        <a href="index.php?com={$value['id']}">Commentaire</a>
        
        {if $connecte eq true}
        <a href="article.php?id={$value['id']}">Modifier </a>
        <a href="supprimer.php?id={$value['id']}">Supprimer </a>
        {else} 
        {/if}
    {/foreach}
    
    <div class="pagination">
            <ul>
                <li><a>Page </a></li> 
                
                {for $foo=1 to $nbpagetotal}
                    <li class="active"> <a href="index.php?p={$foo}">{$foo}</a></li>
                {/for}
              
            </ul>
        </div> 
        
    {/if}
           
</div>
                    
                    