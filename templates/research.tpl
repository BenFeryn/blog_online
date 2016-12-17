<div class="span8">
    <div class='alert alert-info' role='alert'> <!-- notif succés-->
        <strong> {$count} recherche(s) trouvée(s) pour " {$recherche} " </strong>
    </div>
    {foreach from=$tab_recherches item=value}
        <h2> {$value['titre']}</h2> 
        <img src="img/{$value['id']}.jpg" width="100px" alt="{$value['titre']}"/>
        <p style="text-align: justify;"> {$value['texte']} </p>
        <p><em><u>Publié le : {$value['date_fr']}</u></em> </p>
        {if $connecte eq true}
            <a href="index.php?com={$value['id']}">Commentaire</a>
            <a href="article.php?id={$value['id']}">Modifier</a>
            <a href="supprimer.php?id={$value['id']}">Supprimer </a>
        {else}
            <a href="index.php?com={$value['id']}">Commentaire</a>
        {/if}
    {/foreach}
        <div class="pagination">
            <ul>
                <li><a>Page : </a></li> 
                
                {for $foo=1 to $nbpagetotal}
                    <li class="active"> <a href="research.php?recherche={$recherche}&p={$foo}">{$foo}</a></li>
                {/for}
              
            </ul>
        </div>       
</div>
                    
                    