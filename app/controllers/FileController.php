<?php
/**
 * Created by PhpStorm.
 * User: Hartger
 * Date: 17/11/2014
 * Time: 09:31
 */

class FileController extends \BaseController {

    public function __construct() {
        $this->dataModel = new Data();
    }


    public function showFile($data_id) {
        dd($data_id);
        $data = $this->dataModel->find($data_id);
        switch($data->category) {
            case 'picture':
                dd($data);
                return View::make('data.picture')->with('data', $data);
                break;
            case 'movie':
                return View::make('data.movie')->with('data', $data);
                break;
            case 'doc':
                $this->handleDoc($data);
                break;
            default:
                return 'Incompatible filetype.';
        }
    }

    public function handleDoc($data) {
        $DocumentPath=$data->path;
        $word = new COM("word.application") or die("Unable to instantiate application object");
        $wordDocument = new COM("word.document") or die("Unable to instantiate document object");
        $word->Visible = 0;
        $wordDocument = $word->Documents->Open($DocumentPath);
        $HTMLPath = substr_replace($DocumentPath, 'html', -3, 3);
        $wordDocument->SaveAs($HTMLPath, 3);
        $wordDocument = null;
        $word->Quit();
        $word = null;
        //Convert HTML file at HTMLPath to string from 0th character with a charlimit of $charlimit
        $charlimit = 400;
        $text = file_get_contents($HTMLPath, NULL, NULL, 0, $charlimit);
//        unlink($HTMLPath);
        return View::make('data.doc')
            ->with('data', $data)
            ->with('text', $text);
    }

} 