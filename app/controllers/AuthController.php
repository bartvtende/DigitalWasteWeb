<?php

class AuthController extends BaseController {

    /**
     * Authenticate the users Dropbox
     *
     * @return mixed
     */
    public function authenticate()
    {
        $session_user_id = Session::get('user_id');

        if (!is_null($session_user_id)) {
            $user = DropboxUser::find($session_user_id);
            if ($user) {
                return Redirect::route('home')->with('message', 'Je hebt al meegedaan aan dit onderzoek, hartelijk bedankt!');
            }
        }

        $dropbox = new Dropbox();
        $url = $dropbox->init();

        return Redirect::to($url);
    }

    /**
     * Stores the users
     *
     * @return mixed
     */
    public function store()
    {
        // Store the Dropbox
        $dropbox = new Dropbox();
        $dropbox->store();

        return Redirect::route('indexing');
    }

}