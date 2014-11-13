<?php

class Selected extends \Eloquent {

	public $timestamps = false;

	protected $table = 'selected';
	protected $data;

	public function __construct() {
		$this->data = new Data();
	}

}