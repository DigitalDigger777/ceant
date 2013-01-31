<?php
class ParserController extends Controller
{
    public function actionIndex()
    {        
        $this->render('parser');
    }
    
    public function actionSave()
    {
        $product = new Product();
        if(!Product::model()->find('name=:name', array('name'=>$_REQUEST['name'])))
        {
            $product->category_id   = $_REQUEST['category_id'];
            $product->name          = $_REQUEST['name'];
            $product->intro_desc    = $_REQUEST['intro_desc'];
            $product->desc          = $_REQUEST['desc'];
            $product->current_price = $_REQUEST['current_price'];
            $product->images        = $_REQUEST['images'];
            $product->main_image    = $_REQUEST['main_image'];
            $product->thumb_image   = $_REQUEST['thumb_image'];
            $product->path          = $_REQUEST['path'];
            $product->save();
        }
        Yii::app()->end();
    }
    
    public function actionSaveItem()
    {
        if(isset($_REQUEST['feature_value'])&&isset($_REQUEST['feature_name']))
        {
            $feature_name = new FeatureName();

            if(!FeatureName::model()->find('name=:name', array('name'=>$_REQUEST['feature_name'])))
            {
                try
                {
                    $feature_name->name = $_REQUEST['feature_name'];
                    $feature_name->save();
                }
                catch (CDbException $e)
                {
                    print($e->getMessage());
                }
            }

            $feature_value = new FeatureValue();
            
            if(!FeatureValue::model()->find('name=:name', array('name'=>$_REQUEST['feature_value'])))
            {
                try
                {
                    $feature_value->name = $_REQUEST['feature_value'];
                    $feature_value->save();
                }
                catch (CDbException $e)
                {
                    print($e->getMessage());
                }
            }

            $fv = FeatureValue::model()->find('name=:name', array('name'=>$_REQUEST['feature_value']));
            $fn = FeatureName::model()->find('name=:name', array('name'=>$_REQUEST['feature_name']));
            $product = Product::model()->find('path=:path', array('path'=>$_REQUEST['path']));
            
            if($fv&&$fn&&$product)
            {
                $features = Yii::app()->getDb()->createCommand('SELECT * FROM feature 
                                                                WHERE `feature_name_id`='.$fn->feature_name_id.' AND
                                                                      `feature_value_id`='.$fv->feature_value_id.' AND 
                                                                      `product_id`='.$product->product_id)->queryAll();
                if(count($features) == 0)
                {
                    $query = 'INSERT INTO feature(`feature_name_id`, `feature_value_id`, `product_id`)
                                           VALUES('.$fn->feature_name_id.', '.$fv->feature_value_id.', '.$product->product_id.')';
                    Yii::app()->getDb()->createCommand($query)->query();
                }
            }
        }
        Yii::app()->end();
    }

    public  function actionLog()
    {
        $h = fopen('log.txt', 'a+');
        fwrite($h, json_encode($_REQUEST['data'])."\r\n");
        fclose($h);
        Yii::app()->end();
    }
}
?>
