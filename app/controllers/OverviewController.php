<?php

class OverviewController extends \BaseController
{

    /**
     * Serves and results/overview page to the user
     * The page is populated with the users data if the user has filled in the survey
     *
     * @param null $id
     * @return mixed
     */
    public function overviewDropbox($id = null)
    {
        $dropboxOverview = new DropboxOverview();

        // Initialize the user variable
        $user = null;

        // Try to find the user
        if (!is_null($id)) {
            $user = DropboxUser::find($id);
        }

        if (!is_null($user)) {
            // Check if the requested user id is equal to the session user id
            if ($user->id == Session::get('user_id')) {
                // Get the results for the user
                $userResults = DropboxResult::where('user_id', $id)->first();

                // Render overview view for a non-participant
                $results = $dropboxOverview->overview();

                // Render overview view for a participant
                return View::make('digitalwaste.overview')
                    ->with('userResults', $userResults)
                    ->with('results', $results);
            }
        }
        $results = $dropboxOverview->overview();

        // Render overview view for a non-participant
        return View::make('digitalwaste.overview')
            ->with('results', $results);

    }

}