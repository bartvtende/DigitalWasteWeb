<?php

class RateController extends \BaseController {

	protected $dataModel;
	protected $selectedModel;


	/**
	 * Constructor sets the limit of the data model
	 */
	public function __construct() {
		$this->dataModel 		= new Data();
		$this->selectedModel 	= new Selected();
	}


	/**
	 * Serves random data, can take the previous data in mind to avoid the same data.
	 *
	 * @param $previous
	 */
	public function serveData($previous = null) {
		$selectedData;

		// Continue from previous id
		if($previous != null) {
			// Previous id can't be found
			if(is_null($this->selectedModel->find($previous))) {
				$selectedData = $this->selectedModel->first();
			} else {
				// Select the next data
				$selectedData = $this->selectedModel->where('id', '>', $previous)->first();

				// If there's no next data, select first from selected table
				if(is_null($selectedData)) {
					$selectedData = $this->selectedModel->first();
				}
			}
		} else {
			// Else start from the beginning
			$selectedData = $this->selectedModel->first();
		}

		// Find the data corresponding the selected data
		$data = $this->dataModel->find($selectedData->data_id);

		// Render a view with the data
		return  View::make('data')
				->with('data', $data)
				->with('selectedData', $selectedData);
	}


	/**
	 * Posts the rating to the database.
	 */
	public function postRatingData() {
		$id = Input::get('id');
		$selectedId = Input::get('selectedId');
		$rating = Input::get('rating');

		$validator = Validator::make(['rating' => $rating], ['rating' => 'required']);

		if($validator->fails()) {
			return 	Redirect::back()
					->with('message', 'Geef alsjeblieft een beoordeling aan deze data!');
		}

		$selectedData = $this->dataModel->find($id);

		$result = $this->calculateRating($selectedData, $rating);

		if($result->save()) {
			echo "Rating has been saved";
		} else {
			echo "Something went wrong, please try again";
		}

		return Redirect::route('showRandomDataWithPrevious', $selectedId);
	}


	/**
	 * Calculates the new rating with the given rating and the data object.
	 *
	 * @param $selectedData, $rating
	 * @return $selectedData
	 */
	private function calculateRating($selectedData, $rating) {
		$selectedData;
		$amountOfRatings 		= $selectedData->amount;

		// If there are no rating, fill the database with the given rating
		if($amountOfRatings == 0) {
			$selectedData->amount 	= 1;
			$selectedData->rating 	= $rating;
		} else {
			// Otherwise calculate the rating
			$oldRating 				= $selectedData->rating;
			$newAmountOfRatings		= $amountOfRatings + 1;

			$newRating 				= (($oldRating * $amountOfRatings) + $rating) / $newAmountOfRatings;

			$selectedData->amount 	= $newAmountOfRatings;
			$selectedData->rating 	= $newRating;
		}

		return $selectedData;
	}

}
