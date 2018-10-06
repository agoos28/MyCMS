<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );
print_r($this);
?>

<?php

?>
<div class="col-ms-12">
<div class="panel panel-white">
<div class="panel-heading border-light">
    <h4 class="panel-title"><?php echo $this->page_title; ?></h4>
    <ul class="panel-heading-tabs border-light">
        <li class="panel-tools">
            <div class="dropdown">
                <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                    <li>
                        <a class="panel-refresh" href="#">
                            <i class="fa fa-refresh"></i> <span>Refresh</span>
                        </a>
                    </li>
                    <li>
                        <a class="panel-config" href="#panel-config" data-toggle="modal">
                            <i class="fa fa-wrench"></i> <span>Configurations</span>
                        </a>
                    </li>
                    <li>
                        <a class="panel-expand" href="#">
                            <i class="fa fa-expand"></i> <span>Fullscreen</span>
                        </a>
                    /li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="panel-body">
<form>
<div class="form-group">
<label for="title">Section Title</label>
<input placeholder="" class="form-control" id="title" name="title" value="" maxlength="50" size="32" type="text" placeholder="" value="<?php echo $this->title; ?>">
</div>
<div class="form-group">
<label for="description">Section Description</label>
<textarea name="description" class="form-control" id="description"><?php echo $this->description; ?></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary">Save</button>
</div>
<?php echo $this->formHidden; ?>
<input type="hidden" name="section_group" value="<?php echo $this->menu_params->get('secgroup'); ?>" />
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
<input type="hidden" name="id" value="<?php echo $this->cckId; ?>" />
<input type="hidden" name="itemid" value="<?php echo $this->itemId; ?>" />
<input type="hidden" name="typeid" value="<?php echo $this->typeid; ?>" />
<input type="hidden" name="templateid" value="<?php echo $this->templateid; ?>" />
<input type="hidden" name="formname" value="<?php echo $formName; ?>" />
<input type="hidden" name="actionmode" value="<?php echo $this->actionMode; ?>" />
<input type="hidden" name="captcha_enable" value="<?php echo $this->captchaEnable; ?>" />
<?php echo JHTML::_('form.token'); ?>
</form>
</div>
</div>
</div>
</div>