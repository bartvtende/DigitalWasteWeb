<?php

/**
 * Class DropboxItem
 *
 * Serves the file information to the user
 */
class DropboxItem
{

    /**
     * Find all the files from this user, store the files and store the write path
     *
     * @param $client
     * @return bool
     */
    public function findFiles($client)
    {
        // Get the user id from session
        $user_id = Session::get('user_id');

        if (!$user_id)
            return false;

        // Get the user from the DB
        $user = DropboxUser::find($user_id);

        // Get the file from the DB
        $files = DropboxFile::where('user_id', $user_id)->get();
        if (!$files || !$user)
            return false;

        // Check if the client is really a Dropbox client class, otherwise return false
        if (!($client instanceof Dropbox\Client))
            return false;

        // Make a directory for this user
        mkdir(public_path() . '/tmp/' . $user_id);

        foreach ($files as $file) {
            // Store the file
            $writePath = $this->storeFile($file, $client);

            // Store the file write path to the DB
            $this->storeFilePath($writePath, $file->id);
        }

        return $user_id;
    }

    /**
     * Find a single file for this user
     *
     * @param $id
     * @return bool|string
     */
    public function findFile($id)
    {
        // Check if session user_id is equal to given user id
        if (!(Session::get('user_id') == $id)) {
            return false;
        }

        // Get the next file for this user
        $file = DropboxFile::where('user_id', $id)->where('seen', 0)->where('category', '!=', '')->first();

        // If the files is empty, the user has seen all the items. Redirect them to the overview page
        if (is_null($file)) {
            return 'overview';
        }

        return $file;
    }

    /**
     * Store the file to a temporary directory for easy access
     *
     * @param $file
     * @return array
     */
    private function storeFile($file, $client)
    {
        // Path where the file gets written to (Laravel's public folder)
        $writePath = public_path() . '/tmp/' . $file->user_id . '/' . $file->filename . '.' . $file->extension;

        $realPath = 'tmp/' . $file->user_id . '/' . $file->filename . '.' . $file->extension;

        // Save the dropbox file to a temp folder
        $client->getFile($file->path, fopen($writePath, 'wb'));

        return $realPath;
    }

    /**
     * Store the write_path in the DB
     *
     * @param $writePath
     * @param $fileId
     */
    private function storeFilePath($writePath, $fileId)
    {
        // Get the file class
        $file = DropboxFile::find($fileId);

        // Save the write_path to the DB
        $file->write_path = $writePath;

        $file->save();
    }
}