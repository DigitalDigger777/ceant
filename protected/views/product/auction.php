<?php
    $this->pageTitle = 'Ceant | '.Yii::t('main', 'Аукцион').' | '.Yii::t('main', $category->a_name);
?>
<div class="row-fluid">
    <h5><?php echo Yii::t('main', $category->name); ?></h5>
</div>
<?php foreach($products as $product):?>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span12 well well-small">
                <div class="row-fluid">
                    <div class="span2">
                        <?php
                            preg_match('/^http:\/\/hotline[.]ua\/img\/tx\/[0-9]*?\/([0-9]*?[.]jpg)$/', $product['origin_image'], $match);
                        ?>
                        <a class="thumb" href="<?php echo isset($match[1])&&$product['name_image']!='0000004.jpg'?'images/resize/'.$match[1]:'images/noimg-big.jpg';?>">
                            <img src="<?php echo empty($product['name_image'])||$product['name_image']=='0000004.jpg'?'images/noimg.jpg':'images/thumb_bw/'.$product['name_image']; ?>" alt="<?php echo $product['name']; ?>" class="img-rounded"/>
                        </a>
                    </div>
                    <div class="span10">
                        <h6><a href="index.php?r=product/item&product_id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a></h6>
                        <?php echo $product['intro_desc']; ?>
                        <div class="row-fluid">
                            <div class="span10">
                                <p class="muted"><?php echo Yii::t('main','Средняя цена');?>: <?php echo $product['current_price']; ?></p>
                            </div>
                            <div class="span2">
                                <div class="btn-group">
                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                        <?php echo Yii::t('main','Действие'); ?>
                                        <span class="caret"></span>
                                    </a>
                                    <!--<ul class="dropdown-menu">
                                        <li><a href="#newAuction" product_id="<?php echo $product['product_id']; ?>" data-toggle="modal">Создать аукцион</a></li>
                                        <li><a href="#">Добавить в избранное</a></li>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if($pages_count>1):?>
<div class="pagination pagination-mini">
    <ul>
        <?php $page = isset($_REQUEST['page'])?$_REQUEST['page']:1; ?>
        <?php $start_page = $page>3?$page-1:1; ?>
        <?php $start_page = ($pages_count - $page)<8?($pages_count - 8):$start_page; ?>
        <?php $start_page = $pages_count<=8?1:$start_page; ?>
        <li><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=1"><<</a></li>
        <li><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=<?php echo $page-1<1?1:$page-1; ?>"><</a></li>
        <?php for($i = $start_page; $i<=$pages_count; $i++):?>
                <li<?php echo $page == $i?' class="active"':''?>><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php if($i == ($start_page+8)&&$i!=$pages_count&&$pages_count>8):?>
                    <li><a href="#">...</a></li>
                    <li<?php echo $page == $i?' class="active"':''?>><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=<?php echo $pages_count; ?>"><?php echo $pages_count; ?></a></li>
                    <?php break;?>
                <?php endif; ?>
        <?php endfor;?>
        <li><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=<?php echo $page+1; ?>">></a></li>
        <li><a href="index.php?r=product/items&category_id=<?php echo $_REQUEST['category_id']?>&page=<?php echo $pages_count; ?>">>></a></li>
    </ul>
</div>
<?php endif; ?>