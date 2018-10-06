<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (dirname (dirname ( __FILE__ )) . "/helper.php");

?>
	<form class="form-horizontal" method="post" id="pop_newsletter" action="<?php echo JURI::current(); ?>">
    		<div class="info alert alert-block fade in text-center hide"></div>
       	<div class="form-group">
            <label for="nw_name" class="col-sm-4 control-label text-left">Your Full Name</label>
            <div class="col-sm-8">
            <input type="text" class="form-control" id="nw_name" name="name">
            </div>
        </div>
        <div class="form-group">
            <label for="nw_email" class="col-sm-4 control-label text-left">Your Email Address</label>
            <div class="col-sm-8">
            <input type="email" class="form-control" id="nw_email" name="email">
            </div>
        </div>
        <div class="form-group">
        <div class="col-sm-4"></div>
        <div class="col-sm-8">
        <button type="button" class="btn" data-dismiss="modal">Close</button> &nbsp;&nbsp;
        <button class="btn btn-red" type="submit">SUBMIT</button>
        </div>
        </div>
        <input type="hidden" name="newsletter" value="1" />
        <input type="hidden" name="promo_id" value="<?php echo $params->get('promo_id', 0); ?>" />
        <input id="ajax" type="hidden" name="ajax" value="1" />
        
    </form>