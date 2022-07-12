<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{
	public $statusBuy = 'Куплен';
	public $statusNotBuy = 'Не куплен';
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('products_model');
		$this->load->model('categories_model');
	}

	/**
	 * @return void
	 */
	public function index()
	{
		$data['statusBuy'] = $this->statusBuy;
		$data['statusNotBuy'] = $this->statusNotBuy;
		$data['title'] = 'Все товары';
		$data['products'] = $this->products_model->getProducts();
		$data['categories'] = $this->categories_model->getCategories();
		$statuses = $this->products_model->getStatusByTitle();
		$data['statusId'] = [];
		foreach ($statuses as $key => $status) {
			$data['statusId'][] = $key;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('products/index', $data);
		$this->load->view('templates/footer');
	}

	/**
	 * @param $slug
	 * @return void
	 */
	public function view($slug = NULL)
	{
		$data['products_item'] = $this->products_model->getProducts($slug);
		if(empty($data['products_item'])) {
			show_404();
		}
		$data['title'] = $data['products_item']['title'];
		$this->load->view('templates/header', $data);
		$this->load->view('products/view', $data);
		$this->load->view('templates/footer');
	}

	/**
	 * @return void
	 */
	public function addProducts()
	{
		$data['title'] = isset($_POST['titleProduct']) ? $_POST['titleProduct'] : null;
		$data['category_id'] = isset($_POST['productCategory']) ? $_POST['productCategory'] : null;
		$data['price'] = isset($_POST['price']) ? $_POST['price'] : null;
		$data['published_date'] = isset($_POST['publishedDate']) ? $_POST['publishedDate'] : null;
			$categoryTitle = $this->categories_model->getCategoriesById($data['category_id']);
			$category = [];
			foreach ($categoryTitle as $key => $categoryValue) {
				$category = $categoryValue;
			}
		if ($data['title'] !== null) {
			$data['slug'] = $category['title'] . '-' .	$data['title'];
		} else {
			$data['slug'] = null;
		}
		$countProduct = count($this->products_model->getProductsCounter());
		$res['add_product'] = $this->products_model->addProducts($data);
		$product = $this->products_model->getLastProduct();
		$number = 1;
		if ($res) {
			$resData['success'] = 1;
			$resData['message'] = 'Изменения успешно внесены';
			$counter  = $countProduct+1 . '.';
			if ((int)$product['status'] === 0) {
				$statusElement = '
						<td>
						<input type="button" class="status notBought btn btn-success" data-id="0"  value="'.$this->statusNotBuy.'">
						</td>';
			} else {
				$statusElement = '
						<td>
							<input type="button" class="status bought btn btn-danger" data-id="1"  value="'.$this->statusBuy.'">
						</td>';
			}
			$resData['filterData'][] = '
				<tr class="list-product">
					<td   class="product_id counter_' . $product['id'] . '" data-id=' . $product['id'] . $counter . '"></td>
					<td class="title itemTitle_' . $product['id'] . '">' . $product['title'] . '</td>
					<td class="categoryTitle itemCategoryTitle_' . $product['id'] . '">' . $product['category_title'] . '</td>
					<td class="price itemPrice_' . $product['id'] . '">' . $product['price'] . '</td>
					    '.$statusElement.'
					<td class="date itemDate_' . $product['id'] . '">' . $product['published_date'] . '</td>
					<td>
						<input type="button" id="editProduct" class="btn btn-warning btn-sm editProduct"
					  		data-target="#editProductModal" data-toggle="modal" value="Редактировать"/>
					</td>
					<td>
						<input type="button" id="deleteProduct" class="btn btn-danger btn-sm deleteProduct" 
							value="Удалить"/>
					</td>
				</tr>';
		}
		else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка изменения данных';
		}
		echo json_encode($resData);
	}

	/**
	 * delete book
	 */
	public function deleteProducts()
	{
		$productId = isset($_POST['id']) ? intval($_POST['id']) : null;
		if (!$productId) exit();
		$res = $this->products_model->deleteProduct($productId);
		if ($res) {
			$resData['success'] = 1;
			$resData['message'] = 'товар удалён';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'ошибка при удалении';
		}
		echo json_encode($resData);
	}

	/**
	 * @return void
	 */
	public function editProduct() {
		$productId = isset($_POST['id']) ? intval($_POST['id']) : null;
		if (!$productId) exit();
		$resData['productsById'] = $this->products_model->getProductById($productId);
		if (!empty($resData)) {
			$resData['success'] = 1;
			$resData['message'] = 'Идентификатор получен';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'ошибка при получении идентификатора';
		}
		echo json_encode($resData);
	}

	/**
	 * @return void
	 */
	 public function updateProduct()
	{
		$data['id'] = trim(htmlspecialchars(htmlentities(($_POST['id']))));
		$product = $this->products_model->getProductById($data['id']);
		$data['title'] = trim(htmlspecialchars(htmlentities(($_POST['title']))));
		$data['category_id'] = $product['category_id'];
		$data['categories'] = $this->categories_model->getCategories();
		$categoryTitle = '';
		foreach ($data['categories'] as $key => $category) {
			if ($data['category_id'] == $category['id']) {
				$data['categoryTitle'] = $category['title'];
			}
		}
		$data['price'] = trim(htmlspecialchars(htmlentities(($_POST['price']))));
		$data['status'] = trim(htmlspecialchars(htmlentities(($_POST['status']))));
		$data['date'] = trim(htmlspecialchars(htmlentities(($_POST['date']))));
		$data['date'] = trim(htmlspecialchars(htmlentities(($_POST['date']))));
		$data['category_name'] = trim(htmlspecialchars(htmlentities(($_POST['category_name']))));
		foreach ($data['categories'] as $key => $category) {
			if ($data['category_name'] == $category['title']) {
				$data['category_id'] = $category['id'];
			}
		}
		$res = $this->products_model->updateProduct($data['id'], $data['title'], $data['category_id'], $data['price'],
			$data['status'], $data['date']);
		if ($res) {
			$resData['itemParameters']  = $data;
			$resData['success'] = 1;
			$resData['message'] = 'Изменения успешно внесены';
		} else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка изменения данных';
		}

		echo json_encode($resData);
	}

	/**
	 * @return void
	 */
	public function updateStatus()
	{
		$id = trim(htmlspecialchars(htmlentities(($_POST['id']))));
		$statusIdSelected = trim(htmlspecialchars(htmlentities(($_POST['statusId']))));
		$statusId = (int)$statusIdSelected === 0 ? 1 : 0;
		$res = $this->products_model->updateStatus($id, $statusId);

		if ($res) {
			$resData['status'] = $statusId;
			$resData['success'] = 1;
			$resData['message'] = 'Изменения успешно внесены';

		} else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка изменения данных';
		}

		echo json_encode($resData);
	}

	/**
	 * @return void
	 */
	public function addCategories()
	{
		$data['title'] = isset($_POST['titleCategory']) ? $_POST['titleCategory'] : null;
		$res['addCategory'] = $this->categories_model->addCategories($data);
		if ($res) {
			$resData['success'] = 1;
			$resData['message'] = 'Категория добавлена';
		}else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка добавления категории';
		}

		echo json_encode($resData);
	}

	/**
	 * @return void
	 */
	public function findProductByCategoryId()
	{
		$data['filterCategoryTitle'] = isset($_POST['filterCategoryTitle']) ? $_POST['filterCategoryTitle'] : null;
		$categoryId = $this->categories_model->getCategoryList($data['filterCategoryTitle']);

		$res = $this->products_model->findProductByCategoryId($categoryId);
		if ($res) {
			$counter  = 0;
			$resData['success'] = 1;
			$resData['message'] = 'Поиск товара по категории успешен';
			foreach ($res as $product) {

				$counter+=1;
				if ((int)$product['status'] === 0) {
					$statusElement = '
						<td>
						<input type="button" class="status notBought btn btn-success" data-id="0"  value="'.$this->statusNotBuy.'">
						</td>';
				} else {
					$statusElement = '
						<td>
							<input type="button" class="status bought btn btn-danger" data-id="1"  value="'.$this->statusBuy.'">
						</td>
						';
				}
				$resData['filterData'][] = '<tr class="list-product">
						<td   class="product_id counter_' . $product['id'] . '" data-id=' . $product['id'] . '">' .  $counter . '</td>
						<td class="title itemTitle_' . $product['id'] . '">' . $product['title'] . '</td>
						<td class="categoryTitle itemCategoryTitle_' . $product['id'] . '">' . $product['category_title'] . '</td>
						<td class="price itemPrice_' . $product['id'] . '">' . $product['price'] . '</td>
						'.$statusElement.'
						<td class="date itemDate_' . $product['id'] . '">' . $product['published_date'] . '</td>
						<td>
							<input type="button" id="editProduct" class="btn btn-warning btn-sm editProduct"
						  		data-target="#editProductModal" data-toggle="modal" value="Редактировать"/>
						</td>
						<td>
							<input type="button" id="deleteProduct" class="btn btn-danger btn-sm deleteProduct" 
								value="Удалить"/>
						</td>
					</tr>';
			}
		}else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка при поиске товара по категории';
		}
		echo json_encode($resData);
	}

	/**
	 * @return int|void
	 */
	public function findProductByStatusId()
	{
		$data['filterCategoryTitle'] = isset($_POST['filterStatusTitle']) ? $_POST['filterStatusTitle'] : null;
		$resultData['error'] = 0;
		if ($data['filterCategoryTitle'] === $this->statusNotBuy) {
			$statusId = 0;
		} elseif ($data['filterCategoryTitle'] === $this->statusBuy) {
			$statusId = 1;
		} else{
			return $resultData['error'] = 1 ;
		}
		$res = $this->products_model->findProductByStatusId($statusId);
		if ($res && $resultData['error'] === 0) {
			$counter  = 0;
			$resData['success'] = 1;
			$resData['message'] = 'Поиск товара по статусу успешен';
			foreach ($res as $product) {
				//var_dump($product['status']);
				$counter+=1;
				if ((int)$product['status'] === 0) {
					$statusElement = '
						<td>
						<input type="button" class="status notBought btn btn-success" data-id="0"  value="'.$this->statusNotBuy.'">
						</td>';
				} else {
					$statusElement = '
						<td>
							<input type="button" class="status bought btn btn-danger" data-id="1"  value="'.$this->statusBuy.'">
						</td>';
				}
				$resData['filterData'][] = '<tr class="list-product">
						<td   class="product_id counter_' . $product['id'] . '" data-id=' . $product['id'] . '">' .  $counter . '</td>
						<td class="title itemTitle_' . $product['id'] . '">' . $product['title'] . '</td>
						<td class="categoryTitle itemCategoryTitle_' . $product['id'] . '">' . $product['category_title'] . '</td>
						<td class="price itemPrice_' . $product['id'] . '">' . $product['price'] . '</td>
						'.$statusElement.'
						<td class="date itemDate_' . $product['id'] . '">' . $product['published_date'] . '</td>
						<td>
							<input type="button" id="editProduct" class="btn btn-warning btn-sm editProduct"
						  		data-target="#editProductModal" data-toggle="modal" value="Редактировать"/>
						</td>
						<td>
							<input type="button" id="deleteProduct" class="btn btn-danger btn-sm deleteProduct" 
								value="Удалить"/>
						</td>
					</tr>';
			}
		}else {
			$resData['success'] = 0;
			$resData['message'] = 'Ошибка при поиске товара по статусу';
		}
		echo json_encode($resData);
	}
}
