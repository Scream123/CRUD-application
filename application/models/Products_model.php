<?php

class Products_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * @param $slug
	 * @return mixed
	 */
	public function getProducts($slug = FALSE)
	{
		if ($slug ===FALSE) {
			$this->db->where('deleted_at', NULL);
			$this->db->select('p.*, categories.title category_title')
				->from('products p')
				->join('categories', 'p.category_id = categories.id');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}

		$query = $this->db->get_where('products', ['slug' => $slug]);
		return $query->row_array();
	}

	/**
	 * @param $data
	 * @return bool
	 */
	public function addProducts($data)
	{
		$this->db->insert('products',$data);

		return true;
	}

	/**
	 * @param $productId
	 * @return mixed
	 */
	public function deleteProduct($productId)
	{
		$this->db->set('deleted_at', 'CURRENT_TIMESTAMP');
		$this->db->where('id', $productId);
		$query = $this->db->update('products');

		return $query;
	}

	/**
	 * @return mixed
	 */
	public function getProductsCounter()
	{
		$this->db->where('deleted_at', NULL);
		$this->db->select('title')
			->from('products');
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * @param $productId
	 * @param $title
	 * @param $categoryId
	 * @param $price
	 * @param $status
	 * @param $date
	 * @return mixed
	 */
	public function updateProduct($productId, $title,  $categoryId, $price, $status, $date)
	{
		$set = [];

		if ($title) {
			$set[] = "`title` = '{$title}'";
		}
		if ($categoryId) {
			$set[] = "`category_id` = '{$categoryId}'";
		}

		if ($price) {
			$set[] = "`price` = '{$price}'";
		}
		if ($status) {
			$set[] = "`status` = '{$status}'";
		}
		if ($date) {
			$set[] = "`published_date` = '{$date}'";
		}


		$setStr = implode(', ', $set);
		$sql = "UPDATE products SET {$setStr}
            WHERE `id` = '{$productId}'";
		//	var_dump($sql);
		return $this->db->query($sql);
	}

	/**
	 * @param $productId
	 * @param $status
	 * @return mixed
	 */
	public function updateStatus($productId, $status)
	{
		$set = [];

		$sql = "UPDATE products SET `status` =  {$status}
           WHERE `id` = '{$productId}'";

		return $this->db->query($sql);
	}

	/**
	 * @return array|mixed
	 */
	public function getLastProduct()
	{
		$result = [];
		$this->db->where('deleted_at', NULL);
		$this->db->select('p.*, categories.title category_title')
			->from('products p')
			->join('categories', 'p.category_id = categories.id')
		->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get();
		$products = $query->result_array();
		foreach($products as $product) {
			$result = $product;
		}
		return $result;
	}

	/**
	 * @param $productId
	 * @return array|mixed
	 */
	public function getProductById($productId)
	{
		$this->db->where(['p.id' => $productId, 'p.deleted_at' => NULL]);
		$this->db->select('p.*, categories.title category_title')
			->from('products p')
			->join('categories', 'p.category_id = categories.id');
		$query = $this->db->get();
		$result = $query->result_array();
		$product = [];
		foreach ($result as $res) {
			$product = $res;

		}
		return $product;
	}

	/**
	 * @param $categoryId
	 * @return mixed
	 */
	public function  findProductByCategoryId($categoryId)
	{
		$this->db->where(['p.category_id'=> $categoryId, 'p.deleted_at'=> NULL]);
		$this->db->select('p.*, categories.title category_title')
			->from('products p')
			->join('categories', 'p.category_id = categories.id');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	/**
	 * @param $statusId
	 * @return mixed
	 */
	public function  findProductByStatusId($statusId)
	{
		$this->db->where(['p.status'=> $statusId, 'p.deleted_at'=> NULL]);
		$this->db->select('p.*, categories.title category_title')
			->from('products p')
			->join('categories', 'p.category_id = categories.id');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	public function getStatusByTitle()
	{
		$this->db->distinct();
		$this->db->select('p.status')
			->from('products p');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;

	}
}
