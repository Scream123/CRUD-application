<?php

class Categories_model extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * @return mixed
	 */
	public function getCategories()
	{
			$query = $this->db->get('categories');

			return $query->result_array();
	}

	public function getCategoriesById($id)
	{
		$this->db->where('c.id', $id);
		$this->db->select('c.title')
			->from('categories c');
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * @param $data
	 * @return bool
	 */
	public function addCategories($data)
	{
		$this->db->insert('categories',$data);

		return true;
	}

	/**
	 * @param $categoryTitle
	 * @return mixed
	 */
	public function getCategoryList($categoryTitle)
	{
		$this->db->where('c.title', $categoryTitle);
		$this->db->select('c.id')
			->from('categories c');
		$query = $this->db->get();
		$result = $query->row()->id;

		return $result;
	}
}
