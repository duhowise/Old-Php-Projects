<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/30/17
 * Time: 10:11 PM
 */

namespace Chatter\Middleware;


class ImageRemoveExif
{
    public function __invoke($request,$response,$next)
    {
        $files=$request->getUplloadedFiles();
        $newfile=$files['file'];
        $uploadedFileName=$newfile->getClientFileName();
        $newfile_type=$newfile->getClientMediaType();
        $newfile->moveTo("assets/images/raw/".$uploadedFileName);
        $pngfile->moveTo("assets/images/".substr($uploadedFileName,0,-4)."png");

        if ('image/jpeg'==$newfile_type){
            $_img=imagecreatefromjpeg("assets/images/raw/".$uploadedFileName);
            imagepng($_img,$pngfile);
        }
        $response=$next($request,$response);

        return $response;
    }
}