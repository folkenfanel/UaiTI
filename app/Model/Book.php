<?php
App::uses('AppModel', 'Model');

class Book extends AppModel {
	
	public $primaryKey = 'id';
	
	public $displayField = 'title';
	
	public $validate = array(
			'id' => array(
				'rule'     => 'naturalNumber'
			),
			'title' => array(
				'required' => array(
					'rule' => 'notEmpty'
				),
				'alphanumeric' => array(
       				'rule' => 'alphanumeric',
					'message' => 'O título deve conter apenas letras e números'
   				),
				'size' => array(
					'rule' => array('between', 1, 100),
					'message' => 'O título deve conter entre 1 e 100 letras'
				)
			),
			'author' => array(
				'required' => array(
					'rule' => 'notEmpty'
				),
				'alphanumeric' => array(
					'rule' => 'alphanumeric',
					'message' => 'O nome do autor deve conter apenas letras e números'
				),
				'size' => array(
					'rule' => array('between', 1, 50),
					'message' => 'O nome do autor deve conter entre 1 e 50 letras'
				)
			),
			'publisher' => array(
				'alphanumeric' => array(
					'rule' => 'alphanumeric',
					'message' => 'O nome da editora deve conter apenas letras e números'
				),
				'size' => array(
					'rule' => array('between', 1, 100),
					'message' => 'O nome da editora deve conter entre 1 e 100 letras'
				)
			),
			'isbn' => array(
				'unique' => array(
					'rule'    => 'isUnique',
					'message' => 'Este ISBN já foi cadastrado'
				),
				'required' => array(
					'rule' => 'notEmpty'
				),
				'naturalNumber' => array(
					'rule' => 'naturalNumber',
					'message' => 'O código ISBN deve conter apenas números'
				),
				'size' => array(
					'rule' => array('between', 10, 13),
					'message' => 'O código ISBN deve conter entre 10 e 13 números.'
				)
			)
	);

	/**
	 * Adaptador de dados para coleção de registro que converte strings para UTF-8
	 * @name rowSetDataAdapter
	 * @param array $rowSet Result set
	 * @access private
	 * @return void
	 */
	private function rowSetDataAdapter(&$rowSet)
	{
		if (!empty($rowSet))
			array_walk($rowSet, function(&$item, $k) {
				$item['Book']['title']     = utf8_encode($item['Book']['title']);
				$item['Book']['author']    = utf8_encode($item['Book']['author']);
				if (!empty($item['Book']['publisher']))
					$item['Book']['publisher'] = utf8_encode($item['Book']['publisher']);
				$item = $item['Book'];
			});
	}
	
	/**
	 * Adaptador de dados para dados de um registro que converte strings para UTF-8
	 * @name rowDataAdapter
	 * @param array $row Dados de um registro
	 * @access private
	 * @return void
	 */
	private function rowDataAdapter(&$row)
	{
		$row = array($row);
		$this->rowSetDataAdapter($row);
	}
	
	/**
	 * Retorna registros com estrutura de dados para gerar JSON
	 * @name selectAll
	 * @param array $conditions condições de pesquisa
	 * @access public
	 * @return array
	 */
	public function selectAll($options = array()) {
		$options['fields'] = array('title', 'author');
		$rowSet = $this->find('all', $options);
		$this->rowSetDataAdapter($rowSet);
		return $rowSet;
	}

	/**
	 * Retorna dados do registro
	 * @name selectRow
	 * @param int $id ID do registro
	 * @access public
	 * @return array
	 */
	public function selectRow($id)
	{
		if (is_numeric($id)) {
			$row = $this->find('first', array('conditions' => array("Book.id = {$id}"), 'fields' => array('title', 'author', 'isbn', 'publisher')));
			$this->rowDataAdapter($row);
			return $row[0];
		}
		return array();
	}
}