<?php
class Product extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'product';
    }
    
    public function relations() {
        return array(
            'image'=>array(self::HAS_MANY, 'Image', 'product_id'),
            'feature_name'=>array(self::MANY_MANY, 'FeatureName', 'feature(product_id, feature_name_id)'),
            'feature_value'=>array(self::MANY_MANY, 'FeatureValue', 'feature(product_id, feature_value_id)')
        );
    }
}
?>
