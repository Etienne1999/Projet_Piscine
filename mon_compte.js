$(document).ready(function () {

	$('.modal_adresse').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		//Recupere les données de l'utilisateur a editer
		var id = button.data('id')
		var ligne_1 = button.data('ligne_1')
		var ligne_2 = button.data('ligne_2')
		var ville = button.data('ville')
		var code_postal = button.data('code_postal')
		var pays = button.data('pays')
		var telephone = button.data('telephone')
		var modal = $(this)
		//Rempli le modal avec les données approprié
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #ligne_1').val(ligne_1)
		modal.find('.modal-body #ligne_2').val(ligne_2)
		modal.find('.modal-body #ville').val(ville)
		modal.find('.modal-body #code_postal').val(code_postal)
		modal.find('.modal-body #pays').val(pays)
		modal.find('.modal-body #telephone').val(telephone)
	});

});