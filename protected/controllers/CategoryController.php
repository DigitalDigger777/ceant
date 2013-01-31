<?php
class CategoryController extends Controller
{
    public function actionUpdateCountPages()
    {
        //get category id
        $category = Category::model()->findByAttributes(array('src'=>$_REQUEST['category'], 'parent_src'=>$_REQUEST['parent']));
        $category->count_pages  = $_REQUEST['count_pages'];
        $category->save();
        Yii::app()->end();
    }
    
    public function actionList()
    {
        $categories = Category::model()->findAll("public=:public", array(":public"=>1));
        print(CJSON::encode($categories));
        Yii::app()->end();
    }
}
?>
