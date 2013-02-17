<?php

class Auction extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'auctions';
    }
    
    public static function getAuctions($category_id, $limit = 20, $user_id = 0)
    {
        return Yii::app()->getDb()->createCommand('SELECT T2.*
                                                    FROM `auctions` T1
                                                    JOIN `product` T2 ON T1.product_id = T2.product_id
                                                    WHERE category_id = '.$category_id)->query();
    }
}
?>
