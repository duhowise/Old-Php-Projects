<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/30/17
 * Time: 10:10 PM
 */

namespace Chatter\Middleware;


class FileFilter
{
    protected $allowed_files=['image/jpeg','image/png'];
    public function __invoke($request,$response,$next)
    {
        $files=$request->getUploadedFiles();
        $newfile=$files['file'];
        $newfile_type=$newfile->getClientMediaType();
        if (!in_array($newfile_type,$this->allowed_files)){
            return $response->withStatus(415);
        }
        $response=$next($request,$response);

        return $response;
    }
}