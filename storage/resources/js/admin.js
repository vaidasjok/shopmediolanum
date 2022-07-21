$(document).ready(function() {
	$('.delete-warning').on("click", (function(e) {
		e.preventDefault();
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this information!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {

			if (willDelete) {
				window.location.href = $(this).attr('href');
			}
		});
	}));


	$( "#expiry_date" ).datepicker({minDate: 0, dateFormat: "yy-mm-dd"});
});