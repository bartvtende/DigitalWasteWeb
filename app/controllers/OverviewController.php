<?php

class OverviewController extends \BaseController {
	
	protected $dataModel;
	protected $selectedModel;

	public function __construct() {
		$this->dataModel 		= new Data();
		$this->selectedModel 	= new Selected();
	}

	public function serveOverview() {
		$data = $this->dataModel->take(9)->orderBy('rating', 'desc')->get();
		
		return  View::make('overview')
				->with('data', $data);
	}

	public function serveOverviewData($id) {
		$data = $this->dataModel->find($id);

		return  View::make('overview-data')
				->with('data', $data);
	}
	
}