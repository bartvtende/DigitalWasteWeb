<?php

class CrawlerController extends \BaseController
{

    /**
     * Calls the crawler and saves the crawler's random files
     *
     * @return mixed
     */
    public function index()
    {
        $dropbox = new Dropbox();
        $result = $dropbox->check();

        if ($result instanceof Dropbox\Client) {
            // Get 10 random items from the users Dropbox
            $crawler = new DropboxCrawler();
            $redirectRoute = $crawler->crawl($result, 10, 10);

            // Redirect to the given route
            if (is_array($redirectRoute)) {
                return Redirect::route($redirectRoute[0], $redirectRoute[1]);
            } else {
                return Redirect::route($redirectRoute);
            }
        } else {
            // Redirect to the authentication page
            return Redirect::to($result);
        }
    }

}