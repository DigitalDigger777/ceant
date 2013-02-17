<?php
    $this->pageTitle = 'Ceant | Главная';
?>
<div class="row-fluid">
    <!--
    <div class="span1"></div>
    <div class="span10">
        <div id="slider" class="carousel slide">
            <div class="carousel-inner">
                <div class="active item">
                    <img src="images/slide/1.png" alt="" />
                    <div class="carousel-caption">
                        <h4>Caption</h4>
                        <p>desc</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/slide/2.png" alt="" />
                    <div class="carousel-caption">
                        <h4>Caption</h4>
                        <p>desc</p>
                    </div>            
                </div>
            </div>
            <a class="carousel-control left" href="#slider" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#slider" data-slide="next">&rsaquo;</a>
        </div>
    </div>
    <div class="span1"></div>
    -->
</div>
<div class="row-fluid">
    <?php $p = 0; ?>
    <?php for($i = 0; $i < 3; $i++):?>
    <div class="row-fluid">
        <?php for($m = 0; $m < 2; $m++):?>
        <div class="span6 well well-small" style="height: 200px">
            <img src="<?php echo empty($products[$p]->name_image)||$products[$p]->name_image=='0000004.jpg'?'images/noimg.jpg':'images/thumb/'.$products[$p]->name_image; ?>" alt="<?php echo $products[$p]->name; ?>" class="img-rounded"/>
            <h6><a href="index.php?r=product/item&product_id=<?php echo $products[$p]->product_id; ?>"><?php echo $products[$p]->name; ?></a></h6>
            <?php echo $products[$p]->intro_desc; ?>
            <?php $p++; ?>
        </div>
        <?php endfor;?>
    </div>
    <?php endfor; ?>
</div>
<script type="text/javascript">
    (function($){
        $('document').ready(function(){
            $('.carousel').carousel();
        });
    })(jQuery)
</script>