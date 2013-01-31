<?php
class Image extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'image';
    }
    
    public function relations() {
        return array(
            'product'=>array(self::BELONGS_TO, 'Product', 'product_id')
        );
    }
}
?>
