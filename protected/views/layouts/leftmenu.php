<?php $this->beginContent('//layouts/main');?>
<div class="span3">
    <ul class="nav nav-list well well-small">
        <?php foreach ($this->categories as $category):?>
            <li<?php echo isset($_REQUEST['category_id'])?$_REQUEST['category_id']==$category->category_id?' class="active"':'':''; ?>><a href="index.php?r=product/items&category_id=<?php echo $category->category_id; ?>"><i class="icon-th-large"></i>&nbsp;<?php echo $category->name; ?></a></li>
        <?php endforeach;?>
    </ul>
</div>
<div class="span9 well well-small">
    <?php echo $content;?>
</div>
<?php $this->endContent();?>
