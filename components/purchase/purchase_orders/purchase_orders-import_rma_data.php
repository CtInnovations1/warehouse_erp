<?php

use Mpdf\Tag\Select;

if (!isset($module)) {
	require_once('../../../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];

$title_heading			= "Import RMA Data";
$button_val				= "Preview";

$po_no = $vender_invoice_no = $vender_name = "";

if (isset($id) && $id > 0) {
	$sql_ee 		= " SELECT a.*, b.vender_name
						FROM purchase_orders a 
						LEFT JOIN venders b ON b.id = a.vender_id
						WHERE a.id = '" . $id . "' ";
	$result_ee		= $db->query($conn, $sql_ee);
	$counter_ee1	= $db->counter($result_ee);
	if ($counter_ee1 > 0) {
		$row_ee				= $db->fetch($result_ee);
		$po_no				= $row_ee[0]['po_no'];
		$vender_invoice_no	= $row_ee[0]['vender_invoice_no'];
		$vender_name		= $row_ee[0]['vender_name'];
	} else {
		$error['msg'] = "No record found";
	}
}
extract($_POST);
foreach ($_POST as $key => $value) {
	if (!is_array($value)) {
		$data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}

$supported_column_titles	= array("record_id", "product_id", "serial_no", "rma_status", "price", "new_value", "repair_type", "sub_location", "tracking_no");
$master_columns				= array("record_id", "product_id", "serial_no", "rma_status", "price", "new_value", "repair_type", "sub_location", "tracking_no");
$duplication_columns 		= array("record_id");
$required_columns 			= array("record_id", "rma_status");

if (isset($is_Submit) && $is_Submit == 'Y') {
	if (isset($excel_data) && $excel_data == "") {
		$error['excel_data']	= "Required";
		$category_name_valid 	= "invalid";
	}
	if (empty($error)) {
		// Split the pasted data by new lines (each line is a row)
		//$excel_data = str_replace("'", '', $excel_data);
		$excel_data = set_replace_string_char($excel_data);
		$rows = explode(PHP_EOL, trim($excel_data));
		// Split each row by tabs or commas (each column in a row)
		$data = array();
		foreach ($rows as $row) {
			$data[] = preg_split('/[\t,]+/', trim($row)); // Split by tab or comma
		}
		// Separate headings (first row) from the data
		$headings = array_shift($data); // Get the first row as headings 

		////////////// validation on missing headings  ///////////////////
		//////////////////////////////////////////////////////////////////
		foreach ($data as $row_v1) {
			if (count($row_v1) > count($headings)) {
				$error['msg'] = "One or more column headings are missing.";
			}
		}
		if (!empty($error)) {
			$error['msg'] .= "<br>Please check Supported column titles.";
		}
		//////////////////////////////////////////////////////////////////

		/// All data cells should have values or add - if no 
		foreach ($data as $row11) {
			foreach ($row11 as $cell_array) {
				if (sizeof($headings) != sizeof($row11)) {
					if (!isset($error['msg'])) {
						$error['msg'] = "Please ensure that all cells contain values, or insert a dash (' - ') for any blank cells.";
					}
				}
			}
		}
	}
}

$master_table	= "purchase_order_detail_receive_rma";
$added 			= 0;
if (isset($is_Submit2) && $is_Submit2 == 'Y') {

	$import_colums_uniq 		= array_unique($import_colums);
	$total_import_column_set 	= count($import_colums_uniq);

	/// Validation on if  All supported heading required 
	// if (sizeof($supported_column_titles) != $total_import_column_set) {
	// 	$error['msg'] = "One or more column headings are missing.";
	// }

	$required_columns_found = array();
	foreach ($import_colums_uniq as $import_colum) {
		if (in_array($import_colum, $required_columns)) {
			$required_columns_found[] = $import_colum;
		}
	}

	foreach ($required_columns as $required_column) {
		if (!in_array($required_column, $import_colums_uniq)) {
			if (isset($error['msg'])) {
				$error['msg'] .= "<br>" . $required_column . " column title is required.";
			} else {
				$error['msg'] = $required_column . " column title is required.";
			}
		}
	}

	// Initialize the new modified array
	$modified_array = array();
	$i 				= 0;
	foreach ($all_data as $value1) {
		$j = 0;
		foreach ($value1 as $key => $data) {
			$k = 0;
			foreach ($import_colums_uniq as $data2) {
				if ($k == $j) {
					$modified_array[$i][$data2] = trim($data);
				}
				$k++;
			}
			$j++;
		}
		$modified_array[$i]["is_insert"] = $data;
		$i++; // increment the index
	}

	$all_data = $modified_array;
	$t = 1;
	if (empty($error)) {
		if (isset($all_data) && sizeof($all_data) > 0) {
			foreach ($all_data  as $data1) {
				$update_master = $columns = $column_data = "";
				if (isset($data1['record_id']) && $data1['record_id'] != '') {
					$receive_id_1		= $data1['record_id'];
					$serial 			= $data1['serial_no'];

					if (isset($receive_id_1) && $receive_id_1 > 0) {
						foreach ($data1 as $key => $data) {
							if (htmlspecialchars($data) == '-' || htmlspecialchars($data) == '' || htmlspecialchars($data) == 'blank') {
								$data = "";
							}
							if ($key != "" && $key != 'is_insert') {

								$insert_db_field_id		= $key;
								${$insert_db_field_id} 	= $data;

								if ($key == 'rma_status') {
									if ($data != '' && $data != NULL && $data != '-' && $data != 'blank') {
										$insert_db_field_id_detail	= "status_id";
										$insert_db_field_id_detai2	= "status_name";
										$table1 					= "inventory_status";

										$sql1		= "SELECT * FROM " . $table1 . " WHERE " . $insert_db_field_id_detai2 . " = '" . $data . "' ";
										$result1	= $db->query($conn, $sql1);
										$count1		= $db->counter($result1);
										if ($count1 > 0) {
											$row1 							= $db->fetch($result1);
											${$insert_db_field_id_detail}	= $row1[0]['id'];
											$update_master .= "`" . $insert_db_field_id_detail . "` = '" . ${$insert_db_field_id_detail} . "', ";
										}
									}
								} else if ($key == 'repair_type') {
									$insert_db_field_id_detail	= "repair_type";
									if ($data1['rma_status'] == 'Repair') {
										if ($data != '' && $data != NULL && $data != '-' && $data != 'blank') {
											$insert_db_field_id_detai2	= "repair_type_name";
											$table1 					= "repair_types";

											$sql1		= "SELECT * FROM " . $table1 . " WHERE " . $insert_db_field_id_detai2 . " = '" . $data . "' ";
											$result1	= $db->query($conn, $sql1);
											$count1		= $db->counter($result1);
											if ($count1 > 0) {
												$row1 							= $db->fetch($result1);
												${$insert_db_field_id_detail}	= $row1[0]['id'];
												$update_master .= "`" . $key . "` = '" . ${$insert_db_field_id_detail} . "', ";
											} else {
												$sql6 = "INSERT INTO " . $selected_db_name . "." . $table1 . "(subscriber_users_id, " . $insert_db_field_id_detai2 . ", add_date, add_by, add_ip, add_timezone, added_from_module_id)
														VALUES('" . $subscriber_users_id . "', '" . $data . "', '" . $add_date . "', '" . $_SESSION['username'] . " Imported', '" . $add_ip . "', '" . $timezone . "', '" . $module_id . "')";
												$ok = $db->query($conn, $sql6);
												if ($ok) {
													${$insert_db_field_id_detail} = mysqli_insert_id($conn);
													$update_master .= "`" . $key . "` = '" . ${$insert_db_field_id_detail} . "', ";
												}
											}
										} else {
											$update_master .= "`" . $insert_db_field_id_detail . "` = '', ";
										}
									} else {
										$update_master .= "`" . $insert_db_field_id_detail . "` = '', ";
									}
								} else if ($key == 'sub_location') {
									$insert_db_field_id_detail	= "sub_location_id";
									if ($data != '' && $data != NULL && $data != '-' && $data != 'blank') {
										if ($data1['rma_status'] == 'Repair' || $data1['rma_status'] == 'Partial Refund') {
											${$insert_db_field_id_detail}	= 0;
											$field 			= "sub_location_name";
											$table 			= "warehouse_sub_locations";

											$sql1 			= "SELECT * FROM " . $table . " WHERE " . $field . " = '" . $data . "' ";
											$result1 		= $db->query($conn, $sql1);
											$count1 		= $db->counter($result1);
											if ($count1 > 0) {
												$row1 							= $db->fetch($result1);
												${$insert_db_field_id_detail}	= $row1[0]['id'];
											} else {
												$sql6 = "INSERT INTO " . $selected_db_name . "." . $table . "(subscriber_users_id, warehouse_id, " . $field . ", purpose, sub_location_type, add_date, add_by, add_ip, add_timezone, added_from_module_id)
														 VALUES('" . $subscriber_users_id . "', '1', '" . $data . "', 'Repair',  'bin', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "', '" . $timezone . "', '" . $module_id . "')";
												$ok = $db->query($conn, $sql6);
												if ($ok) {
													${$insert_db_field_id_detail}	= mysqli_insert_id($conn);
												}
											}
											$update_master .= "`" . $insert_db_field_id_detail . "` = '" . ${$insert_db_field_id_detail} . "', ";
										} else {
											$update_master .= "`" . $insert_db_field_id_detail . "` = '0', ";
										}
									}
								} else if ($key == 'tracking_no') {
									if ($data1['rma_status'] != 'Repair' && $data1['rma_status'] != 'Partial Refund') {
										if ($data != '' && $data != NULL && $data != '-' && $data != 'blank') {
											$update_master .= "`" . $key . "` = '" . $data . "', ";
										} else {
											$update_master .= "`" . $key . "` = '', ";
										}
									} else {
										$update_master .= "`" . $key . "` = '', ";
									}
								} else if ($key == 'new_value') {
									$insert_db_field_id_detail		= "new_value";
									if ($data1['rma_status'] == 'Repair' || $data1['rma_status'] == 'Partial Refund') {
										if ($data != '' && $data != NULL && $data != '-' && $data != 'blank') {
											${$insert_db_field_id_detail}	= $data;
											$update_master .= "`" . $insert_db_field_id_detail . "` = '" . ${$insert_db_field_id_detail} . "', ";

											$actual_price = $reduced_price = 0;
											$sql_pd1		= "	SELECT a.*, a.price
																FROM purchase_order_detail_receive a
																INNER JOIN product_stock b ON a.id = b.receive_id
																WHERE a.id = '" . $receive_id_1 . "' ";
											$result_pd1		= $db->query($conn, $sql_pd1);
											$count_pd1		= $db->counter($result_pd1);
											if ($count_pd1 > 0) {
												$row_st1 = $db->fetch($result_pd1);
												$actual_price = $row_st1[0]['price'];
											}
											if ($actual_price > $new_value) {
												$reduced_price = $actual_price - $new_value;
												$update_master .= "`reduced_price` = '" . $reduced_price . "', ";
											} else {
												$update_master .= "`reduced_price` = '0', ";
											}
										} else {
											$update_master .= "`" . $insert_db_field_id_detail . "` = '0', ";
										}
									} else {
										$update_master .= "`" . $insert_db_field_id_detail . "` = '0', ";
										$update_master .= "`reduced_price` = '0', ";
									}
								} else if ($insert_db_field_id != 'record_id' && $insert_db_field_id != 'product_id' && $insert_db_field_id != 'serial_no'  && $insert_db_field_id != 'price') {
									$update_master .= "`" . $insert_db_field_id . "` = '" . ${$insert_db_field_id} . "', ";
								}
							}
						}
						if ($update_master != "" && isset($receive_id_1) && $receive_id_1 > 0) {
							$sql6 = " 	UPDATE " . $selected_db_name . "." . $master_table . " SET  " . $update_master . "
 																										update_date 			= '" . $add_date . "', 
																										update_by 				= '" . $_SESSION['username'] . " Imported', 
																										update_by_user_id		= '" . $_SESSION['user_id'] . "',
																										update_ip 				= '" . $add_ip . "', 
																										update_timezone			= '" . $timezone . "', 
																										update_from_module_id	= '" . $module_id . "'
											WHERE receive_id = '" . $receive_id_1 . "' ";
							// echo "<br>" . $sql6;
							$db->query($conn, $sql6);
							$ok = $db->query($conn, $sql6);
							if ($ok) {
								$added++;
							}
						}
					}
				}
			}
		}
	}

	if ($added > 0) {
		if ($added == 1) {
			$msg['msg_success'] = $added . " record has been mapped successfully.";
		} else {
			$msg['msg_success'] = $added . " records have been mapped successfully.";
		}
	} else {
		if (!isset($error['msg'])) {
			$error['msg'] = " No record has been mapped.";
		} else {
			$error['msg'] = "No record has been mapped.<br><br>" . $error['msg'];
		}
	}
}
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
							<div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
								<h6 class="media-heading">
									<?php echo $title_heading; ?>
								</h6>
							</div>
							<div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
								<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=listing") ?>">
									PO List
								</a>
								<a class="btn cyan waves-effect waves-light custom_btn_size" href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=profile&cmd=edit&id=" . $id . "&active_tab=tab7") ?>">
									PO Profile
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m12 l12">
			<div id="Form-advance" class="card card card-default scrollspy custom_margin_card_table_top">
				<div class="card-panel custom_padding_card_content_table_top">
					<div class="row">
						<div class="col s10 m12 l8">
							<h5 class="breadcrumbs mt-0 mb-0"><span>Master Info</span></h5>
						</div>
					</div>
					<?php
					if (isset($id)) {  ?>
						<div class="row">
							<div class="input-field col m3 s12">
								<h6 class="media-heading"><span class=""><?php echo "<b>PO#:</b>" . $po_no; ?></span></h6>
							</div>
							<div class="input-field col m3 s12">
								<h6 class="media-heading"><span class=""><?php echo "<b>Vendor Name: </b>" . $vender_name; ?></span></h6>
							</div>
							<div class="input-field col m3 s12">
								<h6 class="media-heading"><span class=""><?php echo "<b>Vendor Invoice#: </b>" . $vender_invoice_no; ?></span></h6>
							</div>
						</div>
					<?php } ?>
				</div>

				<div class="card-content">
					<h4 class="card-title">Import Excel Data</h4><br>
					<?php
					if (isset($msg['msg_success'])) { ?>
						<div class="card-alert card green lighten-5">
							<div class="card-content green-text">
								<p><?php echo $msg['msg_success']; ?></p>
							</div>
							<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					<?php }
					if (isset($error['msg'])) { ?>
						<div class="card-alert card red lighten-5">
							<div class="card-content red-text">
								<p><?php echo $error['msg']; ?></p>
							</div>
							<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					<?php }
					if ((!isset($excel_data) || (isset($excel_data) && $excel_data == "") || isset($error)) &&  !isset($is_Submit2)) { ?>

						<form method="post" autocomplete="off">
							<input type="hidden" name="is_Submit" value="Y" />
							<div class="row">
								<div class="input-field col m12 s12">
									<?php
									$field_name 	= "excel_data";
									$field_label 	= "Paste Here";
									?>
									<i class="material-icons prefix">description</i>
									<textarea type="text" id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="materialize-textarea excel_data_textarea validate"><?php if (isset(${$field_name})) {
																																											echo ${$field_name};
																																										} ?></textarea>
									<label for="<?= $field_name; ?>">
										<?= $field_label; ?>
										<span class="color-red">* <?php
																	if (isset($error[$field_name])) {
																		echo $error[$field_name];
																	} ?>
										</span>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m4 s12">
									<?php
									if (access("add_perm") == 1) { ?>
										<button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo $button_val; ?>
											<i class="material-icons right">send</i>
										</button>
									<?php } ?>
								</div>
							</div>
						</form>

						<div class="row">
							<div class="col m12 s12">
								<h4 class="card-title">Supported column titles</h4>
								<table class="bordered striped" style="padding: 0px; width: 50%;">
									<tr>
										<td style='padding: 3px 15px  !important; text-align: center; '>Column Name</td>
										<td style='padding: 3px 15px !important; '>Column Heading</td>
										<td style='padding: 3px 15px !important; '>Format</td>
									</tr>
									<?php
									$i = 0;
									$char = 'a';

									foreach ($supported_column_titles as $s_heading) {
										$cell_format = "Text";
										if (strtolower($s_heading) == 'record_id') {
											$cell_format = "Number (Unique)";
										}
										echo " <tr>
													<td style='padding: 3px 15px !important; text-align: center; '>" . strtoupper($char) . "</td>
													<td style='padding: 3px 15px !important; '>" . $s_heading . "</td>
													<td style='padding: 3px 15px !important; '>" . $cell_format . "</td>
												</tr>";
										$i++;
										$char++;
									} ?>
								</table>
							</div>
						</div>
						<?php
					} else if (isset($headings) && sizeof($headings) > "0") {
						if ((isset($excel_data) && $excel_data != "" && !isset($error)) || isset($is_Submit2)) { ?>
							<div class="row">
								<div class="col m6 s12">
									Summary
									<table class="bordered striped">
										<tbody>
											<tr>
												<td style="padding: 3px 15px !important">S.No</td>
												<td style="padding: 3px 15px !important">Column Name</td>
												<td style="padding: 3px 15px !important">Column Value</td>
												<td style="padding: 3px 15px !important">Status</td>
											</tr>
											<?php
											foreach ($data as $row_c1) {
												$col_c1_no =  0;
												foreach ($row_c1 as $cell_c1) {
													if (!isset($headings[$col_c1_no])) {
														$headings[$col_c1_no] = "";
													}
													$column_name_c1 = $headings[$col_c1_no];
													$column_name_c1_org = $column_name_c1;

													if ($column_name_c1 == 'rma_status') {
														$db_name_c1 = 'status_name';
														$sql_dup	= " SELECT * FROM inventory_status WHERE " . $db_name_c1 . "	= '" . htmlspecialchars($cell_c1) . "' ";
														$result_dup	= $db->query($conn, $sql_dup);
														$count_dup	= $db->counter($result_dup);
														if ($count_dup == 0 && $cell_c1 != '-') {
															${$column_name_c1_org . "_array"}[] = $cell_c1;
														}
													}

													if ($column_name_c1 == 'repair_type') {
														$db_name_c1 = 'repair_type_name';
														$sql_dup	= " SELECT * FROM repair_types WHERE " . $db_name_c1 . "	= '" . htmlspecialchars($cell_c1) . "' ";
														$result_dup	= $db->query($conn, $sql_dup);
														$count_dup	= $db->counter($result_dup);
														if ($count_dup == 0 && $cell_c1 != '-') {
															${$column_name_c1_org . "_array"}[] = $cell_c1;
														}
													}

													if ($column_name_c1 == 'sub_location') {
														$db_name_c1 = 'sub_location_name';
														$sql_dup	= " SELECT * FROM warehouse_sub_locations WHERE " . $db_name_c1 . "	= '" . htmlspecialchars($cell_c1) . "' ";
														$result_dup	= $db->query($conn, $sql_dup);
														$count_dup	= $db->counter($result_dup);
														if ($count_dup == 0 && $cell_c1 != '-') {
															${$column_name_c1_org . "_array"}[] = $cell_c1;
														}
													}

													$col_c1_no++;
												}
											}
											foreach ($headings as $heading_c1) {
												if (isset(${$heading_c1 . "_array"})) {
													$does_not_exist_unique = array_unique(${$heading_c1 . "_array"});
													sort($does_not_exist_unique); // Sort the array before looping
													$j = 0;
													foreach ($does_not_exist_unique as $data_1) {
														$j++; ?>
														<tr>
															<td style="padding: 3px 15px !important"><b><?php echo $j; ?></b></td>
															<td style="padding: 3px 15px !important"><b><?php echo $heading_c1; ?></b></td>
															<td style="padding: 3px 15px !important"><?php echo $data_1; ?></td>
															<td style="padding: 3px 15px !important" class="color-green">Creates</td>
														</tr>
											<?php }
												}
											} ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col m12 s12"><br></div>
							</div>
							<h4 class="card-title">Data to be imported</h4><br>
							<form method="post" autocomplete="off">
								<input type="hidden" name="is_Submit2" value="Y" />
								<input type="hidden" name="excel_data" value="<?php if (isset($excel_data)) {
																					echo $excel_data;
																				} ?>" />
								<div class="row">
									<div class="col m12 s12">
										<table class="bordered striped">
											<thead>
												<tr>
													<?php
													$m = 0;
													foreach ($headings as $heading) {
														$m++; ?>
														<th>
															<?php
															$field_name = "import_colums[]";
															?>
															<div class="width_heading_table_custom_col">
																<select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="  validate">
																	<option value="">Unassigned</option>
																	<?php
																	foreach ($supported_column_titles as $heading_main) {  ?>
																		<option value="<?php echo $heading_main; ?>" <?php if (isset($heading) && $heading == $heading_main) { ?> selected="selected" <?php } ?>><?php echo $heading_main; ?></option>
																	<?php } ?>
																</select>
															</div>
														</th>
													<?php } ?>
													<th></th>
												</tr>
												<tr>
													<?php
													foreach ($headings as $heading) {
														$row_color 	= "";
														if (!in_array($heading, $supported_column_titles)) {
															$row_color 	= "color-red";
														}
														echo "<th class='" . $row_color . "'> " . htmlspecialchars($heading) . "</th>";
													} ?>
													<th>Import Status</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$row_no = 0;
												foreach ($data as $row) {
													echo "<tr>";
													$row_error_status = "";
													$col_no 	= $is_error = 0;
													$is_insert	= "Yes";
													$row_color	= "color-green";
													foreach ($row as $cell) {

														$db_column 			= $headings[$col_no];
														$db_column_excel	= $db_column;


														if (!in_array($db_column_excel, $supported_column_titles)) {
															$row_color 	= "color-red";
															$is_error 	= 1;
															$is_insert 	= "No";
														}
														if (in_array($db_column_excel, $duplication_columns)) {

															if ($db_column == 'serial') {
																$db_column = "serial_no_barcode";
															}
															$row_color = "color-green"; ?>
															<input type="hidden" name="all_data[<?= $row_no; ?>][<?= $db_column_excel; ?>]" value="<?= $cell; ?>">
														<?php
														} else {
															$row_color = "color-green";  ?>
															<input type="hidden" name="all_data[<?= $row_no; ?>][<?= $db_column_excel; ?>]" value="<?= $cell; ?>">
													<?php
														}
														echo "<td class='" . $row_color . "'>" . htmlspecialchars($cell) . "</td>";
														$col_no++;
													} ?>
													<input type="hidden" name="all_data[<?= $row_no; ?>][is_insert]" value="<?= $is_insert; ?>">
												<?php
													if ($is_error == 1) {
														$row_color = "color-red";
													} else {
														$row_error_status = "Creates";
													}
													echo "<td class='" . $row_color . "'>" . $row_error_status . "</td>";
													echo "</tr>";
													$row_no++;
												} ?>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col m2 s12">&nbsp;</div>
								</div>
								<div class="row">
									<div class="col m2 s12">&nbsp;</div>
									<div class="col m2 s12">
										<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Start Import
											<i class="material-icons right">send</i>
										</button>
									</div>
									<div class="col m2 s12">
										<a href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=" . $page . "&id=" . $id) ?>" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
											<i class="material-icons left">send</i>
										</a>
									</div>
									<div class="col m4 s12">&nbsp;</div>
								</div>
							</form>
						<?php
						} else { ?>
							<div class="row">
								<div class="col m2 s12">&nbsp;</div>
								<div class="col m2 s12">
									<a href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=" . $page . "&id=" . $id) ?>" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
										<i class="material-icons left">send</i>
									</a>
								</div>
								<div class="col m4 s12">&nbsp;</div>
							</div>
						<?php }
					} else { ?>
						<div class="row">
							<div class="col m2 s12">&nbsp;</div>
							<div class="col m2 s12">
								<a href="?string=<?php echo encrypt("module_id=" . $module_id . "&page=" . $page . "&id=" . $id) ?>" class="waves-effect waves-light btn modal-trigger mb-2 mr-1" type="submit" name="action">Copy New
									<i class="material-icons left">send</i>
								</a>
							</div>
							<div class="col m4 s12">&nbsp;</div>
						</div>
					<?php } ?>
				</div>
				<?php
				//include('sub_files/right_sidebar.php');
				?>
			</div>
		</div>
	</div>
</div><br><br><br><br>
<!-- END: Page Main-->