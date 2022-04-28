// Simple-DataTables
// https://github.com/fiduswriter/Simple-DataTables/wiki


window.addEventListener('DOMContentLoaded', event => {

	var datatablesSimple = document.getElementById('datatablesSimple');

	if(datatablesSimple)
	{
		new simpleDatatables.DataTable(datatablesSimple);
	}

});