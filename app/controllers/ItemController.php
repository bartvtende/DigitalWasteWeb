<?php

class ItemController extends \BaseController {

    /**
     * Serves a file, including the information, to the user
     *
     * @param $id
     * @return mixed
     */
    public function showDropbox($id)
    {
        // Find a unseen file for this user
        $dropboxItem = new DropboxItem();
        $file = $dropboxItem->findFile($id);

        // Make the view for the file if it exists
        if (!is_null($file)) {
            if ($file == 'overview') {
                // Create the overview view for this user
                $dropboxOverview = new DropboxOverview();
                $results = $dropboxOverview->overviewUser($id);

                // Render overview view for a participant
                return Redirect::route('overview-dropbox-user' . $id);
            } else {
                return  View::make('digitalwaste.item')
                        ->with('file', $file);
            }
        }

        return Redirect::route('home');
    }

    /**
     * Saves the rating into the DB and serves a new item
     *
     * @param $id
     * @return mixed
     */
    public function rateDropbox($id)
    {
        // Find a the file for this user
        $dropboxItem = new DropboxItem();
        $file = $dropboxItem->findFile($id);

        if ($file == 'overview') {
            // Create the overview view for this user
            $dropboxOverview = new DropboxOverview();
            $results = $dropboxOverview->overviewUser($id);

            // Render overview view for a participant
            return Redirect::route('overview-dropbox-user', $id);
        }

        // Get the rating from the user
        $rating = Input::get('rating');

        // Check if the rating is valid
        if ($rating >= 1 && $rating <= 5) {
            // Store the file as "seen" and store the rating
            $file->seen     = 1;
            $file->rating   = $rating;
            $file->save();

            // Find a new file for the user
            $file = $dropboxItem->findFile($id);

            // Render the view for the file
            if (!is_null($file)) {
                if ($file == 'overview') {
                    // Create the overview view for this user
                    $dropboxOverview = new DropboxOverview();
                    $results = $dropboxOverview->overviewUser($id);

                    // Render overview view for a participant
                    return Redirect::route('overview-dropbox-user', $id);
                } else {
                    return  View::make('digitalwaste.item')
                        ->with('file', $file);
                }
            }
        } else {
            // Renders a view with an error message
            return  View::make('digitalwaste.item')
                    ->with('file', $file)
                    ->with('message', 'Je moet een waarde aan dit item geven.');
        }

    }

}