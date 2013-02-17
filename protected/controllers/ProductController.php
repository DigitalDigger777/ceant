<?php
class ProductController extends Controller
{
    public $layout = '//layouts/leftmenu';
    public $categories;

    public function __construct($id, $module = null) {
        $category = new Category();
        $this->categories = $category->findAll('public=:public AND parent_id=:parent_id', array(':public'=>1, 'parent_id'=>1));        
        parent::__construct($id, $module);
    }
    
    public function actionIndex()
    {
        $products = Product::model()->findAll('1 order by rand() limit 6');
        $this->render('index', array('products'=>$products));
    }
    
    public function actionAuction()
    {
        //$criteria = new CDbCriteria();
        //$criteria->limit = 20;
        //$criteria->offset = isset($_REQUEST['page'])?($_REQUEST['page']-1)*20:0;
        //$criteria->condition = 'category_id=:category_id';
        //$criteria->params = array(':category_id'=>$_REQUEST['category_id']);
        //$products = Product::model()->findAll($criteria);
        $products = Auction::getAuctions($_REQUEST['category_id']);
        $category = Category::model()->find('category_id=:category_id', array(':category_id'=>$_REQUEST['category_id']));
        
        $products_count = Auction::model()->count();
        $pages_count = ceil($products_count/20);
        $this->render('auction', array('products'=>$products,
                                       'pages_count'=>$pages_count,
                                       'category'=>$category));
    }
    
    public function actionSelling()
    {
        $products = Selling::getAuctions($_REQUEST['category_id']);
        $category = Category::model()->find('category_id=:category_id', array(':category_id'=>$_REQUEST['category_id']));
        
        $products_count = Auction::model()->count();
        $pages_count = ceil($products_count/20);
        $this->render('selling', array('products'=>$products,
                                        'pages_count'=>$pages_count,
                                        'category'=>$category));
    }
    
    public function actionItem()
    {
        $features = Yii::app()->getDb()->createCommand('SELECT T2.name, T3.name `value`
                                                        FROM `feature` T1
                                                        JOIN `feature_name` T2 ON T1.feature_name_id = T2.feature_name_id
                                                        JOIN `feature_value` T3 ON T1.feature_value_id = T3.feature_value_id
                                                        JOIN `product` T4 ON T1.product_id = T4.product_id
                                                        WHERE T4.product_id = '.$_REQUEST['product_id'])->queryAll();
        $product = Product::model()->find('product_id=:product_id', array('product_id'=>$_REQUEST['product_id']));
        $category = Category::model()->find('category_id=:category_id', array(':category_id'=>$product->category_id));
        $this->render('item', array('features'=>$features, 'product'=>$product, 'category'=>$category));
    }
    
    public function actionItems()
    {
        $criteria = new CDbCriteria();
        $criteria->limit = 20;
        $criteria->offset = isset($_REQUEST['page'])?($_REQUEST['page']-1)*20:0;
        $criteria->condition = 'category_id=:category_id';
        $criteria->params = array(':category_id'=>$_REQUEST['category_id']);
        $products = Product::model()->findAll($criteria);
        
        $products_count = Product::model()->count('category_id=:category_id', array(':category_id'=>$_REQUEST['category_id']));
        $pages_count = ceil($products_count/20);
        $category = Category::model()->find('category_id=:category_id', array(':category_id'=>$_REQUEST['category_id']));
        
        $this->render('items', array('products'=>$products,
                                     'pages_count'=>$pages_count,
                                     'category'=>$category));
    }
    
    public function actionUpdateOriginImage()
    {
        Yii::app()->db->createCommand("UPDATE product SET origin_image = concat('http://hotline.ua/img/tx/',substr(replace(thumb_image, 'http://hotline.ua/img/tx/',''), 1, position('/' in replace(thumb_image, 'http://hotline.ua/img/tx/',''))),replace(substr(replace(thumb_image, 'http://hotline.ua/img/tx/',''), position('/' in replace(thumb_image, 'http://hotline.ua/img/tx/',''))+1),'.jpg','')+1, '.jpg') WHERE origin_image=''")->query();
        Yii::app()->end();
    }
    
    public function actionUpdateNameImage()
    {
        Yii::app()->db->createCommand("UPDATE product SET name_image=substr(replace(thumb_image,'http://hotline.ua/img/tx/',''), position('/' in replace(thumb_image,'http://hotline.ua/img/tx/',''))+1) WHERE name_image=''")->query();
        Yii::app()->end();
    }


    public function actionFeature()
    {
        $this->render('feature');
    }
    
    public function actionProductInfo()
    {
        $product = Product::model()->find('product_id=:product_id', array('product_id'=>$_REQUEST['product_id']));
        print(CJSON::encode($product));
        Yii::app()->end();
    }
}
?>
