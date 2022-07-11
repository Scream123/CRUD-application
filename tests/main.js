$(document).ready(function () {
	$(document).on("click", "#addProduct", function (event) {
		event.preventDefault();
		let data = {
			name: $('#itemName').val(),
			author: $('#itemAuthor').val(),
			date: $('#itemDate').val()
		};
		if (data.name == '' || data.author == '' || data.date == '') {
			$("#blockAddEditProduct").html('Заполните все поля').css('background-color', 'red').show();
			$("#blockAddEditProduct").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$.ajax({
				type: 'POST',
				async: true,
				url: '/addproduct',
				data: data,
				dataType: 'json',
				success: function (response) {
					if (response) {
						$("#book-list tbody").append(response.book_data);
						$('#itemName, #itemAuthor, #itemDate').val('');
						$("#blockAddEditProduct").html(response['message']).css('background-color', 'blue').show();
						$("#blockAddEditProduct").fadeOut(2000).fadeOut('slow');
						updateTableNumeration();
					}
				}
			});
		}


	});

});
