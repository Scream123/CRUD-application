<div class="container">
	<h1>Все товары</h1>
	<span class="blockDeleteProduct"></span>
	<div class="row">
		<div class="col-xs-12" style="margin-right: 10px">
			<button class="btn btn-primary btn sm" data-target="#addProductModal" data-toggle="modal">Добавить товар
			</button>
			<div class="modal" id="addProductModal" tabindex="-1">
				<div class="modal-dialog">blockAddEditProduct
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Добавление товара</h4>
							<div class="blockAddProduct"></div>
							<div class="blockFilterCategoryStatus"></div>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<span class="blockEditProduct"></span>
							<form class="form-group">
								<div class="form-group">
									<label class="control-label col-xs-3" for="titleProduct">Название:</label>
									<div class="col-xs-9">
										<input type="text" class="form-control" id="titleProduct"
											   placeholder="Введите название" required="required">
									</div>
								</div>
								<div class="form-group">
									<label for="productCategory" class="control-label col-xs-3">Выберите
										категорию:</label>
									<div class="col-xs-3">
										<select class="form-control" id="productCategory" required="required">
											<?php
											foreach ($categories as $category): ?>

												<option value="<?= $category['id']; ?>"><?= $category['title']; ?></option>
											<?php endforeach; ?>

										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-3" for="price">Цена:</label>
									<div class="col-xs-9">
										<input type="number" class="form-control" id="price" placeholder="Введите цену"
											   required="required">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-3" for="publishedDate">Дата публикации:</label>
									<div class="col-xs-9">
										<input type="date" class="form-control" id="publishedDate"
											   placeholder="Введите дату" required="required">
									</div>
								</div>
								<br/>
								<div class="form-group">
									<div class="col-xs-offset-3 col-xs-9">
										<input type="button" class="btn btn-primary btn-sm" id="addProduct"
											   value="Добавить Товар"/>
										<input type="reset" class="btn btn-default" value="Очистить форму">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary" data-dismiss="modal">Закрыть</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<button class="btn btn-primary btn sm" data-target="#addCategoryModal" data-toggle="modal">Добавить
				Категорию
			</button>
			<div class="modal" id="addCategoryModal" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Добавление категории</h4>
							<div class="blockAddCategory"></div>
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<form class="form-group">
								<div class="form-group">
									<label class="control-label col-xs-3" for="title">Название:</label>
									<div class="col-xs-9">
										<input type="text" class="form-control" id="titleCategory"
											   placeholder="Введите название">
									</div>
								</div>
								<br/>
								<div class="form-group">
									<div class="col-xs-offset-3 col-xs-9">
										<input type="button" class="btn btn-primary btn-sm" id="addCategory"
											   value="Добавить Категорию"/>
										<input type="reset" class="btn btn-default" value="Очистить форму">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary" data-dismiss="modal">Закрыть</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="editProductModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Редактирование товара</h4>
						<div id="blockEditProduct"></div>
						<button class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<span id="blockEditProduct"></span>
						<form class="form-group">
							<div class="form-group">
								<label class="control-label col-xs-3" for="editTitleProduct">Название:</label>
								<div class="col-xs-9">
									<input type="text" data-id="" class="form-control" id="editTitleProduct" value=""
										   required="required">
								</div>
							</div>
							<div class="form-group">
								<label for="editProductCategory" class="control-label col-xs-3">Категория:</label>
								<select class="form-control" id="editProductCategory" required="required">
									<option class="default" value="" data-id="<?= $category['id']; ?>"
											selected="selected"></option>
									<?php
									foreach ($categories as $category): ?>
										<option value="<?= $category['title']; ?>"
												data-id="<?= $category['id']; ?>"><?= $category['title']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" for="editPrice">Цена:</label>
								<div class="col-xs-9">
									<input type="number" class="form-control" id="editPrice" value=""
										   required="required">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" for="editStatus">Статус:</label>
								<div class="col-xs-9">
									<select class="form-control" id="editStatus" required="required">
										<option class="defaultStatus" value="" selected="selected"></option>
										<option class="statusText" data-id="" value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-3" for="editPublishedDate">Дата публикации:</label>
								<div class="col-xs-9">
									<input type="date" class="form-control" id="editPublishedDate" value=""
										   required="required">
								</div>
							</div>
							<br/>
							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-9">
									<input type="button" class="btn btn-primary btn-sm updateProduct" id="updateProduct"
										   value="Сохранить"/>
									<input type="reset" class="btn btn-default" value="Очистить форму">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>
		<br/><br/>
		<div class="input-group col-xs-12">
			<input class="form-control py-2" placeholder="Введите категорию" list="category-list" type="text" value=""
				   id="search-category">
			<datalist id="category-list">
				<?php
				foreach ($categories as $category): ?>
					<option><?= $category['title']; ?></option>
				<?php endforeach; ?>
			</datalist>
			<span class="input-group-append">
        <button class="btn btn-outline-secondary" id="filter-category" type="button">
            Отфильтровать по категории
        </button>
					<input class="form-control py-2" placeholder="Введите статус" list="status-list" type="text"
						   value="" id="search-status">
				<datalist id="status-list">
				<?php
				//var_dump($statusId);
				foreach ($statusId as $status): ?>
					<option><?= $statusText = (int)$status === 0 ? $statusBuy : $statusNotBuy; ?></option>
				<?php endforeach; ?>
			</datalist>
			<span class="input-group-append">
        <button class="btn btn-outline-secondary" id="filter-status" type="button">
            <i class="fa fa-search"></i>Отфильтровать по Статусу
        </button>
		</div>

	</div>

	<br/><br/>
	<table id="product-list" class="table wy-table-responsive">
		<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Название</th>
			<th scope="col">Категория</th>
			<th scope="col">Цена</th>
			<th scope="col">Статус</th>
			<th scope="col">Дата добавления</th>
			<th scope="col">Редактирование товара</th>
			<th scope="col">Удаление товара</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$number = 1;
		foreach ($products as $product):
		?>
		<!-- modal window to show products-->
		<div class="modal" id="showProductModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Карточка товара</h4>
						<div id="blockShowProduct"></div>
						<button class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<span id="blockShowProduct"></span>
						<form class="form-group">
							<div class="form-group">
								<p">Название:</p>
								<div class="col-xs-9">
									<h3 class="titleProductModalBody"></h3>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<p>Название категории:</p>
									<h3 class="categoryTitleModalBody"></h3>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-9">
									<p>Цена:</p>
									<h3 class="priceProductModalBody"></h3>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-9">
									<p>Статус:</p>
									<h3 class="statusProductModalBody"></h3>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-9">
									<p>Дата публикации:</p>
									<h3 class="dateModalBody"></h3>
								</div>
							</div>
							<br/>
							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-9">
									<input type="button" class="btn btn-primary btn-sm" id="addProduct"
										   value="Добавить Товар"/>
									<input type="reset" class="btn btn-default" value="Очистить форму">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>
		<!--show products-->
		<tr class="list-product">
			<td class="product_id" data-id="<?= $product['id'] ?>"><?= $number++ ?></td>
			<td class="title itemTitle_<?= $product['id'] ?>"><?= $product['title']; ?></td>
			<td class="categoryTitle itemCategoryTitle_<?= $product['id'] ?>"
				data-id="<?= $product['category_id']; ?>"><?= $product['category_title']; ?></td>
			<td class="price itemPrice_<?= $product['id'] ?>"><?= $product['price']; ?></td>
			<?php if ((int)$product['status'] == 0): ?>
				<td><input type="button" class="status notBought btn btn-success itemStatus_<?= $product['id'] ?>"
						   data-id="0" value="Не куплено"></td>
			<?php else: ?>
				<td><input type="button" class="status bought btn btn-danger itemStatus_<?= $product['id'] ?>"
						   data-id="1" value="Куплено"></td>
			<?php endif; ?>
			<td class="date itemDate_<?= $product['id'] ?>"><?= $product['published_date']; ?></td>
			<td><input type="button" id="editProduct" class="btn btn-warning btn-sm editProduct"
					   data-target="#editProductModal" data-toggle="modal" value="Редактировать"/>

			</td>
			<td><input type="button" id="deleteProduct" class="btn btn-danger btn-sm deleteProduct" value="Удалить"/>
			</td>
</div>
<?php endforeach; ?>

</tbody>
</table>
