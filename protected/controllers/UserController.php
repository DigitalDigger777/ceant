<?php
Yii::import('application.vendors.*');
require_once 'facebook/facebook.php';
class UserController extends Controller
{
    public function actionNewAuction()
    {
        $fb = new Facebook(array(
            'appId'=>Yii::app()->params['appId'],
            'secret'=>Yii::app()->params['secret']
        ));
        
        $user_id = $fb->getUser();
        if($user_id)
        {
            $auction = Auction::model()->count('product_id=:product_id AND user_id=:user_id',array(':product_id'=>$_REQUEST['product_id'], ':user_id'=>$user_id));
            if(!$auction)
            {
                $auction = new Auction();
                $auction->user_id    = $user_id;
                $auction->product_id = $_REQUEST['product_id'];
                $auction->price      = $_REQUEST['price'];
                $auction->save();
            }
        }
        Yii::app()->end();
    }
}
?>
