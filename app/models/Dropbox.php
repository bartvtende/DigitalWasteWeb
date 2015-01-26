<?php

/**
 * Class Dropbox
 *
 * Initializes the Dropbox SDK
 */
class Dropbox {

    private $csrfTokenStore;

    private $dropboxKey;
    private $dropboxSecret;
    private $appName;

    public function __construct()
    {
        // Store CSRF token
        session_start();
        $this->csrfTokenStore = new Dropbox\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');

        // Configuration settings for the Dropbox SDK
        $this->dropboxKey       = 'xxx';
        $this->dropboxSecret    = 'xxx';
        $this->appName          = 'digitalwaste';
    }

    /**
     * Initializes the Dropbox SDK
     *
     * @return array
     */
    public function init()
    {
        $webAuth = $this->connect();
        $authUrl = $webAuth->start();

        return $authUrl;
    }

    /**
     * Stores the users Dropboxs accesstoken in session (not the DB!)
     *
     * @throws \Dropbox\WebAuthException_BadRequest
     * @throws \Dropbox\WebAuthException_BadState
     * @throws \Dropbox\WebAuthException_Csrf
     * @throws \Dropbox\WebAuthException_NotApproved
     * @throws \Dropbox\WebAuthException_Provider
     */
    public function store()
    {
        $webAuth = $this->connect();
        list($accessToken) = $webAuth->finish($_GET);

        // Save the Dropbox token in users session
        Session::put('accessToken', $accessToken);
    }

    /**
     * Checks if the accesstoken is valid
     *
     * @return \Dropbox\Client|\Dropbox\WebAuth
     */
    public function check()
    {
        // Get the Dropbox token from the users settings, otherwise redirect them to the login
        $dropboxToken = Session::get('accessToken');

        if ($dropboxToken)
        {
            // Return the Dropbox Client class
            $client = new Dropbox\Client($dropboxToken, $this->appName, 'UTF-8');
            return $client;
        } else {
            // Return the redirect URL
            $authUrl = $this->connect();
            return $authUrl;
        }
    }

    /**
     * Connects the app with the Dropbox API
     *
     * @return \Dropbox\WebAuth
     */
    private function connect()
    {
        $appInfo = new Dropbox\AppInfo($this->dropboxKey, $this->dropboxSecret);
        $webAuth = new Dropbox\WebAuth($appInfo, $this->appName, route('store-dropbox'), $this->csrfTokenStore);

        return $webAuth;
    }

}
