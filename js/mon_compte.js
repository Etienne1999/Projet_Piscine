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

	$('#Modal_suppr_carte').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		//Recupere les données de l'utilisateur a editer
		var id = button.data('id')
		var num_cache = button.data('num_cache')
		var type = button.data('type')
		var modal = $(this)

		//Rempli le modal avec les données approprié
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #num_cache').val(num_cache)
		modal.find('.modal-body #type').val(type)
	});

	$('#Modal_edit_carte').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		//Recupere les données de l'utilisateur a editer
		var id = button.data('id')
		var num_cache = button.data('num_cache')
		var proprietaire = button.data('proprietaire')
		var date_exp = button.data('date_exp')
		var modal = $(this)

		//Rempli le modal avec les données approprié
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #num_cache').val(num_cache)
		modal.find('.modal-body #proprietaire').val(proprietaire)
		modal.find('.modal-body #date_exp').val(date_exp)
	});

	$("#info_edit").click(function() {
		document.getElementById("info_nom").removeAttribute("readonly");
		document.getElementById("info_prenom").removeAttribute("readonly");
		document.getElementById("info_email").removeAttribute("readonly");
		document.getElementById("info_password").removeAttribute("readonly");
		document.getElementById("info_save_edit").removeAttribute("hidden");
		document.getElementById("info_edit").setAttribute("hidden", "true");
	});

	$("#info_save_edit").click(function() {
		document.getElementById("info_nom").setAttribute("readonly", "true");
		document.getElementById("info_prenom").setAttribute("readonly", "true");
		document.getElementById("info_email").setAttribute("readonly", "true");
		document.getElementById("info_password").setAttribute("readonly", "true");
		document.getElementById("info_save_edit").setAttribute("hidden", "true");
		document.getElementById("info_edit").removeAttribute("hidden");
	});

	//Genere nombre aléatoire entre min inclus et max exclu
	function getRandomArbitrary(min, max) {
		return parseInt(Math.random() * (max - min) + min);
	};
	
	$('#Modal_add_cadeau').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		//Recupere les données de l'utilisateur a editer
		var num_carte = getRandomArbitrary(1000000000000000, 9999999999999999)
		var modal = $(this)

		//Rempli le modal avec les données approprié
		modal.find('.modal-body #num_carte').val(num_carte)
	});
});