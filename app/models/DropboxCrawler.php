<?php

/**
 * Class DropboxCrawler
 *
 * Crawls to the users Dropbox files and generates random (old) files
 */
class DropboxCrawler
{
    private $deltaFiles;

    /**
     * Crawls through the users Dropbox files
     *
     * @param $client
     * @param $amount
     * @param $amountOfLoops
     * @return array|string
     */
    public function crawl($client, $amount, $amountOfLoops)
    {
        // Initialize DropboxStore class
        $store = new DropboxStore();

        // Get the username and store it in the DB
        $username = $client->getAccountInfo()['display_name'];
        $user = $store->storeUser($username);

        // Get 10 random files from the users Dropbox
        $randomFiles = $this->getRandomFiles($client, $amount, $amountOfLoops);

        // Store the file properties in the database and get the selected files
        $store->storeFiles($randomFiles, $user);

        $dropboxItem = new DropboxItem();
        $result = $dropboxItem->findFiles($client);

        if (!$result) {
            return 'home';
        } else {
            return ['show-dropbox', $result];
        }

    }

    /**
     * Get random files from the users Dropbox
     *
     * @param $client
     * @param $amount
     * @param $amountOfLoops
     * @return array
     */
    private function getRandomFiles($client, $amount, $amountOfLoops)
    {
        // Set the time limit to 5 minutes, in order to avoid PHP's maximum execution time of 60 seconds
        set_time_limit(300);

        $cursor = null;

        // Call the getDelta method x amount of times
        for ($i = 0; $i < $amountOfLoops; $i++) {
            $returnedCursor = $this->getDelta($client, $cursor);
            $cursor = $returnedCursor;
        }

        // Get each file (that is not a folder) and put it in an array
        foreach ($this->deltaFiles as $delta) {
            foreach ($delta['entries'] as $entry) {
                if ($entry[1]['is_dir'] == false) {
                    $files[] = $entry;
                }
            }
        }

        // Generate random keys for the files array
        $randomKeys = array_rand($files, $amount);

        // Get the files from the random keys
        foreach ($randomKeys as $key) {
            $randomFiles[] = $files[$key];
        }

        // Supported file types
        $types = ['doc', 'docx', 'rtf', 'txt', 'pdf', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'tiff', 'ico', 'mp4', 'ogg', 'webm'];

        // Check if the file is supported
        for ($i = 0; $i < count($randomFiles); $i++) {
            $valid = false;
            foreach ($types as $type) {
                if (pathinfo($randomFiles[$i][1]['path'])['extension'] == $type) {
                    $valid = true;
                }
            }
            if (!$valid) {
                unset($randomFiles[$i]);
            }
        }

        // Return the random files
        return $randomFiles;
    }

    /**
     * Calls the Dropbox's getDelta method (aka API call)
     *
     * @param $client
     * @param null $cursor
     * @return null
     */
    private function getDelta($client, $cursor = null)
    {
        $delta = $client->getDelta($cursor);

        $this->deltaFiles[] = $delta;

        return $cursor;
    }

} 