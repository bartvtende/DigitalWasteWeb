<?php
/**
 * Created by PhpStorm.
 * User: Hartger
 * Date: 17/11/2014
 * Time: 09:31
 */

class FileController extends \BaseController {

    protected $dataModel;
    protected $charlimit;

    public function __construct() {
        $this->dataModel = new Data();
        $this->charlimit = 3400;
    }


    public function showFile($data_id) {
        $data = $this->dataModel->find($data_id);
        switch($data->category) {
            case 'picture':
                return View::make('data.picture')->with('data', $data);
            case 'movie':
                return View::make('data.movie')->with('data', $data);
                break;
            case 'doc':
                $text = $this->handleDoc($data);
                return View::make('data.text')
                    ->with('data', $data)
                    ->with('text', $text);
            case 'txt':
                $text = $this->handleTxt($data);
                return View::make('data.text')
                    ->with('data', $data)
                    ->with('text', $text);
            case 'mp3':
                return View::make('data.mp3')->with('data', $data);
                break;
            case 'wave':
                return View::make('data.wave')->with('data', $data);
                break;
            case 'movie':
                return View::make('data.movie')->with('data', $data);
                break;
            default:
                return 'Incompatible filetype.';
        }
    }

    // Extracts plain text from .doc document and places it in string.
    public function handleDoc($data) {
        $DocumentPath=URL::asset($data->path);
//        $this->parseWord($DocumentPath);
//        dd($DocumentPath);
        $word = new COM("word.application") or die("Unable to instantiate application object");
        $wordDocument = new COM("word.document") or die("Unable to instantiate document object");
        $word->Visible = 0;
        $wordDocument = $word->Documents->Open($DocumentPath);
        dd($DocumentPath);
        $HTMLPath = substr_replace($DocumentPath, 'html', -3, 3);
        dd($HTMLPath);
        $wordDocument->SaveAs($HTMLPath, 3);
        $wordDocument = null;
        $word->Quit();
        $word = null;
        //Convert HTML file at HTMLPath to string from 0th character with a charlimit of $charlimit
        $text = file_get_contents($HTMLPath, NULL, NULL, 0, $this->charlimit);
//        unlink($HTMLPath);
        return $text;

    }

//    function parseWord($userDoc)
//    {
//        $fileHandle = fopen($userDoc, "r");
//        $line = @fread($fileHandle, filesize($userDoc));
//        $lines = explode(chr(0x0D),$line);
//        $outtext = "";
//        foreach($lines as $thisline)
//        {
//            $pos = strpos($thisline, chr(0x00));
//            if (($pos !== FALSE)||(strlen($thisline)==0))
//            {
//            } else {
//                $outtext .= $thisline." ";
//            }
//        }
//        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
//        return $outtext;
//    }

    // Saves plain text .txt file in a string (up to $charlimit chars).
    public function handleTxt($data) {
        $text = file_get_contents(URL::asset($data->path), NULL, NULL, 0, $this->charlimit);
        return $text;
    }

} 