var $addEquipeLink = $('<a href="#" class="btn btn-default">Adicionar</a>');
var $newLinkLiEquipe = $('<div class="botao-wrap"></div>').append($addEquipeLink);
$collectionHolderEquipe = $('div#equipe');
$collectionHolderEquipe.append($newLinkLiEquipe);
$collectionHolderEquipe.data('index', $collectionHolderEquipe.find(':input').length);
$addEquipeLink.on('click', function(e)
{
    e.defaultPrevented;
    addForm($collectionHolderEquipe, $newLinkLiEquipe);
});
$collectionHolderEquipe.find('div.toMany-item').each(function() {
    addFormDeleteLink($(this));
});
