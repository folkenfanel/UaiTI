<?php
/**
 * @link lib/Cake/Controller/Controller.php
 */
App::uses('AppController', 'Controller');

/**
 * @name RecipesController
 * @package app/Controller
 * @author Maximiliano Catarino
 */
abstract class RestController extends AppController {
	/**
	 * @var Model
	 */
	protected $model;
	
	/**
	 * Componentes disponíveis
	 * @var array
	 */
	public $components = array (
		'RequestHandler'
	);
	
	public $layout = null;
	
	/**
	 * GET ALL
	 * @name index
	 * @access public
	 */
	public function index() {
		$rowSet = ClassRegistry::init($this->model->name)->selectAll();	
		$this->set($this->model->name, json_encode($rowSet) );
	}
	
	public function filter() {
		$conditions = $this->getFilterConditions();
		$rowSet = ClassRegistry::init($this->model->name)->selectAll($conditions);
		$this->set($this->model->name, json_encode($rowSet) );
	}
	
	/**
	 * GET ROW
	 * @name view
	 * @param int $id ROW ID
	 * @access public
	 */
	public function view($id) {
		$row = ClassRegistry::init($this->model->name)->selectRow($id);
		$this->set($this->model->name, json_encode($row) );
	}
	
	/**
	 * PUT ROW
	 * @name edit
	 * @param int $id ROW ID
	 * @access public
	 */
	public function edit($id) {
		$this->model->id = $id;
		if ($this->model->save ( $this->request->data )) {
			$message = 'Saved';
		} else {
			$message = 'Error';
		}
		$this->set ( array (
				'message' => $message,
				'_serialize' => array (
						'message' 
				) 
		) );
	}
	
	/**
	 * DELETE ROW
	 * @name edit
	 * @param int $id ROW ID
	 * @access public
	 */
	public function delete($id) {
		if ($this->model->delete ( $id )) {
			$message = 'Deleted';
		} else {
			$message = 'Error';
		}
		$this->set ( array (
				'message' => $message,
				'_serialize' => array (
						'message' 
				) 
		) );
	}
}