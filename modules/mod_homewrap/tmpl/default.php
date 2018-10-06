<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="row homemodule">
    <div class="col-lg-4 col-md-4 col-sm-12" style="padding: 0 11px 0 0;">
    	<a href="<?php echo JURI::base(); ?>product"  class="item">
        <div class="title middlecenter">New Arrival</div>
    <?php for ($i = 0, $n = count($new); $i < $n; $i ++) : ?>
        <?php modHomeWrapHelper::renderItem($new[$i], $params, $access); ?>
    <?php endfor; ?>
    	</a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12" style="padding: 0;" >
    	<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-6" style="padding: 0 22px 16px;">
             <a href="<?php echo JURI::base(); ?>product" class="item">
            <div class="title middlecenter">Stuff Pick</div>
			<?php for ($i = 0, $n = count($pick); $i < $n; $i ++) : ?>
                <?php modHomeWrapHelper::renderItem($pick[$i], $params, $access); ?>
            <?php endfor; ?>
            </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-6" style="padding: 0 22px 16px;">
            <a href="<?php echo JURI::base(); ?>product"  class="item">
            <div class="title middlecenter">Popular Item</div>
            <?php for ($i = 0, $n = count($popular); $i < $n; $i ++) : ?>
                <?php modHomeWrapHelper::renderItem($popular[$i], $params, $access); ?>
            <?php endfor; ?>
            </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12" style="padding: 0 0 0 11px;">
    	<a href="<?php echo JURI::base(); ?>product"  class="item">
        <div class="title middlecenter">Best Selling</div>
    <?php for ($i = 0, $n = count($seller); $i < $n; $i ++) : ?>
        <?php modHomeWrapHelper::renderItem($seller[$i], $params, $access); ?>
    <?php endfor; ?>
    	</a>
    </div>
</div>
