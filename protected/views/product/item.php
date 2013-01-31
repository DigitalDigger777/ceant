<?php
    preg_match('/^http:\/\/hotline[.]ua\/img\/tx\/[0-9]*?\/([0-9]*?[.]jpg)$/', $product->origin_image, $match);
    $this->pageTitle = 'Ceant | '.$category->singular.' '.$product->name;
?>
<div class="row-fluid">
    <h5><?php echo $category->singular.' '.$product->name; ?></h5>
</div>
<div class="row-fluid">
    <div class="span8 well well-small"><img class="img-rounded" src="<?php echo isset($match[1])&&$product->name_image!='0000004.jpg'?'images/resize/'.$match[1]:'images/noimg-big.jpg'; ?>" alt="" /></div>
    <div class="span4 well well-small"></div>
</div>
<table class="table table-striped table-bordered table-condensed">
<?php foreach($features as $feature):?>
    <tr>
        <td><?php echo $feature['name']; ?></td>
        <td><?php echo $feature['value']; ?></td>
    </tr>
<?php endforeach; ?>
</table>