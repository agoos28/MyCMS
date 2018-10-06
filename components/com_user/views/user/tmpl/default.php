<?php // @version $Id: default.php  $
defined('_JEXEC') or die('Restricted access');

?>

<div id="content">
  <div class="container">
    <div class="cart_c frm">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
          <div class="row">
            <div class="col-sm-8 col-xs-12">
              <div class="list-group">
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-xs-6">
                      <h5 class="pink"><?php echo JText::_( 'ACCOUNT_INFO' ); ?></h5>
                    </div>
                    <div class="col-xs-6 text-right"> <a class="edit_acc btn btn_default btn-xs" title="Edit account" href="<?php echo JURI::base(); ?>edit-account"><span class="fa fa-edit"></span> Edit</a> </div>
                  </div>
                </div>
                <div class="list-group-item">
                  <div class="dsk">
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Name' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><strong><?php echo $this->user->name;?></strong></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'User Type' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><?php echo $this->user->usertype;?></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Email' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><?php echo $this->user->email;?></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Recieve newsletter' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;">
                          <?php if($this->user->newsletter){ ?>
                          yes
                          <?php }else{ ?>
                          No
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Phone' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><?php echo $this->user->phone;?></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Default Shipping Address' ); ?></div>
                      </div>
                      <div class="col-sm-12" style="margin-bottom: 10px;">
                         <?php 
												 $address = json_decode($this->user->address); 
												 $address = $address->address;
												 ?>
                        <table class="table table-striped m-b-0">
                          <tbody>
                            <tr>
                              <td><strong>Receiver Name</strong></td>
                              <td><?php echo $address->name; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Receiver Phone</strong></td>
                              <td><?php echo $address->phone; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Country</strong></td>
                              <td><?php echo $address->country_name; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Province</strong></td>
                              <td><?php echo $address->province; ?></td>
                            </tr>
                            <tr>
                              <td><strong>District</strong></td>
                              <td><?php echo $address->district_name; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Postal Code</strong></td>
                              <td><?php echo $address->postal; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Address</strong></td>
                              <td><?php echo $address->address; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Optional Address</strong></td>
                              <td><?php echo $address->address_opt; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                  </div>
                  <form id="userform" action="<?php echo JURI::current(); ?>" method="post" name="userform" autocomplete="off" class="acc frm" style="display: none;">
                  	<div class="alert alert-danger hide">
                      <div class="notification"></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'Name' ); ?></div>
                        <input class="txtbox" type="text" value="<?php echo $this->user->name;?>" disabled="disabled" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'Email' ); ?></div>
                        <input class="txtbox" type="email" id="email" name="email" value="<?php echo $this->user->email;?>" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'Phone' ); ?></div>
                        <input class="txtbox" type="text" id="phone" name="phone" value="<?php echo $this->user->phone;?>" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'Default Shipping Address' ); ?></div>
                      </div>
                    </div>
                    <div class="row gutter-10">
                      <div class="col-sm-7">
                        <input id="reciever_name" name="address[name]" type="text" class="txtbox no-empty" placeholder="Receiver Name" value="<?php echo $address->name; ?>">
                      </div>
                      <div class="col-sm-5">
                        <input id="reciever_phone" name="address[phone]" type="text" class="txtbox no-empty" placeholder="Receiver Phone" value="<?php echo $address->phone; ?>">
                      </div>
                      <div class="col-sm-6">
                        <select id="country" name="address[country]" class="txtbox no-empty">
                          <?php if($address->country){ 
													if(!$address->country_name && $address->country == 999){
														$address->country_name = 'Indonesia';
													}
													?>
                          <option value="<?php echo $address->country; ?>" selected="selected"><?php echo $address->country_name; ?></option>
                          <?php }else{ ?>
                          <option value="999" selected="selected">Indonesia</option>
                          <?php } ?>
                        </select>
                        <input id="country_name" type="hidden" name="address[country_name]" value="<?php echo $address->country_name; ?>">
                      </div>
                      <div class="col-sm-6">
                        <select id="province" name="address[province]" class="txtbox no-empty">
                          <?php if($address->province){ ?>
                          <option value="<?php echo $address->province; ?>" selected="selected"><?php echo $address->province; ?></option>
                          <?php }else{ ?>
                          <option value="">Select Province/Kota</option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-8">
                        <select id="district" name="address[district]" class="txtbox no-empty">
                          <?php if($address->district){ ?>
                          <option value="<?php echo $address->district; ?>" selected="selected"><?php echo $address->district_name; ?></option>
                          <?php }else{ ?>
                          <option value="">Select District/Kecamatan</option>
                          <?php } ?>
                        </select>
                        <input id="district_name" type="hidden" name="address[district_name]" value="<?php echo $address->district_name; ?>">
                      </div>
                      <div class="col-sm-4">
                        <input id="postal" name="address[postal]" type="text" class="txtbox no-empty" placeholder="Postal code" value="<?php echo $address->postal; ?>">
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="txtbox no-empty" id="address1" name="address[address]" value="<?php echo $address->address; ?>" placeholder="Address">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="txtbox" id="address2" name="address[address_opt]" placeholder="Apt, suit, etc (optional)" value="<?php echo $address->address_opt; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12" style="margin-bottom: 10px;">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'Recieve Newsletter' ); ?></div>
                        <label class="checkbox-inline">
                          <input class="txtbox" type="checkbox" id="newsletter" name="newsletter" value="1" <?php if($this->user->newsletter){ echo 'checked="checked"'; }?> />
                          Yes </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 text-right">
                      	<button class="btn btn-default cancel" type="button"><?php echo JText::_( 'Cancel' ); ?></button>
                        <button class="btn btn-red" type="submit"><?php echo JText::_( 'Save' ); ?></button>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
                    <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
                    <input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
                    <input type="hidden" name="option" value="com_user" />
                    <input type="hidden" name="task" value="save" />
                    <input type="hidden" name="return" value="<?php echo base64_encode(JURI::current()) ?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-xs-12">
            	<div class="list-group">
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-xs-6">
                      <h5 class="pink"><?php echo JText::_( 'Activity' ); ?></h5>
                    </div>
                    <div class="col-xs-6 text-right"> </div>
                  </div>
                </div>
                <div class="list-group-item">
                  <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Registered' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><?php echo JHtml::_('date',$this->user->registerDate);?></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-5 col-md-4 col-sm-6" style="margin-bottom: 10px;">
                        <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Last Login' ); ?></div>
                      </div>
                      <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                        <div style="padding-top: 0;"><?php echo JHtml::_('date',$this->user->lastvisitDate);?></div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="list-group">
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-xs-6">
                      <h5 class="pink"><?php echo JText::_( 'Security' ); ?></h5>
                    </div>
                    <div class="col-xs-6 text-right"> <a class="show_cp btn btn_default btn-xs" title="Edit account" href="<?php echo JURI::base(); ?>edit-account"><span class="fa fa-edit"></span> Edit</a> </div>
                  </div>
                </div>
                <div class="list-group-item">
                  <div class="row pas_sample">
                    <div class="col-lg-5 col-md-5 col-sm-6" style="margin-bottom: 10px;">
                      <div class="purple" style="font-weight: bold;" ><?php echo JText::_( 'Password' ); ?></div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                      <div style="padding-top: 0;">******</div>
                    </div>
                  </div>
                  <form id="user_pass" action="<?php echo JURI::current(); ?>" method="post" name="user_pass" autocomplete="off" class="user frm" style="display:none;">
                  	<div class="alert alert-danger hide">
                      <div class="notification"></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( 'New Password' ); ?></div>
                        <input class="txtbox no-empty" type="password" id="password" name="password" value="" placeholder="Password" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div style="font-weight: bold; margin-bottom:5px;" ><?php echo JText::_( ' Verify Password' ); ?></div>
                        <input class="txtbox no-empty" type="password" id="password2" name="verifypassword" value="" placeholder="Verify Password" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 p-t-10 text-right">
                        <button class="btn btn-default cancel" type="button"><?php echo JText::_( 'Cancel' ); ?></button>
                        <button class="btn btn-red" type="submit"><?php echo JText::_( 'Save' ); ?></button>
                      </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
                    <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
                    <input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
                    <input type="hidden" name="option" value="com_user" />
                    <input type="hidden" name="act" value="pass" />
                    <input type="hidden" name="task" value="save" />
                    <input type="hidden" name="return" value="<?php echo base64_encode(JURI::current()) ?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12">
          <?php 
          $document = JFactory::getDocument();
          $renderer = $document->loadRenderer('module');
          $module = JModuleHelper::getModule('login','Sidebar Login');
          echo $renderer->render($module);
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
