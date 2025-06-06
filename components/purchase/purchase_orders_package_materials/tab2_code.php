<?php

if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP) {
	$tracking_no	= date('YmdHis');
	$status_id		= 10;
	$logistics_cost	= "50.0";
	$box_no			= 1;
	$box_qty		= 10;

	$sql_ee1 = "SELECT id
				FROM package_materials_order_detail b 
				WHERE b.po_id = '" . $id . "'
				LIMIT 1";
	$result_ee1 	= $db->query($conn, $sql_ee1);
	$counter_ee1	= $db->counter($result_ee1);
	if ($counter_ee1 > 0) {
		$row_ee1111				= $db->fetch($result_ee1);
		$package_id_logistic	= $row_ee1111[0]['id'];
	}
}
if (isset($cmd2_1) && $cmd2_1 == 'edit' && isset($detail_id)) {
	$sql_ee1 = "SELECT b.*, d.logistics_cost
				FROM package_materials_order_detail_logistics b 
				INNER JOIN package_materials_orders d ON d.id = b.po_id
				WHERE b.id = '" . $detail_id . "'";
	// echo $sql_ee1;
	$result_ee1 	= $db->query($conn, $sql_ee1);
	$counter_ee1	= $db->counter($result_ee1);
	if ($counter_ee1 > 0) {
		$row_ee1 						= $db->fetch($result_ee1);
		$courier_name_update			= $row_ee1[0]['courier_name'];
		$package_id_logistic_update		= $row_ee1[0]['po_detail_id'];
		$tracking_no_update             = $row_ee1[0]['tracking_no'];
		$shipment_date_update			= $row_ee1[0]['shipment_date'];
		$shipment_date_update			= str_replace("-", "/", convert_date_display($row_ee1[0]['shipment_date']));
		$expected_arrival_date_update	= str_replace("-", "/", convert_date_display($row_ee1[0]['expected_arrival_date']));
		$status_id_update				= $row_ee1[0]['logistics_status'];
		$logistics_cost_update			= $row_ee1[0]['logistics_cost'];
		$box_no_update					= $row_ee1[0]['box_no'];
		$box_qty_update					= $row_ee1[0]['box_qty'];
	} else {
		$error4['msg'] = "No record found";
	}
}
if (isset($cmd2_1) && $cmd2_1 == 'delete' && isset($detail_id)) {
	if (po_permisions("Pkg_Logistics") == 0) {
		$error2['msg'] = "You do not have add permissions.";
	} else {
		$sql_ee1 = " DELETE FROM package_materials_order_detail_logistics WHERE id = '" . $detail_id . "'";
		$ok = $db->query($conn, $sql_ee1);
		if ($ok) {
			$sql_ee1 = " SELECT b.* FROM package_materials_order_detail_logistics b WHERE b.po_id = '" . $id . "'";
			// echo $sql_ee1;
			$result_ee1 	= $db->query($conn, $sql_ee1);
			$counter_ee1	= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql_c_up = "UPDATE  package_materials_order_detail
												SET 	
													order_product_status	= '" . $before_logistic_status_dynamic . "',
													
					
													update_timezone			= '" . $timezone . "',
													update_date				= '" . $add_date . "',
													update_by				= '" . $_SESSION['username'] . "',
													update_by_user_id		= '" . $_SESSION['user_id'] . "',
													update_ip				= '" . $add_ip . "',
													update_from_module_id	= '" . $module_id . "'
						WHERE po_id = '" . $id . "' ";
				$db->query($conn, $sql_c_up);

				$sql_c_up = "UPDATE  package_materials_orders
												SET 	
													order_status		= '" . $before_logistic_status_dynamic . "',
					
													update_timezone			= '" . $timezone . "',
													update_date				= '" . $add_date . "',
													update_by				= '" . $_SESSION['username'] . "',
													update_by_user_id		= '" . $_SESSION['user_id'] . "',
													update_ip				= '" . $add_ip . "',
													update_from_module_id	= '" . $module_id . "'
						WHERE id = '" . $id . "' ";
				$db->query($conn, $sql_c_up);
				$order_status 		= $before_logistic_status_dynamic;
				$disp_status_name 	= get_status_name($db, $conn, $before_logistic_status_dynamic);
				$table				= "inventory_status";
				$columns			= array("status_name");
				$get_col_from_table = get_col_from_table($db, $conn, $selected_db_name, $table, $before_logistic_status_dynamic, $columns);
				foreach ($get_col_from_table as $array_key1 => $array_data1) {
					${$array_key1} = $array_data1;
				}
			}
			$msg3['msg_success'] = "Record has been deleted successfully.";
		}
	}
}

if (isset($_POST['is_Submit_tab2']) && $_POST['is_Submit_tab2'] == 'Y') {
	extract($_POST);
	$field_name = "box_no";
	if (!isset(${$field_name}) || (isset(${$field_name})  && (${$field_name} == "0" || ${$field_name} == ""))) {
		$error2[$field_name] = "Required";
	} else {
		$sql_dup	= " SELECT a.* FROM package_materials_order_detail_logistics a  
						WHERE a.box_no 		= '" . $box_no . "'
						AND a.po_id 		= '" . $id . "'
						AND a.po_detail_id 	= '" . $package_id_logistic . "' ";
		$result_dup	= $db->query($conn, $sql_dup);
		$count_dup	= $db->counter($result_dup);
		if ($count_dup > 0) {
			$error2[$field_name] 	= "Exist";
		}
	}
	$field_name = "box_qty";
	if (!isset(${$field_name}) || (isset(${$field_name})  && (${$field_name} == "0" || ${$field_name} == ""))) {
		$error2[$field_name] = "Required";
	}
	$field_name = "status_id";
	if (!isset(${$field_name}) || (isset(${$field_name})  && (${$field_name} == "0" || ${$field_name} == ""))) {
		$error2[$field_name] = "Required";
	}
	if (isset($logistics_cost)  && ($logistics_cost == "")) {
		$logistics_cost = "0";
	}
	$field_name = "tracking_no";
	if (isset(${$field_name}) && ${$field_name} == "") {
		$error2[$field_name] = "Required";
	}
	if (isset($shipment_date) && $shipment_date == "") {
		$shipment_date1 = NULL;
	} else {
		$shipment_date1 = convert_date_mysql_slash($shipment_date);
	}
	if (isset($expected_arrival_date) && $expected_arrival_date == "") {
		$expected_arrival_date1 = NULL;
	} else {
		$expected_arrival_date1 = convert_date_mysql_slash($expected_arrival_date);
	}
	if (!isset($id) || (isset($id)  && ($id == "0" || $id == ""))) {
		$error2['msg'] = "Please add master record first";
	}
	if (!isset($status_id) || (isset($status_id)  && ($status_id == "0" || $status_id == ""))) {
		$error2['status_id'] = "Required";
	}
	if (!isset($package_id_logistic) || (isset($package_id_logistic)  && ($package_id_logistic == "0" || $package_id_logistic == ""))) {
		$error2['package_id_logistic'] = "Required";
	}
	if (empty($error2)) {
		if (po_permisions("Pkg_Logistics") == 0) {
			$error2['msg'] = "You do not have add permissions.";
		} else {
			$k = 0;
			if (access("add_perm") == 0) {
				$error2['msg'] = "You do not have add permissions.";
			} else {
				$sql6 = "INSERT INTO package_materials_order_detail_logistics(po_id, po_detail_id, courier_name, tracking_no, shipment_date, expected_arrival_date, logistics_status, box_no, box_qty, 
																																			add_date, add_by, add_ip, add_timezone, added_from_module_id)
						 VALUES('" . $id . "', '" . $package_id_logistic . "', '" . $courier_name . "', '" . $tracking_no . "', '"  . $shipment_date1  . "', '" . $expected_arrival_date1  . "', '" . $status_id  . "', '" . $box_no  . "', '" . $box_qty  . "', 
						 																														'" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "', '" . $timezone . "', '" . $module_id . "')";
				$ok = $db->query($conn, $sql6);
				if ($ok) {
					$tracking_no = "";
					$box_no++;
					$sql_c_up = "UPDATE  package_materials_order_detail SET order_product_status	= '" . $status_id . "',
 
																			update_timezone			= '" . $timezone . "',
																			update_date				= '" . $add_date . "',
																			update_by				= '" . $_SESSION['username'] . "',
																			update_by_user_id		= '" . $_SESSION['user_id'] . "',
																			update_ip				= '" . $add_ip . "',
																			update_from_module_id	= '" . $module_id . "'
								WHERE id = '" . $package_id_logistic . "' ";
					$db->query($conn, $sql_c_up);
					$k++;
					if (isset($error2['msg'])) unset($error2['msg']);
				} else {
					$error2['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			}
			if ($k > 0) {
				$disp_status_name 	= get_status_name($db, $conn, $logistic_status_dynamic);
				$sql_c_up = "UPDATE  package_materials_orders SET 	 
																	order_status			= '" . $logistic_status_dynamic . "',
																	logistics_cost			= '" . $logistics_cost . "',

																	update_timezone			= '" . $timezone . "',
																	update_date				= '" . $add_date . "',
																	update_by				= '" . $_SESSION['username'] . "',
																	update_by_user_id		= '" . $_SESSION['user_id'] . "',
																	update_ip				= '" . $add_ip . "',
																	update_from_module_id	= '" . $module_id . "'
						WHERE id = '" . $id . "' ";
				$db->query($conn, $sql_c_up);
				if (isset($msg3['msg_success'])) {
					$msg3['msg_success'] .= "<br>Logistics info has been added successfully.";
				} else {
					$msg3['msg_success'] = "Logistics info has been added successfully.";
				}
				if ($_SERVER['HTTP_HOST'] != HTTP_HOST_IP) {
					$tracking_no = "";
				}
				if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP) {
					$tracking_no = date('YmdHis');
				}
			}
		}
	} else {
		$error2['msg'] = "Please check Error in form.";
	}
}

if (isset($_POST['is_Submit_tab2_1']) && $_POST['is_Submit_tab2_1'] == 'Y') {
	extract($_POST);
	if (!isset($box_no_update) || (isset($box_no_update)  && ($box_no_update == "0" || $box_no_update == ""))) {
		$error2['box_no_update'] = "Required";
	} else {
		$sql_dup 	= " SELECT a.* FROM package_materials_order_detail_logistics a  
						WHERE  a.box_no = '" . $box_no_update . "' 
						AND a.po_detail_id = '" . $package_id_logistic_update . "' 
						AND id != '" . $detail_id . "' "; //echo $sql_dup;
		$result_dup	= $db->query($conn, $sql_dup);
		$count_dup	= $db->counter($result_dup);
		if ($count_dup > 0) {
			$error2['box_no_update'] = "Exist";
		}
	}
	if (!isset($box_qty_update) || (isset($box_qty_update)  && ($box_qty_update == "0" || $box_qty_update == ""))) {
		$error2['box_qty_update'] = "Required";
	}
	if (isset($logistics_cost_update)  && ($logistics_cost_update == "")) {
		$logistics_cost_update = "0";
	}
	if (!isset($status_id_update) || (isset($status_id_update)  && ($status_id_update == "0" || $status_id_update == ""))) {
		$error2['status_id_update'] = "Required";
	}
	if (isset($tracking_no_update) && $tracking_no_update == "") {
		$error2['tracking_no_update'] = "Required";
	}
	if (isset($shipment_date_update) && $shipment_date_update == "") {
		$shipment_date_update1	= NULL;
	} else {
		$shipment_date_update1 = convert_date_mysql_slash($shipment_date_update);
	}
	if (isset($expected_arrival_date_update) && $expected_arrival_date_update == "") {
		$expected_arrival_date_update1	= NULL;
	} else {
		$expected_arrival_date_update1 = convert_date_mysql_slash($expected_arrival_date_update);
	}
	if (!isset($id) || (isset($id)  && ($id == "0" || $id == ""))) {
		$error2['msg'] = "Please add master record first";
	}
	if (!isset($detail_id) || (isset($detail_id)  && ($detail_id == "0" || $detail_id == ""))) {
		$error2['msg'] = "Please click to edit anyone record";
	}
	if (empty($error2)) {
		if (po_permisions("Pkg_Logistics") == 0) {
			$error2['msg'] = "You do not have add permissions.";
		} else {
			$sql_c_up = "UPDATE  package_materials_order_detail_logistics 
										SET 
											courier_name 			= '" . $courier_name_update . "',
											tracking_no 			= '" . $tracking_no_update . "',
											shipment_date 			= '" . $shipment_date_update1 . "',
											expected_arrival_date 	= '" . $expected_arrival_date_update1 . "',
											logistics_status		= '" . $status_id_update . "',
											logistics_cost			= '" . $logistics_cost_update . "',
											box_no					= '" . $box_no_update . "',
											box_qty					= '" . $box_qty_update . "',
											
											update_timezone			= '" . $timezone . "',
											update_date				= '" . $add_date . "',
											update_by				= '" . $_SESSION['username'] . "',
											update_by_user_id		= '" . $_SESSION['user_id'] . "',
											update_ip				= '" . $add_ip . "',
											update_from_module_id	= '" . $module_id . "'
						WHERE id = '" . $detail_id . "' ";
			$ok = $db->query($conn, $sql_c_up);
			if ($ok) {

				$sql_c_up = "UPDATE  package_materials_orders
											SET 	
												logistics_cost			= '" . $logistics_cost_update . "',

												update_timezone			= '" . $timezone . "',
												update_date				= '" . $add_date . "',
												update_by				= '" . $_SESSION['username'] . "',
												update_by_user_id		= '" . $_SESSION['user_id'] . "',
												update_ip				= '" . $add_ip . "',
												update_from_module_id	= '" . $module_id . "'
							WHERE id = '" . $id . "' ";
				$db->query($conn, $sql_c_up);

				$sql_ee1 = " SELECT b.* FROM package_materials_order_detail_logistics b WHERE b.po_id = '" . $id . "'";
				// echo $sql_ee1;
				$result_ee1 	= $db->query($conn, $sql_ee1);
				$counter_ee1	= $db->counter($result_ee1);
				if ($counter_ee1 == 0) {
					$sql_c_up = "UPDATE  package_materials_order_detail
											SET 	
												order_product_status	= '" . $logistic_status_dynamic . "',

												update_timezone			= '" . $timezone . "',
												update_date				= '" . $add_date . "',
												update_by				= '" . $_SESSION['username'] . "',
												update_by_user_id		= '" . $_SESSION['user_id'] . "',
												update_ip				= '" . $add_ip . "',
												update_from_module_id	= '" . $module_id . "'
					WHERE po_id = '" . $id . "' ";
					$db->query($conn, $sql_c_up);

					$sql_c_up = "UPDATE  package_materials_orders
											SET 	
												order_status		= '" . $logistic_status_dynamic . "',

												update_timezone			= '" . $timezone . "',
												update_date				= '" . $add_date . "',
												update_by				= '" . $_SESSION['username'] . "',
												update_by_user_id		= '" . $_SESSION['user_id'] . "',
												update_ip				= '" . $add_ip . "',
												update_from_module_id	= '" . $module_id . "'
					WHERE id = '" . $id . "' ";
					$db->query($conn, $sql_c_up);

					$disp_status_name 	= get_status_name($db, $conn, $logistic_status_dynamic);
					$table		= "inventory_status";
					$columns	= array("status_name");
					$get_col_from_table = get_col_from_table($db, $conn, $selected_db_name, $table, $before_logistic_status_dynamic, $columns);
					foreach ($get_col_from_table as $array_key1 => $array_data1) {
						${$array_key1} = $array_data1;
					}
				}
				$msg3['msg_success'] = "Record has been updated successfully.";
			} else {
				$error2['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
			}
		}
	} else {
		$error2['msg'] = "Please check the error in form.";
	}
}
if (isset($_POST['is_Submit_tab2_3']) && $_POST['is_Submit_tab2_3'] == 'Y') {
	extract($_POST);
	if (!isset($logistics_status) || (isset($logistics_status)  && ($logistics_status == "0" || $logistics_status == ""))) {
		$error2['logistics_status'] = "Required";
	}
	if (empty($error2)) {
		if (po_permisions("Pkg_Logistics") == 0) {
			$error2['msg'] = "You do not have add permissions.";
		} else {
			if (isset($logistics_ids) && sizeof($logistics_ids) > 0) {
				$k = 0;
				foreach ($logistics_ids as $logistics_id) {
					$sql_c_up = "UPDATE  package_materials_order_detail_logistics SET 	logistics_status	= '" . $logistics_status . "',

																						update_timezone			= '" . $timezone . "',
																						update_date				= '" . $add_date . "',
																						update_by				= '" . $_SESSION['username'] . "',
																						update_by_user_id		= '" . $_SESSION['user_id'] . "',
																						update_ip				= '" . $add_ip . "',
																						update_from_module_id	= '" . $module_id . "'
										WHERE id = '" . $logistics_id . "' ";
					$ok = $db->query($conn, $sql_c_up);
					if ($ok) {

						$sql_ee1 = " SELECT b.* FROM package_materials_order_detail_logistics b WHERE b.po_id = '" . $id . "'";
						// echo $sql_ee1;
						$result_ee1 	= $db->query($conn, $sql_ee1);
						$counter_ee1	= $db->counter($result_ee1);
						if ($counter_ee1 == 0) {
							$sql_c_up = "UPDATE  package_materials_order_detail
													SET 	
														order_product_status	= '" . $logistics_status . "',

														update_timezone			= '" . $timezone . "',
														update_date				= '" . $add_date . "',
														update_by				= '" . $_SESSION['username'] . "',
														update_by_user_id		= '" . $_SESSION['user_id'] . "',
														update_ip				= '" . $add_ip . "'
														update_from_module_id	= '" . $module_id . "'
							WHERE po_id = '" . $id . "' ";
							$db->query($conn, $sql_c_up);

							$sql_c_up = "UPDATE  package_materials_orders
													SET 	
														order_status		= '" . $logistics_status . "',

														update_timezone			= '" . $timezone . "',
														update_date				= '" . $add_date . "',
														update_by				= '" . $_SESSION['username'] . "',
														update_by_user_id		= '" . $_SESSION['user_id'] . "',
														update_ip				= '" . $add_ip . "',
														update_from_module_id	= '" . $module_id . "'
							WHERE id = '" . $id . "' ";
							$db->query($conn, $sql_c_up);

							$disp_status_name 	= get_status_name($db, $conn, $logistics_status);

							$table		= "inventory_status";
							$columns	= array("status_name");
							$get_col_from_table = get_col_from_table($db, $conn, $selected_db_name, $table, $before_logistic_status_dynamic, $columns);
							foreach ($get_col_from_table as $array_key1 => $array_data1) {
								${$array_key1} = $array_data1;
							}
						}

						$k++;
						if (isset($error2['msg'])) unset($error2['msg']);
					} else {
						$error2['msg'] = "There is Error, Please check it again OR contact Support Team.";
					}
				}
				if ($k > 0) {
					if (isset($msg3['msg_success'])) {
						$msg3['msg_success'] .= "<br>Logistics status  has been updated successfully.";
					} else {
						$msg3['msg_success'] = "Logistics status has been added successfully.";
					}
					$logistics_status = "";
				}
			} else {
				$error2['msg'] = "Please select atleast one record.";
			}
		}
	} else {
		$error2['msg'] = "Please check required fields in the form.";
	}
}
