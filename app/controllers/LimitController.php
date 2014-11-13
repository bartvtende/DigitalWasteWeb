<?php

class LimitController extends \BaseController {

	protected $dataModel;
	protected $selectedModel;

	public function __construct() {
		$this->dataModel 		= new Data();
		$this->selectedModel 	= new Selected();
	}


	/**
	 * Sets the limit of the given data
	 *
	 * @param $limit
	 */
	public function setLimit($limit) {
		if($limit > 0 && $limit <= $this->dataModel->count()) {
			$allSelected = $this->selectedModel->all();
			$allData = $this->dataModel->all();

			if($limit > $allSelected->count()) {
				$counter = $limit - $allSelected->count();

				// Add new values
				foreach($allData as $newData) {
					foreach($allSelected as $selectedData) {
						if($newData->id != $selectedData->data_id) {
							$addData 			= new Selected();
							$addData->data_id 	= $newData->id;

							$addData->save();
							$counter--;
						}
					}
				}

				echo "Limit is changed, some values has been added to the selected data.";
			} else if($limit < $allSelected->count()) {
				$counter = $allSelected->count() - $limit;

				// Delete values
				$selectedData = $this->selectedModel->take($counter)->orderBy('id', 'desc')->get();

				foreach($selectedData as $deletedData) {
					$deletedData->delete();
				}

				echo "Limit is changed, some values are deleted from the selected data.";
			} else {
				// Limit is the same
				echo "Limit is the same, nothing has changed.";
			}
		} else {
			echo "Can't set limit to ". $limit;
		}
	}

}