<?php

/**
 * Class DropboxOverview
 *
 * Calculates the users results and the average results and stores it
 */
class DropboxOverview
{
    /**
     * Returns the average results
     *
     * @return mixed
     */
    public function overview()
    {
        // Find the average results
        $results = DropboxResult::find(0)->toArray();

        // Find the amount of participants (records in the DB)
        $amountOfParticipants = DropboxResult::count();

        $results['amountOfParticipants'] = $amountOfParticipants-1;

        if ($results['amountOfParticipants'] == 0) {
            $results = null;
        }

        return $results;
    }

    /**
     * Returns the average results and the users results, also calculates and stores those results
     *
     * @param $id
     * @return array
     */
    public function overviewUser($id)
    {
        // Try to get the results of the user
        $resultsUser = DropboxResult::where('user_id', $id)->first();

        // Find the average results
        $results = DropboxResult::find(0);

        // Otherwise calculate and store the results, plus delete all of the saved files
        if (!$resultsUser) {
            // Calculate the results and store them in the database
            $this->storeResults($id);

            // Deletes all the files and removes all entries from the database
            $this->deleteFiles($id);
        }

        // Try to get the results of the user again
        $resultsUser = DropboxResult::where('user_id', $id)->first();

        // Find the amount of participants (records in DB)
        $amountOfParticipants = DropboxResult::count();

        $results['amountOfParticipants'] = $amountOfParticipants;

        return [$resultsUser, $results];
    }

    /**
     * Calls the calculate methods and stores the results in the DB
     *
     * @param $id
     */
    private function storeResults($id)
    {
        // Get the average results
        $averageResults = DropboxResult::find(0);
        // Get the amount of participants (including this result)
        $amountOfParticipants = DropboxResult::count();

        // Get all the users files
        $files = DropboxFile::where('user_id', $id)->get();

        // Initialize the variables
        $result = [];
        $newAverages = [];

        // Get the two verdelingen variables (both the average and for the user)
        $verdelingen = $this->calculateVerdelingen($files, $averageResults, $amountOfParticipants);

        // Set the verdelingen
        $newAverages['verd_extensies'] = $verdelingen['gem_verd_extensies'];
        $newAverages['verd_rating'] = $verdelingen['gem_verd_rating'];
        $result['verd_extensies'] = $verdelingen['verd_extensies'];
        $result['verd_rating'] = $verdelingen['verd_rating'];

        // Set the first uploaded file
        $eerst_geupload = $this->calculateEerstGeupload($files, $averageResults);
        $newAverages['eerst_geupload'] = $eerst_geupload[0];
        $result['eerst_geupload'] = $eerst_geupload[1];

        $averages = $this->calculateAverages($files, $averageResults, $amountOfParticipants);

        $newAverages['gem_bestandsgrootte'] = $averages[0];
        $newAverages['gem_rating'] = $averages[1];
        $result['gem_bestandsgrootte'] = $averages[2];
        $result['gem_rating'] = $averages[3];

        // Save the results
        $newResult = new DropboxResult();

        $newResult->user_id = $id;
        $newResult->verd_extensies = $result['verd_extensies'];
        $newResult->gem_bestandsgrootte = $result['gem_bestandsgrootte'];
        $newResult->eerst_geupload = $result['eerst_geupload'];
        $newResult->gem_rating = $result['gem_rating'];
        $newResult->verd_rating = $result['verd_rating'];

        $newResult->save();

        // Store the updated average results
        $this->updateAverageResults($averageResults, $newAverages);
    }

    /**
     * Delete the users files recursively
     *
     * @param $id
     */
    private function deleteFiles($id)
    {
        // Recurse over the directory to delete the files
        $dir = public_path() . '/tmp/' . $id;
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);

        // Delete all the database entries from this user
        DropboxFile::where('user_id', $id)->delete();
    }

    /**
     * Stores the updated average results into the database
     *
     * @param $averageResults
     * @param $newAverages
     */
    private function updateAverageResults($averageResults, $newAverages)
    {
        $averageResults->verd_extensies = $newAverages['verd_extensies'];
        $averageResults->gem_bestandsgrootte = $newAverages['gem_bestandsgrootte'];
        $averageResults->eerst_geupload = $newAverages['eerst_geupload'];
        $averageResults->gem_rating = $newAverages['gem_rating'];
        $averageResults->verd_rating = $newAverages['verd_rating'];

        // Save the new average results
        $averageResults->save();
    }

    /**
     * Calculates the rating and extensies verdelingen
     *
     * @param $files
     * @param $averageResults
     * @param $amountOfParticipants
     * @return array
     */
    private function calculateVerdelingen($files, $averageResults, $amountOfParticipants)
    {
        // Parses the JSON string into an array
        $gem_verd_extensies = json_decode($averageResults->verd_extensies);
        $gem_verd_rating = json_decode($averageResults->verd_rating);

        $categories = ['document', 'image', 'video'];

        foreach ($categories as $category) {
            $verd_extensies[$category] = 0;
            $verd_rating[$category] = 0;
            $amountOfCategories[$category] = 0;
        }

        // Calculate the averages
        foreach ($files as $file) {
            if (!is_null($file['category']) && $file['category'] != '') {
                $verd_extensies[$file['category']]++;
                $verd_rating[$file['category']] += (int)$file['rating'];
                $amountOfCategories[$file['category']]++;
            }
        }

        $oldAmountOfParticipants = $amountOfParticipants - 1;


        // Store the new averages
        foreach ($gem_verd_extensies as $key => $value) {
            $gem_verd_extensies->$key = (($value * $oldAmountOfParticipants) + $verd_extensies[$key]) / $amountOfParticipants;
        }

        foreach ($gem_verd_rating as $key => $value) {
            if ($amountOfCategories[$key] != 0) {
                // Get the average
                $verd_rating[$key] /= $amountOfCategories[$key];

                $gem_verd_rating->$key = (($value * $oldAmountOfParticipants) + $verd_rating[$key]) / $amountOfParticipants;
            } else {
                $gem_verd_rating->$key = (($value * $oldAmountOfParticipants) + 0) / $amountOfParticipants;
            }
        }

        // Return the values in an array as a json string
        return [
            'gem_verd_extensies' => json_encode($gem_verd_extensies),
            'gem_verd_rating' => json_encode($gem_verd_rating),
            'verd_extensies' => json_encode($verd_extensies),
            'verd_rating' => json_encode($verd_rating)
        ];
    }

    /**
     * Calculates the eerst geuploadde file
     *
     * @param $files
     * @param $averageResults
     * @return array
     */
    private function calculateEerstGeupload($files, $averageResults)
    {
        $lowestDate = new DateTime();

        if ($averageResults['eerst_geupload']) {
            $averageDate = new DateTime($averageResults['eerst_geupload']);
        } else {
            $averageDate = new DateTime();
        }

        foreach ($files as $file) {
            if ($file['created']) {
                $date = new DateTime($file['created']);

                if ($date < $lowestDate) {
                    $lowestDate = new DateTime($file['created']);
                }
            }
        }

        // Check if the current date is lower then the one from the averageResults array
        if ($lowestDate <= $averageDate) {
            $averageResults['eerst_geupload'] = $lowestDate;
        }

        return [$averageResults['eerst_geupload'], $lowestDate];
    }

    /**
     * Calculates the average bestandsgrootte and rating
     *
     * @param $files
     * @param $averageResults
     * @param $amountOfParticipants
     * @return array
     */
    private function calculateAverages($files, $averageResults, $amountOfParticipants)
    {
        $amountOfRatings = 0;
        $gem_bestandsgrootte = 0;
        $gem_rating = 0;

        // Loop through all files to calculate the values
        foreach ($files as $file) {
            $gem_bestandsgrootte += $file['bytes'];
            $gem_rating += $file['rating'];
            $amountOfRatings += 1;
        }

        $gem_bestandsgrootte /= $files->count();
        $gem_rating /= $amountOfRatings;

        $oldAmountOfParticipants = $amountOfParticipants - 1;

        $avg_gem_bestandsgrootte = (($averageResults['gem_bestandsgrootte'] * $oldAmountOfParticipants) + ($gem_bestandsgrootte)) / $amountOfParticipants;
        $avg_gem_rating = (($averageResults['gem_rating'] * $oldAmountOfParticipants) + ($gem_rating)) / $amountOfParticipants;

        return [$avg_gem_bestandsgrootte, $avg_gem_rating, $gem_bestandsgrootte, $gem_rating];
    }

}