<?php

class HomeController extends BaseController {

	/**
	 * Serves the homepage to the user
	 *
	 * @return mixed
	 */
	public function digitalwaste()
	{
		return View::make('digitalwaste.home');
	}

}
