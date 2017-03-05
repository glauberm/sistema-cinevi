/* Funções de adicionar prototype em relações -toMany */
function addForm($collectionHolder, $newLinkLi)
{
	let prototype = $collectionHolder.data('prototype');
	let index = $collectionHolder.data('index');
	let newForm = prototype.replace(/__name__/g, index);

	$collectionHolder.data('index', index + 1);

	let $newFormLi = $('<div class="to-many-adicionar"></div>').append(newForm);
	$newLinkLi.before( $newFormLi.fadeIn(300) );

	select2Caller();
    dateTimePickerCaller();
    autosizeCaller();

	addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($formLi)
{
	let $removeForm = $('<div class="text-right"><a class="to-many-remover btn btn-danger btn-sm" href="#">Remover</a></div>');
	$formLi.append($removeForm);

	$removeForm.on('click', function(e) {
		// prevent the link from creating a "#" on the URL
		e.preventDefault();
		// remove the li for the tag form
		$formLi.fadeOut(300, function() { $formLi.remove() });
	});
}
