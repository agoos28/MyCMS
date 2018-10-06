<?php // @version $Id: default_logout.php 8944 2007-09-18 03:04:14Z friesengeist $
defined( '_JEXEC' ) or die( 'Restricted access' );
global $mainframe;
//$mainframe->redirect(JURI::base().'administration/store/invoices');
?>
<div style="height:30px;"></div>
<div class="row">
<div class="col-lg-8 col-md-12">
  <div class="panel panel-white">
    <div class="panel-heading border-light">
      <h4 class="panel-title"><strong>Earnings</strong></h4>
      <ul class="panel-heading-tabs border-light">
        <li>
          <div id="reportrange" class="pull-right">
            <span>This Week </span><i class="fa fa-angle-down"></i>
          </div>
        </li>
        <li>
          <div class="rate">
            <i class="fa fa-caret-up text-green"></i><span class="value">15</span><span class="percentage">%</span>
          </div>
        </li>
        <li class="panel-tools">
          <div class="dropdown">
            <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
              <i class="fa fa-cog"></i>
            </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li>
                <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
              </li>
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
              </li>
            </ul>
          </div>
          <a class="btn btn-xs btn-link panel-close" href="#">
            <i class="fa fa-times"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="panel-body no-padding partition-green">
      <div class="col-md-3 col-lg-2 no-padding">
        <div class="partition-body padding-15">
          <ul class="mini-stats">
            <li class="col-md-12 col-sm-4 col-xs-4 no-padding">
              <div class="sparkline-bar sparkline-1">
                <span></span>
              </div>
              <div class="values">
                <strong>18304</strong>
                Sales
              </div>
            </li>
            <li class="col-md-12 col-sm-4 col-xs-4 no-padding">
              <div class="sparkline-bar sparkline-2">
                <span></span>
              </div>
              <div class="values">
                <strong>&#36;3,833</strong>
                Earnings
              </div>
            </li>
            <li class="col-md-12 col-sm-4 col-xs-4 no-padding">
              <div class="sparkline-bar sparkline-3">
                <span></span>
              </div>
              <div class="values">
                <strong>&#36;848</strong>
                Referrals
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-9 col-lg-10 no-padding partition-white">
        <div class="partition">
          <div class="partition-body padding-15">
            <div class="height-300">
              <div id="chart1" class='with-3d-shadow with-transitions'>
                <svg></svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-4 col-md-12">
  <div class="panel panel-green">
    <div class="panel-heading border-light">
      <span class="text-large text-white">Store Update</span>
      <div class="panel-tools">
        <div class="dropdown">
          <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-white">
            <i class="fa fa-cog"></i>
          </a>
          <ul class="dropdown-menu dropdown-light pull-right" role="menu">
            <li>
              <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
            </li>
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
            </li>
          </ul>
        </div>
        <a class="btn btn-xs btn-link panel-close" href="#">
          <i class="fa fa-times"></i>
        </a>
      </div>
    </div>
    <div class="panel-body no-padding">
      
      <div class="tabbable no-margin no-padding partition-dark">
        <ul class="nav nav-tabs" id="myTab2">
          <li class="active">
            <a data-toggle="tab" href="#todo_tab_example1">
              Checkouts
            </a>
          </li>
          <li class="">
            <a data-toggle="tab" href="#todo_tab_example2">
              Payments
            </a>
          </li>
          <li class="">
            <a data-toggle="tab" href="#todo_tab_example3">
              Popular Product
            </a>
          </li>
        </ul>
        <div class="tab-content partition-white">
          <div id="todo_tab_example1" class="tab-pane padding-bottom-5 active">
            <div class="panel-scroll height-280">
              <ul class="todo">
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Staff Meeting</span><span class="label label-danger"> today</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 13:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">New frontend layout</span><span class="label label-danger"> today</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 20:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Hire developers</span><span class="label label-warning"> tommorow</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 7:00 AM Tomorrow</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Staff Meeting</span><span class="label label-success"> this week</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 12:00 AM this week</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="todo_tab_example2" class="tab-pane padding-bottom-5">
            <div class="panel-scroll height-280">
              <ul class="todo">
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Hire developers</span><span class="label label-success"> Monday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 12:00 AM this week</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Lunch with Nicole</span><span class="label label-danger"> Wednesday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 20:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">New frontend layout</span><span class="label label-warning"> Wednesday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 7:00 AM Tomorrow</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Staff Meeting</span><span class="label label-danger"> Friday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 13:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="todo_tab_example3" class="tab-pane padding-bottom-5">
            <div class="panel-scroll height-280">
              <ul class="todo">
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Lunch with Boss</span><span class="label label-warning"> 01 monday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 12:00 AM this week</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Bootstrap Seminar</span><span class="label label-success"> 05 wednesday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 20:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">New frontend layout</span><span class="label label-warning"> 05 Wednesday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 7:00 AM Tomorrow</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="todo-actions">
                    <i class="fa fa-square-o"></i>
                    <div class="padding-horizontal-5">
                      <div class="block space5">
                        <span class="desc">Staff Meeting</span><span class="label label-danger"> 07 Friday</span>
                      </div>
                      <div class="block">
                        <span class="desc text-small text-light"><i class="fa fa-clock-o"></i> 13:00 PM Today</span>
                        <div class="btn-group btn-group-sm todo-tools">
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn" href="javascript:;">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="row">
							<div class="col-md-12">
								<!-- start: FAQ -->
								<div class="tabbable tabs-left faq">
									<ul id="myTab3" class="nav nav-tabs">
										<li class="active">
											<a href="#faq_example1" data-toggle="tab">
												<i class="fa fa-smile-o"></i> About the new Product
											</a>
										</li>
										<li class="">
											<a href="#faq_example2" data-toggle="tab">
												<i class="fa fa-shopping-cart"></i> Buying Product
											</a>
										</li>
										<li class="">
											<a href="#faq_example3" data-toggle="tab">
												<i class="fa fa-lightbulb-o"></i> Benefits of the new Product
											</a>
										</li>
										<li class="">
											<a href="#faq_example4" data-toggle="tab">
												<i class="fa fa-download"></i> Download and install the Product
											</a>
										</li>
										<li class="">
											<a href="#faq_example5" data-toggle="tab">
												<i class="fa fa-laptop"></i> Billing and renewal
											</a>
										</li>
										<li class="">
											<a href="#faq_example6" data-toggle="tab">
												<i class="fa fa-wrench"></i> Support and resources
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="faq_example1">
											<div id="accordion" class="panel-group accordion accordion-custom accordion-teal">
																								
												<h3 class="margin-bottom-15">About the new Product</h3>
												
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_1" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Excepteur sint obcaecat cupiditat non proident?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_1_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_2" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis aute iure reprehenderit in voluptate velit esse cillum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_1_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_3" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Nemo enim ipsam voluptatem, quia voluptas sit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_1_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_4" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Excepteur sint obcaecat cupiditat non proident?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_1_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_5" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis aute iure reprehenderit in voluptate velit esse cillum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_1_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_1_6" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Nemo enim ipsam voluptatem, quia voluptas sit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_1_6">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="faq_example2">
											<div id="accordion2" class="panel-group accordion accordion-custom accordion-teal">
												<h3 class="margin-bottom-15"> Buying Product</h3>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_2_1" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Spernatur aut odit aut fugit sed quia consequuntur magni?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_2_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_2_2" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Qui ratione voluptatem sequi nesciunt?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_2_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_2_3" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis nostrum exercitationem ullam corporis suscipit laboriosam?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_2_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_2_4" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Nisi ut aliquid ex ea commodi consequatur?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_2_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_2_5" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis autem vel eum iure reprehenderit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_2_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="faq_example3">
											<div id="accordion3" class="panel-group accordion accordion-custom accordion-teal">
												<h3 class="margin-bottom-15">Benefits of the new Product</h3>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_1" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Quis autem vel eum iure reprehenderit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_3_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_2" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Nisi ut aliquid ex ea commodi consequatur?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_3" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis nostrum exercitationem ullam corporis suscipit laboriosam?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_4" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Excepteur sint obcaecat cupiditat non proident
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_5" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Temporibus autem quibusdam et aut officiis?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_6" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Anim pariatur cliche reprehenderit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_6">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_7" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Excepteur sint obcaecat cupiditat non proident
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_7">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_3_8" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Temporibus autem quibusdam et aut officiis?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_3_8">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="faq_example4">
											<div id="accordion4" class="panel-group accordion accordion-custom accordion-teal">
												<h3 class="margin-bottom-15">Download and install the Product</h3>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_1" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Feugiat nulla facilisis at vero eros?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_4_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_2" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Accumsan et iusto odio dignissim qui blandit?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_4_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_3" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Nam liber tempor cum soluta nobis?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_4_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_4" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Placerat facer possim assum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_4_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_5" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Typi non habent claritatem insitam?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_4_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_4_6" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Est usus legentis in iis qui facit eorum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_4_6">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="faq_example5">
											<div id="accordion5" class="panel-group accordion accordion-custom accordion-teal">
												<h3 class="margin-bottom-15">Billing and renewal</h3>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_1" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Investigationes demonstraverunt lectores?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_5_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_2" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Legere me lius quod ii legunt saepius?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_5_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_3" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Claritas est etiam processus dynamicus?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_5_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_4" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Qui sequitur mutationem consuetudium lectorum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_5_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_5" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Mirum est notare quam littera gothica?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_5_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_5_6" data-parent="#accordion5" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quam nunc putamus parum claram?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_5_6">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="faq_example6">
											<div id="accordion6" class="panel-group accordion accordion-custom accordion-teal">
												<h3 class="margin-bottom-15">Support and resources</h3>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_1" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle">
															<i class="icon-arrow"></i> Anteposuerit litterarum formas humanitatis?
														</a></h4>
													</div>
													<div class="panel-collapse collapse in" id="faq_6_1">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_2" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Per seacula quarta decima?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_2">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_3" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Eodem modo typi?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_3">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_4" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Qui nunc nobis videntur parum clari?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_4">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_5" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Fiant sollemnes in futurum?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_5">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_6" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Quis nostrud exerci tation ullamcorper suscipit lobortis?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_6">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
														<a href="#faq_6_7" data-parent="#accordion6" data-toggle="collapse" class="accordion-toggle collapsed">
															<i class="icon-arrow"></i> Aliquip ex ea commodo consequat?
														</a></h4>
													</div>
													<div class="panel-collapse collapse" id="faq_6_7">
														<div class="panel-body">
															Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end: FAQ -->
							</div>
						</div>
<?php
$asset = JURI::base().'templates/admin/';
?>
<script src="<?php echo $asset; ?>plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/lib/d3.v3.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/nv.d3.min.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/src/models/historicalBar.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/src/models/historicalBarChart.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/src/models/stackedArea.js"></script>
<script src="<?php echo $asset; ?>plugins/nvd3/src/models/stackedAreaChart.js"></script>
<script src="<?php echo $asset; ?>plugins/jquery.sparkline/jquery.sparkline.js"></script>
<script src="<?php echo $asset; ?>plugins/easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="<?php echo $asset; ?>js/index.js"></script>
<script>
jQuery(document).ready(function() {
	Index.init();
});
</script>
