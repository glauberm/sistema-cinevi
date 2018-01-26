function addForm($collectionHolder, $newLinkLi)
{
	var prototype = $collectionHolder.data('prototype');
	var index = $collectionHolder.data('index');
	var newForm = prototype.replace(/__name__/g, index);

	$collectionHolder.data('index', index + 1);

	var $newFormLi = $('<div class="to-many-adicionar"></div>').append(newForm);
	$newLinkLi.before( $newFormLi.fadeIn(300) );

	select2Caller();
    dateTimePickerCaller();
    autosizeCaller();

	addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($formLi)
{
	var $removeForm = $('<div class="pull-right"><div class="inline-block"><a class="to-many-remover btn btn-danger btn-sm" href="#">Remover</a></div></div>');
	$formLi.append($removeForm);

	$removeForm.on('click', function(e) {
		e.preventDefault();
		$formLi.fadeOut(300, function() { $formLi.remove() });
	});
}
