$(document).ready(function () {
	updateTableNumeration();
	function updateTableNumeration() {
		$('.list-product').each(function (i) {
			$(this).find('td:first').text(`${++i}.`);
		});
	}
	$(document).on("click", "#addProduct", function (event) {
		event.preventDefault();
		let parentRow = $(this).parents('.list-product');
		let id = $('td.product_id', parentRow).attr('data-id');
		$("#product-list tbody").innerHTML = '<tr></tr>';
		let postData = {
			titleProduct: $('#titleProduct').val(),
			productCategory: $('#productCategory').val(),
			price: String($('#price').val()),
			publishedDate: $('#publishedDate').val()
		};
		if (postData.price < 0) {
			$(".blockAddProduct").html('Цена должна быть больше нуля').css('background-color', 'red').show();
			$(".blockAddProduct").fadeOut(2000).fadeOut('slow');
			return false;
		}
		if (postData.titleProduct === '' || postData.productCategory === '' || postData.price === '' ||
			postData.publishedDate === '') {
			$(".blockAddProduct").html('Заполните все поля').css('background-color', 'red').show();
			$(".blockAddProduct").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$.ajax({
				type: 'POST',
				async: true,
				url: "/products/addProducts",
				data: postData,
				dataType: 'json',
				success: function (data) {
						updateTableNumeration();
						$('#addProductModal').fadeOut();
						$(".modal-backdrop").fadeOut();
						$("#product-list tbody").append(data.filterData);
				}
			});
		}
	});
	$(document).on("click", "#product-list .deleteProduct", function () {
		let parentRow = $(this).parents('.list-product');
		let id = $('td.product_id', parentRow).attr('data-id');
		$.ajax({
			type: 'POST',
			async: true,
			url: '/products/deleteProducts/' + id,
			data: {
				id: id,
			},
			dataType: 'json',
			success: function (data) {
				if (data['success']) {
					$(parentRow).remove();
					$(".blockDeleteProduct").html(data['message']).css('background-color', 'red').show();
					$(".blockDeleteProduct").fadeOut(2000).fadeOut('slow');
				}
			}
		});
	});
	$(document).on("click", ".updateProduct", function () {
		let id = $('#editTitleProduct').attr('data-id');
		let title = $('#editTitleProduct').val();
		let category_name = $('#editProductCategory option:selected').text();
		let price = $('#editPrice').val();
		let status = $('#editStatus option:selected').data('id');
		let date = $('#editPublishedDate').val();
		let postData = {
			id: id,
			title: title,
			category_name: category_name,
			price: price,
			status: status,
			date: date,
		};
		if (postData.price < 0) {
			$("#blockEditProduct").html('Цена должна быть больше нуля').css('background-color', 'red').show();
			$("#blockAddProduct").fadeOut(2000).fadeOut('slow');
			return false;
		}
		if (postData.titleProduct === '' || postData.productCategory === '' || postData.price === '' ||
			postData.publishedDate === '') {
			$("#blockAddProduct").html('Заполните все поля').css('background-color', 'red').show();
			$("#blockAddProduct").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$.ajax({
				type: 'POST',
				async: true,
				url: '/products/updateproduct/',
				data: postData,
				dataType: 'json',
				success: function (data) {
					if (data['success']) {
						$('.itemTitle_' + id).text(data['itemParameters']['title']);
						$('.itemCategoryTitle_' + id).text(data['itemParameters']['category_name']);
						$('.itemPrice_' + id).text(data['itemParameters']['price']);
						$('.itemDate_' + id).text(data['itemParameters']['date']);
						if (Number(data['itemParameters']['status']) === 0) {
							$('.itemStatus_' + id).prop('value', 'Не куплен');
							$('.itemStatus_' + id).attr('data-id', 0);
							$('.status' + id).attr('class', 'status notBought btn btn-success itemStatus_' + id)
							$('#editProductModal').fadeOut();
							$(".modal-backdrop").fadeOut();
							$("#").html(data['message']).css('background-color', 'green').show();
							$("#blockEditProduct").fadeOut(2000).fadeOut('slow');
						} else {
							$('.itemStatus_' + id).prop('value', 'Куплен');
							$('.itemStatus_' + id).attr('data-id', 1);
							$('.itemStatus_' + id).attr('class', 'status bought btn btn-danger itemStatus_' + id);
							$('#editProductModal').fadeOut();
							$(".modal-backdrop").fadeOut();
							$("#").html(data['message']).css('background-color', 'green').show();
							$("#blockEditProduct").fadeOut(2000).fadeOut('slow');
						}

					}
				}
			});
		}
	});
	$(document).on("click", '.status', function () {
		let $this = $(this);
		let status = $this.val();
		let parentRow = $(this).parents('.list-product');
		let id = $('td.product_id', parentRow).attr('data-id');
		let statusId = $(this).attr('data-id');
		$(this).toggleClass('status');
		postData = {
			id: id,
			statusId: statusId,
			status: status
		}

		$.ajax({
			type: 'POST',
			async: true,
			url: '/products/updateStatus/',
			data: postData,
			dataType: 'json',
			success: function (data) {
				if (data['success']) {
					if (Number(data['status']) === 0) {
						$this.prop('value', 'Не куплен');
						$this.attr('data-id', 0);
						$this.attr('class', 'status notBought btn btn-success')
					} else {
						$this.prop('value', 'Куплен');
						$this.attr('data-id', 1);
						$this.attr('class', 'status bought btn btn-danger');
					}

				}

			}
		});
	});
	$(document).on('click', '.editProduct', function () {
		let parentRow = $(this).parents('.list-product');
		let id = $('td.product_id', parentRow).attr('data-id');
		$.ajax({
			type: 'POST',
			async: true,
			url: '/products/editProduct/' + id,
			data: {
				id: id,
			},
			dataType: 'json',
			success: function (data) {
				if (data.success) {
					$('#editProductModal #editTitleProduct').attr('data-id', data.productsById.id);
					$('#editProductModal #editTitleProduct').val(data.productsById.title);
					$('.default').text(data.productsById.category_title);
					$('.defaultStatus').text(data.productsById.status);
					if (Number(data.productsById.status) === 0) {
						$('#editProductModal .defaultStatus').attr('data-id',0);
						$('#editProductModal .defaultStatus').text('Не куплен');
						$('#editProductModal .statusText').text('Куплен');
						$('#editProductModal .statusText').attr('data-id',1);
						$('.itemStatus_' + id).attr('class', 'status notBought btn btn-success');
					}else {
						$('.defaultStatus').text('Куплено');
						$('#editProductModal #editStatus .defaultStatus').attr('data-id',1);
						$('#editProductModal #editStatus .statusText').text('Не куплен');
						$('#editProductModal #editStatus .statusText').attr('data-id',0);
						$('.itemStatus_' + id).attr('class', 'status bought btn btn-danger');
					}
					$('#editProductModal #editPrice').val(data.productsById.price);
					$('#editProductModal #editPublishedDate').val(data.productsById.published_date);
				}
			}
		});
	});
	$(document).on("click", "#addCategory", function (event) {
		event.preventDefault();
		let data = {
			titleCategory: $('#titleCategory').val(),
		};
		if (data.titleCategory === '') {
			$(".blockAddCategory").html('Заполните поле').css('background-color', 'red').show();
			$(".blockAddCategory").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$.ajax({
				type: 'POST',
				async: true,
				url: "/products/addCategories",
				data: data,
				dataType: 'json',
				success: function (response) {
					if (response) {
						$('#addProductModal').fadeOut();
						$(".modal-backdrop").fadeOut();
					}
				}
			});
		}
	});
	$(document).on("click", "#filter-category", function (event) {
		event.preventDefault();
		let filterCategoryTitle = $('#search-category').val();
		let postData = {
			filterCategoryTitle: filterCategoryTitle,
		};
		if (postData.filterCategoryTitle === '') {
			$(".blockFilterCategoryStatus").html('Укажите категорию для поиска').css('background-color', 'red').show();
			$(".blockFilterCategoryStatus").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$('.list-product').remove();

			$.ajax({
				type: 'POST',
				async: true,
				url: "/products/findProductByCategoryId",
				data: {
					filterCategoryTitle: filterCategoryTitle,
				},
				dataType: 'json',
				success: function (data) {
					if (data) {
						$("#product-list tbody:last-child").append(data.filterData);
					}
				}
			});
		}
	});
	$(document).on("click", "#filter-status", function (event) {
		event.preventDefault();
		let filterStatusTitle = $('#search-status').val();
		let postData = {
			filterStatusTitle: filterStatusTitle,
		};
		if (postData.filterStatusTitle === '') {
			$(".blockFilterCategoryStatus").html('Укажите статус для поиска').css('background-color', 'red').show();
			$(".blockFilterCategoryStatus").fadeOut(2000).fadeOut('slow');
			return false;
		} else {
			$('.list-product').remove();

			$.ajax({
				type: 'POST',
				async: true,
				url: "/products/findProductByStatusId",
				data: {
					filterStatusTitle: filterStatusTitle,
				},
				dataType: 'json',
				success: function (data) {
					if (data) {
						$("#product-list tbody:last-child").append(data.filterData);
					}
				}
			});
		}
	});
});
