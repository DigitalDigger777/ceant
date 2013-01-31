<?php
class Category extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'category';
    }
    
    public function relations() {
        return array(
            'product'=>array(self::HAS_MANY, 'Product', 'category_id')
        );
    }
}
?>
