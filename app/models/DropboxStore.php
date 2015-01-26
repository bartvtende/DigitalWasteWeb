<?php

/**
 * Class DropboxStore
 *
 * Stores and gets all the relevant file and user information
 */
class DropboxStore
{

    /**
     * Stores the username to the database
     *
     * @param $username
     * @return User
     */
    public function storeUser($username)
    {
        // Make a new User
        $user = new DropboxUser();
        // Fill the username of this user
        $user->username = $username;
        // Save this user to the DB
        $user->save();
        // Save the user_id into the session
        Session::put('user_id', $user->id);
        // Return the user
        return $user;
    }

    /**
     * Stores the file information to the databases
     *
     * @param $randomFiles
     * @param $user
     * @return mixed
     */
    public function storeFiles($randomFiles, $user)
    {
        // Loop through all the files
        foreach ($randomFiles as $file) {
            // Get the metadata of the file
            $file = $file[1];

            // Get the additional path info
            $pathInfo = $this->getFileInfo($file);

            // Get the category of this file (either document, image or video)
            $category = $this->getCategory($pathInfo['extension']);

            $dropboxFile = new DropboxFile();

            $dropboxFile->user_id = $user->id;
            $dropboxFile->path = $file['path'];
            $dropboxFile->filename = $pathInfo['filename'];
            $dropboxFile->extension = $pathInfo['extension'];
            $dropboxFile->folder = $pathInfo['folder'];
            $dropboxFile->bytes = $file['bytes'];
            $dropboxFile->size = $file['size'];
            $dropboxFile->mime_type = $file['mime_type'];
            $dropboxFile->category = $category;
            $dropboxFile->created = $file['client_mtime'];
            $dropboxFile->updated = $file['modified'];

            $dropboxFile->save();
        }

        return $randomFiles;
    }

    /**
     * Get additional file information, such as the extension, filename and directory name
     *
     * @param $file
     * @return mixed
     */
    private function getFileInfo($file)
    {
        $pathInfo = pathinfo($file['path']);

        $info['extension'] = strtolower($pathInfo['extension']);
        $info['filename'] = $pathInfo['filename'];
        $info['folder'] = $pathInfo['dirname'];

        return $info;
    }

    /**
     * Returns the category that the file is in (either document, image or video)
     *
     * @param $extension
     * @return string
     */
    private function getCategory($extension)
    {
        $types = [
            'document' => ['doc', 'docx', 'rtf', 'txt', 'pdf', 'ppt', 'pptx', 'odt', 'odp'],
            'image' => ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'tiff', 'ico'],
            'video' => ['mp4', 'ogg', 'webm']
        ];

        $category = '';

        // Check if the file extensions match one of the types
        foreach ($types as $key => $type) {
            for ($i = 0; $i < count($type); $i++) {
                if ($extension == $type[$i]) {
                    $category = $key;
                }
            }
        }

        return $category;
    }
} 