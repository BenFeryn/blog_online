<div class="span8">  

    {if isset($ajout_article)}
        <div class='alert alert-success' role='alert'/> <!-- notif succés-->
            <strong> Votre article a été publié </strong>
        </div>
    {/if}    
    
    {if isset($modifier_article)}
        <div class='alert alert-success' role='alert'/> <!-- notif succés-->
            <strong> Votre article a été modifié </strong>
        </div>
    {/if}  
    
        <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article" >
            <div class="clearfix">
                <div class="input"><input type="hidden" name="id" id="id" value="{$tab_articles[0]['id']}"></div>
            </div>
            
            <div class="clearfix">
                <label for="titre"> Titre </label>
                <div class="input"><input type="text" name="titre" id="titre" value="{$tab_articles[0]['titre']}"></div>
            </div>

            <div class="clearfix">
                <label for="texte"> Texte </label>
                <div class="input"><textarea name="texte"  id="texte">{$tab_articles[0]['texte']}</textarea></div>
            </div>

            <div class="clearfix">
                <label for="image"> Image </label>
                <div class="input"><input type="file" name="image" id="image" ></div>
            </div>

            <div class="clearfix">
                <label for="publie" >Publié </label>
                <div class="input"> 
                    <input type="checkbox" {$checkbox} name="publie" id="publie"> 
                </div>

            </div>

            <div class="form-actions">
                <input type="submit" name="{$bouton}" value="{$bouton}" class="btn btn-large btn-primary">
            </div>

        </form>
    </div>