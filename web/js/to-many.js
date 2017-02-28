/* Funções de adicionar prototype em relações -toMany */
function addForm($collectionHolder, $newLinkLi)
{
	let prototype = $collectionHolder.data('prototype');
	let index = $collectionHolder.data('index');
	let newForm = prototype.replace(/__name__/g, index);

	$collectionHolder.data('index', index + 1);

	let $newFormLi = $('<div class="to-many-adicionar"></div>').append(newForm);
	$newLinkLi.before( $newFormLi.show() );

	addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($formLi)
{
	let $removeForm = $('<a class="to-many-remover btn btn-danger" href="#">Remover</a>');
	$formLi.append($removeForm);

	$removeForm.on('click', function(e) {
		// prevent the link from creating a "#" on the URL
		e.defaultPrevented;
		// remove the li for the tag form
		$formLi.removeClass('fadeInLeft').addClass('fadeOutRight').fadeOut(400, function() { $formLi.remove() });
	});
}
