<?php
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}

$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];

if (!isset($flt_stage_status)) {
	$flt_stage_status = array('Draft', 'Committed');
}

if (isset($cmd) && ($cmd == 'disabled' || $cmd == 'enabled') && access("delete_perm") == 0) {
	$error['msg'] = "You do not have edit permissions.";
} else {
	if (isset($cmd) && $cmd == 'disabled') {
		$sql_c_upd = "UPDATE purchase_orders set enabled = 0,
												update_date = '" . $add_date . "' ,
												update_by 	= '" . $_SESSION['username'] . "' ,
												update_ip 	= '" . $add_ip . "'
					WHERE id = '" . $id . "' ";
		$enabe_ok = $db->query($conn, $sql_c_upd);
		if ($enabe_ok) {
			$msg['msg_success'] = "Record has been disabled.";
		} else {
			$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
		}
	}
	if (isset($cmd) && $cmd == 'enabled') {
		$sql_c_upd = "UPDATE purchase_orders set 	enabled 	= 1,
											update_date = '" . $add_date . "' ,
											update_by 	= '" . $_SESSION['username'] . "' ,
											update_ip 	= '" . $add_ip . "'
					WHERE id = '" . $id . "' ";
		$enabe_ok = $db->query($conn, $sql_c_upd);
		if ($enabe_ok) {
			$msg['msg_success'] = "Record has been enabled.";
		}
	}
}
$sql_cl			= " SELECT * FROM (
						SELECT '' AS offer_no, aa.po_no,aa.vender_invoice_no, aa.order_status, aa.sub_user_id,
								aa.id AS po_id_master, aa.enabled,  
								c.id as vender_id, c.vender_name, aa.po_date, aa.enabled AS order_enabled, aa.add_by_user_id AS add_by_user_id_order,
								f.status_name AS po_status_name, aa.is_tested_po, aa.is_wiped_po, aa.is_imaged_po, aa.stage_status
						FROM purchase_orders aa
						LEFT JOIN venders c ON c.id = aa.vender_id
						LEFT JOIN inventory_status f ON f.id = aa.order_status
						WHERE 1=1 
						AND aa.offer_id = 0
						
						UNION ALL 
						
						SELECT 	a.offer_no AS offer_no, aa.po_no, aa.vender_invoice_no, aa.order_status, aa.sub_user_id, 
								aa.id AS po_id_master, aa.enabled, 
								c.id as vender_id, c.vender_name, aa.po_date, aa.enabled AS order_enabled, aa.add_by_user_id AS add_by_user_id_order, 
								f.status_name AS po_status_name, aa.is_tested_po, aa.is_wiped_po, aa.is_imaged_po, aa.stage_status
						FROM purchase_orders aa
						INNER JOIN offers a ON a.id = aa.offer_id
						INNER JOIN venders c ON c.id = a.vender_id
						INNER JOIN inventory_status f ON f.id = aa.order_status
						WHERE 1=1 
						AND aa.offer_id != 0
					) AS t1
					WHERE 1=1 ";
if (po_permisions("ALL PO in List") != '1') {
	$sql_cl	.= " AND (t1.sub_user_id = '" . $_SESSION['user_id'] . "' || t1.add_by_user_id_order = '" . $_SESSION['user_id'] . "') ";
}
if (isset($flt_po_no) && $flt_po_no != "") {
	$sql_cl 	.= " AND t1.po_no LIKE '%" . trim($flt_po_no) . "%' ";
}
if (isset($flt_vender_id) && $flt_vender_id != "") {
	$sql_cl 	.= " AND t1.vender_id = '" . trim($flt_vender_id) . "' ";
}
if (isset($flt_vender_invoice_no) && $flt_vender_invoice_no != "") {
	$sql_cl 	.= " AND t1.vender_invoice_no LIKE '%" . trim($flt_vender_invoice_no) . "%' ";
}
if (isset($flt_po_status) && $flt_po_status != "") {
	$sql_cl 	.= " AND t1.order_status = '" . trim($flt_po_status) . "' ";
}
if (isset($flt_stage_status)) {
	if ((sizeof($flt_stage_status) > 0  && $flt_stage_status[0] != 'All')) {
		$flt_stage_status_all = implode(',', $flt_stage_status);
		$sql_cl 	.= " AND FIND_IN_SET( t1.stage_status,  '" . $flt_stage_status_all . "') ";
	}
}
$sql_cl	.= " AND t1.enabled = 1
			 ORDER BY  t1.enabled DESC, t1.po_id_master DESC";
// echo $sql_cl;
$result_cl		= $db->query($conn, $sql_cl);
$count_cl		= $db->counter($result_cl);
$page_heading 	= "List Purchase Orders ";
?>
<!-- BEGIN: Page Main-->
<div id="main" class="<?php echo $page_width; ?>">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
		<div class="col s12">
			<div class="container">
				<div class="section section-data-tables">
					<div class="row">
						<div class="col s12">
							<div class="card custom_margin_card_table_top">
								<div class="card-content custom_padding_card_content_table_top_bottom">
									<div class="row">
										<div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
											<h6 class="media-heading">
												<?php echo $page_heading; ?>
											</h6>
										</div>
										<div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
											<?php
											if (access("add_perm") == 1) { ?>
												<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=add&active_tab=tab1") ?>">
													New
												</a>
											<?php } ?>
											<?php
											if (access("add_perm") == 1) { ?>
												<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=import") ?>">
													Import
												</a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Page Length Options -->
					<div class="row">
						<div class="col s12">
							<div class="card custom_margin_card_table_top">
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
									<form method="post" autocomplete="off" action="<?php echo "?string=" . encrypt('module_id=' . $module_id . '&page=' . $page); ?>">
										<input type="hidden" name="is_Submit" value="Y" />
										<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																							echo encrypt($_SESSION['csrf_session']);
																						} ?>">
										<div class="row">
											<br>
											<div class="input-field col m1 s12 custom_margin_bottom_col">
												<?php
												$field_name     = "flt_po_no";
												$field_label	= "PO#";
												$sql1			= "SELECT DISTINCT po_no FROM purchase_orders WHERE 1=1 ";
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
																<option value="<?php echo $data2['po_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['po_no']) { ?> selected="selected" <?php } ?>><?php echo $data2['po_no']; ?></option>
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
												$field_name     = "flt_vender_id";
												$field_label	= "Vendor";
												$sql1			= " SELECT DISTINCT b.id, b.vender_name, b.vender_no, c.type_name
																	FROM purchase_orders a
																	INNER JOIN venders b ON b.id = a.vender_id
																	INNER JOIN vender_types c ON c.id = b.vender_type
																	WHERE 1=1";
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
																<option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['vender_name']; ?> (<?php echo $data2['type_name']; ?>) </option>
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
											<div class="input-field col m2 s12 custom_margin_bottom_col">
												<?php
												$field_name = "flt_vender_invoice_no";
												$field_label = "Vendor Invoice#";
												$sql1			= "SELECT DISTINCT vender_invoice_no FROM purchase_orders WHERE 1=1 ";
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
																<option value="<?php echo $data2['vender_invoice_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['vender_invoice_no']) { ?> selected="selected" <?php } ?>><?php echo $data2['vender_invoice_no']; ?></option>
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
											<div class="input-field col m1 s12 custom_margin_bottom_col">
												<?php
												$field_name     = "flt_po_status";
												$field_label	= "Status";
												$sql1			= "SELECT *  FROM inventory_status WHERE 1=1 AND id IN(1, 3, 4, 5)  ";
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
																<option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['status_name']; ?></option>
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
												$field_name     = "flt_stage_status";
												$field_label	= "Stage";
												$sql1			= "SELECT *  FROM stages_status WHERE 1=1 AND enabled = 1  ";
												$result1		= $db->query($conn, $sql1);
												$count1         = $db->counter($result1);
												?>
												<i class="material-icons prefix">question_answer</i>
												<div class="select2div">
													<select id="<?= $field_name; ?>" name="<?= $field_name; ?>[]" class="select2 browser-default" multiple="multiple">
														<option value="All" <?php if (isset(${$field_name}) && in_array("All", ${$field_name})) { ?> selected="selected" <?php } ?>>All</option>
														<?php
														if ($count1 > 0) {
															$row1    = $db->fetch($result1);
															foreach ($row1 as $data2) { ?>
																<option value="<?php echo $data2['status_name']; ?>" <?php if (isset(${$field_name}) && in_array($data2['status_name'], ${$field_name})) { ?> selected="selected" <?php } ?>><?php echo $data2['status_name']; ?></option>
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
											<div class="input-field col m2 s12">
												<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange " type="submit" name="action">Search</button> &nbsp;&nbsp;
												<a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=listing") ?>">All</a>
											</div>
										</div>
									</form>
									<div class="row">
										<div class="text_align_right">
											<?php
											$table_columns	= array('SNo', 'PONo', 'PO Date', 'To Be', 'Vendor / InvoiceNo / OfferID', 'Category Wise Qty', 'Tracking / Pro No', 'Actions');
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
											<table id="page-length-option" class="display pagelength50 custom_font_size_table">
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
													if ($count_cl > 0) {
														$row_cl = $db->fetch($result_cl);
														foreach ($row_cl as $data) {
															$id 				= $data['po_id_master'];
															$sql2				= "	SELECT a.*, status_name
																					FROM purchase_order_detail_logistics a
 																					LEFT JOIN inventory_status b ON b.id = a.logistics_status
																					WHERE a.po_id = '" . $id . "'";
															$result2			= $db->query($conn, $sql2);
															// for ($m = 0; $m < 200; $m++) { 
													?>
															<tr>
																<td style="text-align: center;" class="col-<?= set_table_headings($table_columns[0]); ?>"><?php echo $i + 1; ?></td>
																<td class="col-<?= set_table_headings($table_columns[1]); ?>">
																	<?php

																	$activ_tab = "";
																	if (access("add_perm") == 1) {
																		$activ_tab = "tab1";
																	} else if (po_permisions("Vendor Data")) {
																		$activ_tab = "tab4";
																	} else if (po_permisions("Logistics")) {
																		$activ_tab = "tab2";
																	} else if (po_permisions("Arrival")) {
																		$activ_tab = "tab3";
																	} else if (po_permisions("Receive")) {
																		$activ_tab = "tab6";
																	} else if (po_permisions("Diagnostic")) {
																		$activ_tab = "tab6";
																	} else if (po_permisions("RMA")) {
																		$activ_tab = "tab7";
																	} else if (po_permisions("PriceSetup")) {
																		$activ_tab = "tab8";
																	}
																	if ($data['order_enabled'] == 1 && $activ_tab != "") { ?>
																		<a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=edit&id=" . $id . "&active_tab=" . $activ_tab) ?>">
																			<?php echo $data['po_no']; ?>
																		</a>
																	<?php } else {
																		echo $data['po_no'];
																	} ?>
																	<span class="chip green lighten-5">
																		<span class="green-text">
																			<?php
																			echo $data['po_status_name'];

																			///*
																			/////////////////////////////////////////////////////////
																			/////////////////////////////////////////////////////////
																			$total_logistics = 0;
																			$sql2               = " SELECT ifnull(sum(a.no_of_boxes), 0) as total_no_of_boxes
																									FROM purchase_order_detail_logistics a
																									WHERE a.po_id = '" . $id . "'";
																			$result_logistics1  = $db->query($conn, $sql2);
																			$ct_logistics       = $db->counter($result_logistics1);
																			if ($ct_logistics > 0) {
																				$row_logistics1     = $db->fetch($result_logistics1);
																				$total_logistics    = $row_logistics1[0]['total_no_of_boxes'];
																			}

																			$total_arrived = 0;
																			$sql2               = " SELECT ifnull(sum(a.no_of_box_arried), 0) as total_no_of_box_arried
																									FROM purchase_order_detail_logistics_receiving a
																									WHERE a.po_id = '" . $id . "'";
																			$result_logistics1  = $db->query($conn, $sql2);
																			$ct_logistics       = $db->counter($result_logistics1);
																			if ($ct_logistics > 0) {
																				$row_logistics1     = $db->fetch($result_logistics1);
																				$total_arrived      = $row_logistics1[0]['total_no_of_box_arried'];
																			}

																			if ($data['order_status'] == $arrival_status_dynamic) {
																				if ($total_logistics > 0 && $total_arrived > 0) {
																					$total_arrival_percentage = ($total_arrived / $total_logistics) * 100;
																					if ($total_arrival_percentage > 0) {
																						if ($total_arrival_percentage == 100) {
																							echo " <span class='color-green'>(" . round(($total_arrival_percentage)) . "%)</span>";
																						} else if ($total_arrival_percentage < 100) {
																							echo " <span class='color-yellow'>(" . round(($total_arrival_percentage)) . "%)</span>";
																			?>
																							<i class="material-icons dp48">warning</i>
																						<?php
																						} else if ($total_arrival_percentage > 100) {
																							echo " <span class='color-red'>(" . round(($total_arrival_percentage)) . "%)</span>";
																						}
																					}
																				}
																			}
																			/////////////////////////////////////////////////////////
																			/////////////////////////////////////////////////////////
																			$total_items_ordered = 0;
																			$sql2       = " SELECT sum(a.order_qty) as order_qty
																							FROM purchase_order_detail a
																							WHERE a.po_id = '" . $id . "'
																							AND a.enabled = 1 ";
																			$result_r2    = $db->query($conn, $sql2);
																			$count2     = $db->counter($result_r2);
																			if ($count2 > 0) {
																				$row_lg2                = $db->fetch($result_r2);
																				$total_items_ordered    = $row_lg2[0]['order_qty'];
																			}
																			$sql3               = " SELECT a.id
																									FROM purchase_order_detail_receive a
 																									WHERE a.po_id = '" . $id . "'
																									AND a.enabled = 1 ";
																			$result3            = $db->query($conn, $sql3);
																			$total_received     = $db->counter($result3);
																			if ($data['order_status'] == $receive_status_dynamic) {
																				if ($total_items_ordered > 0 && $total_received > 0) {
																					$total_received_percentage = ($total_received / $total_items_ordered) * 100;
																					if ($total_received_percentage > 0) {
																						if ($total_received_percentage == '100') {
																							echo " <span class='color-green'>(" . round(($total_received_percentage)) . "%)</span>";
																						} else if ($total_received_percentage < '100') {
																							echo " <span class='color-yellow'>(" . round(($total_received_percentage)) . "%)</span>";
																						?>
																							<i class="material-icons dp48 color-yellow">warning</i>
																							<?php
																						} else if ($total_received_percentage > '100') {
																							echo " <span class='color-red'>(" . round(($total_received_percentage)) . "%)</span>";
																						}
																					}
																				}
																			}
																			if ($data['order_status'] == $diagnost_status_dynamic) {
																				$sql3               = "SELECT a.id
																										FROM purchase_order_detail_receive a
 																										WHERE a.po_id = '" . $id . "'
																										AND a.serial_no_barcode IS NOT NULL
																										AND a.serial_no_barcode !=''
																										AND a.is_diagnost = 1
																										AND a.enabled = 1 ";
																				$result3            = $db->query($conn, $sql3);
																				$total_diagnosed    = $db->counter($result3);
																				if ($total_received > 0) {
																					if ($total_diagnosed > 0) {
																						$total_diagnosed_percentage = ($total_diagnosed / $total_received) * 100;
																						if ($total_received > 0) {
																							if ($total_diagnosed_percentage == '100') {
																								echo " <span class='color-green'>(" . round(($total_diagnosed_percentage)) . "%)</span>";
																							} else if ($total_diagnosed_percentage < '100') {
																								echo " <span class='color-yellow'>(" . round(($total_diagnosed_percentage)) . "%)</span>";
																							?>
																								<i class="material-icons dp48 color-yellow">warning</i>
																							<?php
																							} else if ($total_diagnosed_percentage > '100') {
																								echo " <span class='color-red'>(" . round(($total_diagnosed_percentage)) . "%)</span>";
																							}
																						}
																					}
																				}
																			}
																			if ($data['order_status'] == $inventory_status_dynamic) {
																				$sql3               = " SELECT a.id
																										FROM product_stock a
																										INNER JOIN purchase_order_detail_receive b ON b.id = a.receive_id
																										INNER JOIN purchase_order_detail c ON c.id = b.po_detail_id 
																										WHERE c.po_id = '" . $id . "'
 																										AND a.enabled = 1 AND b.enabled = 1 ";
																				$result3            = $db->query($conn, $sql3);
																				$total_inventory    = $db->counter($result3);
																				if ($total_received > 0 && $total_inventory > 0) {
																					$total_inventory_percentage = ($total_inventory / $total_received) * 100;
																					if ($total_inventory_percentage > 0) {
																						if ($total_inventory_percentage == '100') {
																							echo " <span class='color-green'>(" . round(($total_inventory_percentage)) . "%)</span>";
																						} else if ($total_inventory_percentage < '100') {
																							echo " <span class='color-yellow'>(" . round(($total_inventory_percentage)) . "%)</span>";
																							?>
																							<i class="material-icons dp48 color-yellow">warning</i>
																			<?php
																						} else if ($total_inventory_percentage > '100') {
																							echo " <span class='color-red'>(" . round(($total_inventory_percentage)) . "%)</span>";
																						}
																					}
																				}
																			}
																			//*/ 

																			?>
																		</span>
																	</span>
																	<span class="chip blue lighten-5">
																		<span class="blue-text">
																			<?php echo "" . $data['stage_status']; ?>
																		</span>
																	</span>
																</td>
																<td class="col-<?= set_table_headings($table_columns[2]); ?>"> <?php echo dateformat2($data['po_date']); ?></td>
																<td class="col-<?= set_table_headings($table_columns[3]); ?>">
																	<?php
																	if ($data['is_tested_po'] == 'Yes') {
																		echo "<b>Tested";
																		// echo "<b>Tested, </b>";
																	}

																	// if ($data['is_wiped_po'] == 'Yes') {
																	// 	echo "<b>Wiped, </b>";
																	// }
																	// if ($data['is_imaged_po'] == 'Yes') {
																	// 	echo "<b>Imaged</b>";
																	// } 
																	?>
																</td>
																<td class="col-<?= set_table_headings($table_columns[4]); ?>">
																	<b>Vender: </b><?php echo $data['vender_name']; ?></br>
																	<b>Invoice#: </b><?php echo $data['vender_invoice_no']; ?></br>
																	<?php if ($data['offer_no'] != '') echo "<b>Offer#: </b>" . $data['offer_no']; ?>
																</td>
																<td class="col-<?= set_table_headings($table_columns[5]); ?>">
																	<?php
																	$sql3		= " SELECT   d.category_name, sum(aa2.order_qty) as order_qty
																					FROM  purchase_order_detail aa2 
																					INNER JOIN products b ON b.id = aa2.product_id
																					INNER JOIN product_categories d ON d.id = b.product_category
																					WHERE 1=1 
																					AND aa2.po_id = '" . $id . "' AND aa2.enabled = 1 
																					GROUP BY b.product_category ";
																	$result3	= $db->query($conn, $sql3);
																	$count3		= $db->counter($result3);
																	if ($count3 > 0) {
																		$row3 = $db->fetch($result3);
																		$k = 0;
																		foreach ($row3 as $data3) { ?>
																			<div style="width: 100%;">
																				<div style="width: 80%; display: inline-block; border: 1px solid #eee;"><?php echo $data3['category_name']; ?>: </div>
																				<div style="width: 60px; display: inline-block; border: 1px solid #eee; text-align: center;"><?php echo "" . $data3['order_qty']; ?></div>
																			</div>
																	<?php
																			$k++;
																		}
																	} ?>
																</td>
																<td class="col-<?= set_table_headings($table_columns[6]); ?>">
																	<?php
																	$j = 0;
																	if ($total_logistics > 0) {
																		$row2 = $db->fetch($result2);
																		foreach ($row2 as $data2) {
																			$tracking_no = $data2['tracking_no'];
																			if (po_permisions("Arrival") == 1) { ?>
																				<a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=edit&cmd3=add&active_tab=tab3&id=" . $id . "&detail_id=" . $tracking_no) ?>">
																					<?= $data2['tracking_no']; ?>
																					<span class="chip green lighten-5">
																						<span class="green-text">
																							<?php echo $data2['status_name']; ?>
																						</span>
																					</span>
																				</a><br>
																			<?php
																			} else { ?>
																				<?= $data2['tracking_no']; ?>
																				<span class="chip green lighten-5">
																					<span class="green-text">
																						<?php echo $data2['status_name']; ?>
																					</span>
																				</span>
																				<br>
																	<?php
																			}
																			$j++;
																		}
																	} ?>
																</td>
																<td class="text-align-center col-<?= set_table_headings($table_columns[7]); ?>">
																	<?php
																	if ($data['order_enabled'] == 1 && access("print_perm") == 1) { ?>
																		<a href="components/<?php echo $module_folder; ?>/<?php echo $module; ?>/print_po.php?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&id=" . $id) ?>" target="_blank">
																			<i class="material-icons dp48">print</i>
																		</a>&nbsp;&nbsp;
																		<?php }
																	if ($data['stage_status'] != 'Committed') {
																		if ($data['order_enabled'] == 0 && access("edit_perm") == 1) { ?>
																			<a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=listing&cmd=enabled&id=" . $id) ?>">
																				<i class="material-icons dp48">add</i>
																			</a> &nbsp;&nbsp;
																		<?php } else if ($data['order_enabled'] == 1 && access("delete_perm") == 1) { ?>
																			<a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=listing&cmd=disabled&id=" . $id) ?>" onclick="return confirm('Are you sure, You want to delete this record?')">
																				<i class="material-icons dp48">delete</i>
																			</a> &nbsp;&nbsp;
																	<?php }
																	} ?>
																</td>
															</tr>
													<?php $i++;
															//}
														}
													} ?>
												<tfoot>
													<tr>
														<?php echo $headings; ?>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Multi Select -->
				</div><!-- START RIGHT SIDEBAR NAV -->

				<?php include('sub_files/right_sidebar.php'); ?>
			</div>

			<div class="content-overlay"></div>
		</div>
	</div>
</div>