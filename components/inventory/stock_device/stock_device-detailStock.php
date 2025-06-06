<?php
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}

if (isset($test_on_local) && $test_on_local == 1) {
	//$flt_product_category = "1";
}
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];
$count_cl 				= 0;

if ((!isset($flt_product_id) || (isset($flt_product_id) && $flt_product_id == '')) &&  isset($detail_id)) {
	$flt_product_id = $detail_id;
}
if ((!isset($flt_stock_status) || (isset($flt_stock_status) && $flt_stock_status == '')) &&  isset($filter_1)) {
	$flt_stock_status = $filter_1;
}
if ((!isset($flt_stock_grade) || (isset($flt_stock_grade) && $flt_stock_grade == '')) &&  isset($filter_2)) {
	$flt_stock_grade = $filter_2;
}
if ((!isset($flt_serial_no) || (isset($flt_serial_no) && $flt_serial_no == '')) &&  isset($filter_3)) {
	$flt_serial_no = $filter_3;
}
if (isset($is_Submit) || isset($id)) {
	if (empty($flt_product_id) && empty($flt_stock_grade) && empty($flt_stock_status) && empty($flt_product_desc) && empty($flt_product_category) && empty($flt_serial_no) && empty($flt_bin_id)) {
		if (isset($is_final_inventory) && $is_final_inventory != '0') {
			$error['msg'] = "Please select or input at least one field above.";
		}
	}
	if (empty($error)) {
		$sql_cl = "	SELECT  a2.id, a2.product_id, a2.serial_no, a2.model_no, a2.battery_percentage, a2.ram_size, a2.storage_size, a2.price, a2.cosmetic_grade,
							b.category_name, c.status_name, a.product_desc, a.product_uniqueid, d.sub_location_name, a2.p_inventory_status, a2.stock_grade, d6.type_name,
							a2.is_packed
					FROM products a
					INNER JOIN product_stock a2 ON a2.product_id = a.id
					LEFT JOIN product_categories b ON b.id = a.product_category
					LEFT JOIN inventory_status c ON c.id = a2.p_inventory_status
					LEFT JOIN warehouse_sub_locations d ON d.id = a2.sub_location
					LEFT JOIN purchase_order_detail_receive d2 ON d2.id = a2.receive_id
					LEFT JOIN purchase_order_detail d3 ON d3.id = d2.po_detail_id
					LEFT JOIN purchase_orders d4 ON d4.id = d3.po_id
					LEFT JOIN venders d5 ON d5.id = d4.vender_id
					LEFT JOIN vender_types d6 ON d6.id = d5.vender_type 
					WHERE 1=1  
					AND a2.p_total_stock >0
					AND a2.is_final_pricing = 1
					AND a.enabled = 1 "; //AND a2.is_final_pricing = 1
		$import_params = "";
		if (isset($detail_id) && $detail_id > 0) {
			$sql_cl			.= " AND a.product_uniqueid = '" . $detail_id . "' ";
			$import_params 	.= "&detail_id= " . $detail_id;
		}
		if (!isset($is_final_inventory)) {
			$is_final_inventory	 = 1;
		}
		if (isset($is_final_inventory) && $is_final_inventory != "") {
			$sql_cl			.= " AND a2.is_final_pricing = '" . $is_final_inventory . "' ";
			$import_params 	.= "&is_final_inventory=" . $is_final_inventory;
		}
		if (isset($flt_product_id) && $flt_product_id != "") {
			$sql_cl 	.= " AND a.product_uniqueid LIKE '%" . trim($flt_product_id) . "%' ";
			$import_params 	.= "&flt_product_id=" . $flt_product_id;
		}
		if (isset($flt_stock_grade) && $flt_stock_grade > 0) {
			$sql_cl		.= " AND a2.stock_grade = '" . $flt_stock_grade . "' ";
			$import_params 	.= "&flt_stock_grade=" . $flt_stock_grade;
		}
		if (isset($flt_stock_status) && $flt_stock_status > 0) {
			$sql_cl		.= " AND a2.p_inventory_status = '" . $flt_stock_status . "' ";
			$import_params 	.= "&flt_stock_status=" . $flt_stock_status;
		}
		if (isset($flt_product_desc) && $flt_product_desc != "") {
			$sql_cl 	.= " AND a.product_desc LIKE '%" . trim($flt_product_desc) . "%' ";
			$import_params 	.= "&flt_product_desc=" . $flt_product_desc;
		}
		if (isset($flt_product_category) && $flt_product_category != "") {
			$sql_cl 	.= " AND a.product_category = '" . trim($flt_product_category) . "' ";
			$import_params 	.= "&flt_product_category=" . $flt_product_category;
		}
		if (isset($flt_serial_no) && $flt_serial_no > 0) {
			$sql_cl		.= " AND a2.serial_no LIKE '%" . $flt_serial_no . "%' ";
			$import_params 	.= "&flt_serial_no=" . $flt_serial_no;
		}
		if (isset($flt_bin_id) && $flt_bin_id > 0) {
			$sql_cl		.= " AND a2.sub_location = '" . $flt_bin_id . "' ";
			$import_params 	.= "&flt_bin_id=" . $flt_bin_id;
		}
		$sql_cl		.= " ORDER BY c.status_name DESC, a2.stock_grade";
		// echo $sql_cl;
		$result_cl	= $db->query($conn, $sql_cl);
		$count_cl	= $db->counter($result_cl);
		if (isset($action_exportButton) && $action_exportButton == "export" && $count_cl > 0) {
			$redirect_to_export = "export/export_available_stock.php?string=." . encrypt("module_id=" . $module_id) . $import_params;
			// echo "<br><br><br>" . $redirect_to_export;die;
			echo '<script> window.open("' . $redirect_to_export . '"); </script>';
		} else {
			$action_searchButton = "search";
		}
		if (!isset($action_exportButton) && $count_cl == 0) {
			$error['msg'] = "Records not found.";
		}
	}
}
$page_heading 	= "Stock Detail";
?>
<!-- BEGIN: Page Main-->
<div id="main" class="<?php echo $page_width; ?>">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
		<div class="col s12 m12 l12">
			<div class="section section-data-tables">
				<div class="card custom_margin_card_table_top custom_margin_card_table_bottom">
					<div class="card-content custom_padding_card_content_table_top_bottom">
						<div class="row">
							<div class="input-field col m4 s12" style="margin-top: 3px; margin-bottom: 3px;">
								<h6 class="media-heading">
									<?php echo $page_heading; ?>
								</h6>
							</div>
							<div class="input-field col m4 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
								<?php
								$sitebar_parm2 = $sitebar_parm3 = "";
								$check_menu_permissions = check_menu_permissions($db, $conn, $_SESSION['user_id'], $_SESSION['subscriber_users_id'], $_SESSION['user_type'], 11, $selected_db_name, $sitebar_parm2, $sitebar_parm3);
								if ($check_menu_permissions > 0) { ?>
									<a class="btn gradient-45deg-green-teal waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=11&page=listing") ?>">
										Products
									</a>
									</a>
								<?php }
								$sitebar_parm2 = $sitebar_parm3 = "";
								$check_menu_permissions = check_menu_permissions($db, $conn, $_SESSION['user_id'], $_SESSION['subscriber_users_id'], $_SESSION['user_type'], 18, $selected_db_name, $sitebar_parm2, $sitebar_parm3);
								if ($check_menu_permissions > 0) { ?>
									&nbsp;&nbsp;
									<a class="btn gradient-45deg-green-teal waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=18&page=listing") ?>">
										Stock
									</a>
								<?php } ?>
							</div>
							<div class="input-field col m4 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
								<?php
								if (access("add_perm") == 1) { ?>
									<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=listing") ?>">
										Stock Summary
									</a>
								<?php } ?>
								<?php
								if (access("add_perm") == 1) { ?>
									<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=import") ?>">
										Import
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m12 l12">
			<!-- Page Length Options -->
			<div id="Form-advance" class="card card card-default scrollspy custom_margin_card_table_top custom_margin_card_table_bottom">
				<div class="card-content custom_padding_card_content_table_top">
					<?php
					if (isset($error['msg'])) { ?>
						<div class="row">
							<div class="col 24 s12">
								<div class="card-alert card red lighten-5">
									<div class="card-content red-text">
										<p><?php echo $error['msg']; ?></p>
									</div>
									<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
							</div>
						</div>
					<?php } else if (isset($msg['msg_success'])) { ?>
						<div class="row">
							<div class="col 24 s12">
								<div class="card-alert card green lighten-5">
									<div class="card-content green-text">
										<p><?php echo $msg['msg_success']; ?></p>
									</div>
									<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
							</div>
						</div>
					<?php } ?>
					<h4 class="card-title"><?php echo $page_heading; ?></h4>
					<form method="post" action="?string=<?php echo encrypt("module_id=" . $module_id . "&page=" . $page) ?>" autocomplete="off" enctype="multipart/form-data">
						<input type="hidden" name="is_Submit" value="Y" />
						<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
						<input type="hidden" id="action" name="action" value="<?php if (isset($action)) echo $action; ?>" />
						<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																			echo encrypt($_SESSION['csrf_session']);
																		} ?>">
						<div class="row">

							<div class="input-field col m3 s12 custom_margin_bottom_col">
								<?php
								$field_name     = "flt_product_id";
								$field_label	= "ProductID";
								$sql1			= "SELECT DISTINCT product_uniqueid FROM products WHERE 1=1 ";
								$result1		= $db->query($conn, $sql1);
								$count1         = $db->counter($result1);
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">All</option>
										<?php
										if ($count1 > 0) {
											$row1    = $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['product_uniqueid']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['product_uniqueid']) { ?> selected="selected" <?php } ?>><?php echo $data2['product_uniqueid']; ?></option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"><?php
																if (isset($error[$field_name])) {
																	echo $error[$field_name];
																} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m3 s12 custom_margin_bottom_col">
								<?php
								$field_name 	= "flt_product_desc";
								$field_label 	= "Product Description";
								$sql1			= "SELECT DISTINCT product_desc FROM products WHERE 1=1 ";
								$result1		= $db->query($conn, $sql1);
								$count1         = $db->counter($result1);
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">All</option>
										<?php
										if ($count1 > 0) {
											$row1    = $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['product_desc']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['product_desc']) { ?> selected="selected" <?php } ?>><?php echo $data2['product_desc']; ?></option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"><?php
																if (isset($error[$field_name])) {
																	echo $error[$field_name];
																} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m3 s12">
								<?php
								$field_name 	= "flt_serial_no";
								$field_label 	= "Serial#";
								$sql1 			= "	SELECT DISTINCT serial_no 
													FROM product_stock 
													WHERE enabled = 1 
													AND serial_no !=''
													AND p_total_stock >0
													AND is_final_pricing = 1
													ORDER BY serial_no  ";
								$result1 		= $db->query($conn, $sql1);
								$count1 		= $db->counter($result1);
								?>
								<i class="material-icons prefix">description</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class=" select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">ALL</option>
										<?php
										if ($count1 > 0) {
											$row1	= $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['serial_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['serial_no']) { ?> selected="selected" <?php } ?>><?php echo $data2['serial_no']; ?></option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"> <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m3 s12">
								<?php
								$field_name 	= "flt_product_category";
								$field_label 	= "Category";
								$sql1 			= "SELECT * FROM product_categories WHERE enabled = 1 AND category_type = 'Device' ORDER BY category_name ";
								$result1 		= $db->query($conn, $sql1);
								$count1 		= $db->counter($result1);
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class=" select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">ALL</option>
										<?php
										if ($count1 > 0) {
											$row1	= $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['category_name']; ?></option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"> <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m3 s12">
								<?php
								$field_name		= "flt_stock_status";
								$field_label	= "Status";
								$sql1			= " SELECT * FROM inventory_status WHERE enabled = 1 AND id IN(" . $status_for_search . ")";
								$result1		= $db->query($conn, $sql1);
								$count1			= $db->counter($result1);
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">ALL</option>
										<?php
										if ($count1 > 0) {
											$row1    = $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['status_name']; ?> </option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"><?php
																if (isset($error[$field_name])) {
																	echo $error[$field_name];
																} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m3 s12">
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<?php
									$field_name     = "flt_bin_id";
									$field_label    = "Bin/Location";

									$sql1           = " SELECT b.id,b.sub_location_name, b.sub_location_type
														FROM product_stock a 
														INNER JOIN  products a2 ON a2.id = a.product_id
														INNER JOIN warehouse_sub_locations b ON b.id = a.sub_location 
														WHERE a.p_total_stock > 0
														
														GROUP BY b.id ";
									$result1        = $db->query($conn, $sql1);
									$count1         = $db->counter($result1);
									?>
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class=" select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">ALL</option>
										<?php
										if ($count1 > 0) {
											$row1    = $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php
																																																	echo $data2['sub_location_name'];
																																																	if ($data2['sub_location_type'] != "") {
																																																		echo "(" . ucwords(strtolower($data2['sub_location_type'])) . ")";
																																																	} ?></option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"> <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m3 s12">
								<?php
								$field_name		= "flt_stock_grade";
								$field_label	= "Condition/Grades";
								$sql1			= " SELECT * FROM product_grades WHERE enabled = 1 ";
								$result1		= $db->query($conn, $sql1);
								$count1			= $db->counter($result1);
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">ALL</option>
										<?php
										if ($count1 > 0) {
											$row1    = $db->fetch($result1);
											foreach ($row1 as $data2) { ?>
												<option value="<?php echo $data2['grade_name']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['grade_name']) { ?> selected="selected" <?php } ?>><?php echo $data2['grade_name']; ?> </option>
										<?php }
										} ?>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"> <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="input-field col m2 s12">
								<?php
								$field_name 	= "is_final_inventory";
								$field_label 	= "Type";
								?>
								<i class="material-icons prefix">question_answer</i>
								<div class="select2div">
									<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class=" select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
																																										echo ${$field_name . "_valid"};
																																									} ?>">
										<option value="">All</option>
										<option value="1" <?php if (isset(${$field_name}) && ${$field_name} == "1") { ?> selected="selected" <?php } ?>>In Stock</option>
										<option value="0" <?php if (isset(${$field_name}) && ${$field_name} == "0") { ?> selected="selected" <?php } ?>>In Process</option>
									</select>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red"> <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
						</div>
						<div class="row ">
							<div class="input-field col m4 s12"></div>
							<div class="input-field col m1 s12">
								<button id="searchButton" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange " type="submit" name="action_searchButton" value="search">Search</button>
							</div>
							<div class="input-field col m2 s12">
								<button id="exportButton" class="waves-effect waves-light  btn gradient-45deg-light-blue-cyan box-shadow-none border-round mr-1 mb-1" type="submit" name="action_exportButton" value="export">Export in Excel</button>
							</div>
							<div class="input-field col m1 s12">
								<a href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=" . $page) ?>" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-red ">Reset Search</a>
							</div>
							<div class="input-field col m4 s12"></div>
						</div>
					</form>
					<?php if (isset($action_searchButton) && $action_searchButton == "search") { ?>
						<div class="section section-data-tables">
							<div class="row">
								<div class="text_align_right">
									<?php
									$table_columns	= array('SNo',  'Product ID / Product Detail', 'Vendor Type', 'Status', 'Condition', 'Serial No', 'Model No', 'Battery', 'RAM', 'Storage', 'Price', 'Sub Location', 'Cosmetic Grade');
									$k 				= 0;
									foreach ($table_columns as $data_c1) { ?>
										<label>
											<input type="checkbox" value="<?= $k ?>" name="table_columns[]" class="filled-in toggle-column" data-column="<?= set_table_headings($data_c1) ?>" checked="checked">
											<span><?= $data_c1 ?></span>
										</label>&nbsp;&nbsp;
									<?php
										$k++;
									} ?>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<?php
									if (isset($count_cl) && $count_cl > 0) { ?>
										<table id="page-length-option" class="display pagelength50">
											<thead>
												<tr>
													<?php
													$headings = "";
													foreach ($table_columns as $data_c) {
														if ($data_c == 'SNo') {
															$headings .= '<th class="sno_width_60 col-' . set_table_headings($data_c) . '">' . $data_c . '</th>';
														} else {
															$headings .= '<th class="col-' . set_table_headings($data_c) . '">' . $data_c . '</th> ';
														}
													}
													echo $headings;
													?>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 0;
												$row_cl = $db->fetch($result_cl);
												foreach ($row_cl as $data) {
													$id 				= $data['id'];
													$product_id 		= $data['product_id'];
													$product_uniqueid	= $data['product_uniqueid'];
													$filter_1			= $data['p_inventory_status'];
													$filter_2			= $data['stock_grade'];
													$is_packed			= $data['is_packed'];
												?>
													<tr>
														<td style="text-align: center;" class="col-<?= set_table_headings($table_columns[0]); ?>"><?php echo $i + 1; ?></td>
														<td class="col-<?= set_table_headings($table_columns[1]); ?>">
															<?php
															if (access("edit_perm") == 1) { ?>
																<a class="" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=detailStock&id=" . $product_id . "&detail_id=" . $product_uniqueid . "&filter_1=" . $filter_1 . "&filter_2=" . $filter_2) ?>" title="Detail Stock View">
																	<?php echo $data['product_uniqueid']; ?>
																</a> &nbsp;&nbsp;
															<?php } else {
																echo $data['product_uniqueid'];
															} ?>
															<br>
															<?php
															if (access("edit_perm") == 1) { ?>
																<a class="" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=history&id=" . $product_id) ?>" title="Detail View">
																	<?php

																	if ($data['product_desc'] != "") {
																		echo ucwords(strtolower($data['product_desc']));
																	}  ?> (<?php echo $data['category_name']; ?>)
																</a> &nbsp;&nbsp;
															<?php } else {
																if ($data['product_desc'] != "") {
																	echo ucwords(strtolower($data['product_desc']));
																} ?> (<?php echo $data['category_name']; ?>)
															<?php } ?>
														</td>
														<td class="col-<?= set_table_headings($table_columns[2]); ?>">
															<?php
															if ($data['type_name'] != "") {
																echo ucwords(strtolower($data['type_name']));
															} ?>
														</td>
														<td class="col-<?= set_table_headings($table_columns[3]); ?>">
															<?php
															$status_name = $data['status_name'];
															if ($status_name == 'Defective') { ?>
																<span class="chip red lighten-5">
																	<span class="red-text">
																		<?php echo $status_name; ?></span>
																</span>
															<?php } else if ($status_name == 'Tested/Graded') { ?>
																<span class="chip green lighten-5">
																	<span class="green-text">
																		<?php echo $status_name; ?>
																	</span>
																</span>
															<?php
															} else { ?>
																<span class="chip blue lighten-5">
																	<span class="blue-text">
																		<?php echo $status_name; ?></span>
																</span>
																<?php
															}
															$sql_sub = "SELECT IFNULL(b.id, 0) AS stock_detail_id, IFNULL(d.id, 0) AS packed_id, IFNULL(e.id, 0) AS shipped_detail_id, c.so_no
																		FROM product_stock a2
																		LEFT JOIN sales_order_detail b ON b.product_stock_id = a2.id
																		LEFT JOIN sales_orders c ON c.id = b.`sales_order_id`
																		LEFT JOIN sales_order_detail_packing d ON d.product_stock_id = a2.id
																		LEFT JOIN sales_order_shipment_detail e ON e.`packed_id` = d.id
																		WHERE a2.id = '" . $id . "'
																		ORDER BY a2.id, c.id";
															$result_sub  = $db->query($conn, $sql_sub);
															$count_sub   = $db->counter($result_sub);
															if ($count_sub > 0) {
																$row_sub = $db->fetch($result_sub);
																foreach ($row_sub as $data_sub) {
																	$stock_detail_id   = $data_sub['stock_detail_id'];
																	$packed_id 		   = $data_sub['packed_id'];
																	$shipped_detail_id = $data_sub['shipped_detail_id'];
																	$so_no 			   = $data_sub['so_no'];
																	echo "<br>";
																	if ($shipped_detail_id > 0) { ?>
																		<span class="chip blue lighten-5">
																			<span class="blue-text">
																				<?php echo "<b>Shipped (" . $so_no . ")</b>"; ?>
																			</span>
																		</span>
																		<?php
																	} else {
																		if ($packed_id > 0) { ?>
																			<span class="chip blue lighten-5">
																				<span class="blue-text">
																					<?php echo "<b>Packed (" . $so_no . ")</b>"; ?>
																				</span>
																			</span>
																			<?php
																		} else {
																			if ($stock_detail_id > 0) { ?>
																				<span class="chip blue lighten-5">
																					<span class="blue-text">
																						<?php echo "<b>Added in (" . $so_no . ")</b>"; ?>
																					</span>
																				</span>
															<?php
																			}
																		}
																	}
																}
															} ?>
														</td>
														<td class="col-<?= set_table_headings($table_columns[4]); ?>"><?php echo $data['stock_grade']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[5]); ?>"><?php echo $data['serial_no']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[6]); ?>"><?php echo $data['model_no']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[7]); ?>">
															<?php
															if ($data['battery_percentage'] != "") {
																echo $data['battery_percentage'] . "%";
															} ?>
														</td>
														<td class="col-<?= set_table_headings($table_columns[8]); ?>"><?php echo $data['ram_size']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[9]); ?>"><?php echo $data['storage_size']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[10]); ?>"><?php echo number_format($data['price'], 2); ?></td>
														<td class="col-<?= set_table_headings($table_columns[11]); ?>"><?php echo $data['sub_location_name']; ?></td>
														<td class="col-<?= set_table_headings($table_columns[12]); ?>"><?php echo $data['cosmetic_grade']; ?></td>
													</tr>
												<?php
													$i++;
												} ?>
											<tfoot>
												<tr>
													<?php echo $headings; ?>
												</tr>
											</tfoot>
										</table>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php include('sub_files/right_sidebar.php'); ?>
			<div class="content-overlay"></div>
		</div>
	</div>

</div>