let $addEquipeLink = $('<a href="#" class="btn btn-primary">Adicionar Equipe</a>');
let $newLinkLiEquipe = $('<div class="to-many-wrap"></div>').append($addEquipeLink);

$collectionHolderEquipe = $('div#equipes');
$collectionHolderEquipe.append($newLinkLiEquipe);
$collectionHolderEquipe.data('index', $collectionHolderEquipe.find(':input').length);
$addEquipeLink.on('click', function(e)
{
    e.preventDefault();
    addForm($collectionHolderEquipe, $newLinkLiEquipe);
});
/*$collectionHolderEquipe.find('div.toMany-item').each(function() {
    addFormDeleteLink($(this));
});*/
