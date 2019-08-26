<?php
namespace app\controllers;
use Yii;
use yii\Web\Controller;
class BookReviewsController extends Controller
{
	
	public function actionIndex()
	{
        $data['name']="Duhp Software";
        $data['age']="over 21";
        $data['city']="Tema";
	    return $this->render('hello', $data);
	}
	
}


?>