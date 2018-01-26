var $addEquipeLink = $('<a href="#" class="btn btn-primary">Adicionar Equipe</a>');
var $newLinkLiEquipe = $('<div class="to-many-wrap"></div>').append($addEquipeLink);

$collectionHolderEquipe = $('div#equipes');
$collectionHolderEquipe.append($newLinkLiEquipe);
$collectionHolderEquipe.data('index', $collectionHolderEquipe.find(':input').length);
$addEquipeLink.on('click', function(e)
{
    e.preventDefault();
    addForm($collectionHolderEquipe, $newLinkLiEquipe);
});
