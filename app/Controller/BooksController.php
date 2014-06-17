<?php
/**
 * @link app/Controller/RestController.php
 */
App::uses('RestController', 'Controller');

/**
 * @name BooksController
 * @package app/Controller
 * @author Maximiliano Catarino
 */
class BooksController extends RestController {
	public $name = 'Book';
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->model = $this->Book;
	}
}