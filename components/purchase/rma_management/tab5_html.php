 <div id="tab5_html" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab5')) {
                                            echo "block";
                                        } else {
                                            echo "none";
                                        } ?>;">
     <div class="card-panel">
         <div class="row">
             <div class="col s10 m12 l8">
                 <h5 class="breadcrumbs mt-0 mb-0"><span>Receive</span></h5>
             </div>
         </div>
         <?php
            if (isset($id)) {  ?>
             <div class="row">
                 <div class="input-field col m3 s12">
                     <h6 class="media-heading"><span class=""><?php echo "<b>PO#: </b>" . $po_no; ?></span></h6>
                 </div>
                 <div class="input-field col m4 s12">
                     <h6 class="media-heading"><span class=""><?php echo "<b>Vendor Invoice#: </b>" . $vender_invoice_no; ?></span></h6>
                 </div>
                 <div class="input-field col m5 s12">
                     <?php
                        $entry_type = "receive"; ?>
                     <a class="btn gradient-45deg-light-blue-cyan timer_<?= $entry_type; ?>" title="Timer" href="javascript:void(0)" id="timer_<?= $entry_type; ?>_<?= $id ?>"
                         <?php
                            if (
                                !isset($_SESSION['is_start']) ||
                                !isset($_SESSION[$entry_type]) ||
                                (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] != $entry_type)
                            ) { ?> style="display: none;" <?php } ?>>00:00:00 </a>
                     <a class="btn gradient-45deg-green-teal startButton_<?= $entry_type; ?>" title="Start <?= $entry_type; ?>" href="javascript:void(0)" id="startButton_<?= $entry_type; ?>_<?= $id ?>" onclick="startTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                                        if ((
                                                                                                                                                                                                                                                                            isset($_SESSION['is_start']) && $_SESSION['is_start'] == 1) && (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] == $entry_type)) {
                                                                                                                                                                                                                                                                            echo "display: none;";
                                                                                                                                                                                                                                                                        } ?>">
                         Start Receiving
                     </a> &nbsp;
                     <a class="btn gradient-45deg-red-pink stopButton_<?= $entry_type; ?>" title="Stop <?= $entry_type; ?>" href="javascript:void(0)" id="stopButton_<?= $entry_type; ?>_<?= $id ?>" onclick="stopTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                                    if (!isset($_SESSION['is_start']) || !isset($_SESSION[$entry_type])) {
                                                                                                                                                                                                                                                                        echo "display: none; ";
                                                                                                                                                                                                                                                                    } else if (isset($_SESSION['is_start']) && $_SESSION['is_start'] != 1 && isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] !=  $entry_type) {
                                                                                                                                                                                                                                                                        echo "display: none;";
                                                                                                                                                                                                                                                                    } ?> ">
                         Finish Receiving
                     </a>
                 </div>
             </div>
             <?php
                if (isset($cmd5) &&  $cmd5 == "add" && isset($detail_id) && $detail_id != "") {  ?>
                 <div class="row">
                     <div class="input-field col m4 s12">
                         <h6 class="media-heading"><span class=""><?php echo "<b>Tracking / Pro #: </b>" . $detail_id; ?></span></h6>
                     </div>
                 </div>
         <?php }
            }  ?>
     </div>
     <?php
        if (!isset($id)) { ?>
         <div class="card-panel">
             <div class="row">
                 <!-- Search for small screen-->
                 <div class="container">
                     <div class="card-alert card red">
                         <div class="card-content white-text">
                             <p>Please add master record first</p>
                         </div>
                         <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">×</span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>
         <?php
        } else {
            $td_padding = "padding:5px 15px !important;";

            $sql        = " SELECT a.*, c.status_name, d.sub_location_name, d.sub_location_type
                        FROM purchase_order_detail_logistics a
                        LEFT JOIN inventory_status c ON c.id = a.logistics_status
                        LEFT JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                        WHERE a.po_id = '" . $id . "'
                        AND a.arrived_date IS NOT NULL
                        ORDER BY a.tracking_no ";
            // echo $sql; 
            $result_log     = $db->query($conn, $sql);
            $count_log      = $db->counter($result_log);
            if ($count_log > 0) { ?>
             <form id="barcodeForm" class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5_2" value="Y" />
                 <input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                 <input type="hidden" name="active_tab" value="tab5" />

                 <div class="card-panel">
                     <div class="row">
                         <div class="col m6 s12">
                             <h5>Receive from BarCode</h5>
                         </div>
                         <div class="col m6 s12 show_receive_from_barcode_show_btn" style="<?php if (isset($is_Submit_tab5_2) && $is_Submit_tab5_2 == 'Y') {
                                                                                                echo "display: none;";
                                                                                            } else {;
                                                                                            } ?>">
                             <a href="javascript:void(0)" class="show_receive_from_barcode_section">Show Form</a>
                         </div>
                         <div class="col m6 s12 show_receive_from_barcode_hide_btn" style="<?php if (isset($is_Submit_tab5_2) && $is_Submit_tab5_2 == 'Y') {;
                                                                                            } else {
                                                                                                echo "display: none;";
                                                                                            } ?>">
                             <a href="javascript:void(0)" class="hide_receive_from_barcode_section">Hide Form</a>
                         </div>
                     </div>
                     <div id="receive_from_barcode_section" style="<?php if (isset($is_Submit_tab5_2) && $is_Submit_tab5_2 == 'Y') {;
                                                                    } else {
                                                                        echo "display: none;";
                                                                    } ?>">
                         <div class="row">
                             <div class="input-field col m12 s12"> </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12">
                                 <?php
                                    $field_name     = "product_id_barcode";
                                    $field_label    = "Product ID";

                                    $sql        = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid
                                            FROM purchase_order_detail a 
                                            INNER JOIN purchase_orders b ON b.id = a.po_id
                                            INNER JOIN products c ON c.id = a.product_id
                                            INNER JOIN product_categories d ON d.id = c.product_category
                                            WHERE 1=1 
                                            AND a.po_id = '" . $id . "' 
                                            ORDER BY c.product_uniqueid, a.product_condition ";
                                    // echo $sql; 
                                    $result_log2     = $db->query($conn, $sql);
                                    $count_r2      = $db->counter($result_log2);
                                    ?>

                                 <i class="material-icons prefix pt-1">add_shopping_cart</i>
                                 <div class="select2div">
                                     <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                                    } ?>">
                                         <?php
                                            if ($count_r2 > 1) { ?>
                                             <option value="">Select</option>
                                             <?php
                                            }
                                            if ($count_r2 > 0) {
                                                $row_r2    = $db->fetch($result_log2);
                                                foreach ($row_r2 as $data_r2) {
                                                    $detail_id_r1       = $data_r2['id'];
                                                    $order_qty          = $data_r2['order_qty'];
                                                    $sql_rc1            = "	SELECT a.* 
                                                                        FROM purchase_order_detail_receive a 
                                                                        WHERE 1=1 
                                                                        AND a.po_detail_id = '" . $detail_id_r1 . "'
                                                                        AND a.enabled = 1 "; //echo $sql_cl;
                                                    $result_rc1         = $db->query($conn, $sql_rc1);
                                                    $total_received_qty = $db->counter($result_rc1);  ?>
                                                 <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                     <?php
                                                        echo " Product ID: " . $data_r2['product_uniqueid'];
                                                        echo " -  Product: " . $data_r2['product_desc'];
                                                        if ($data_r2['category_name'] != "") {
                                                            echo " (" . $data_r2['category_name'] . ") ";
                                                        }
                                                        echo " - Order QTY: " . $order_qty . ", Total Received Yet: " . $total_received_qty; ?>
                                                 </option>
                                         <?php
                                                }
                                            } ?>
                                     </select>
                                     <label for="<?= $field_name; ?>">
                                         <?= $field_label; ?>
                                         <span class="color-red">* <?php
                                                                    if (isset($error5[$field_name])) {
                                                                        echo $error5[$field_name];
                                                                    } ?>
                                         </span>
                                     </label>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"> </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m4 s12">
                                 <?php
                                    $field_name     = "logistic_id_barcode";
                                    $field_label    = "Tracking No";
                                    $count_r2     = $count_log;
                                    ?>
                                 <i class="material-icons prefix pt-1">location_on</i>
                                 <div class="select2div">
                                     <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                                    } ?>">
                                         <?php
                                            if ($count_r2 > 1) { ?>
                                             <option value="">Select</option>
                                             <?php
                                            }
                                            if ($count_r2 > 0) {
                                                $row_r2    = $db->fetch($result_log);
                                                foreach ($row_r2 as $data_r2) { ?>
                                                 <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                     <?php echo $data_r2['tracking_no']; ?>
                                                 </option>
                                         <?php
                                                }
                                            } ?>
                                     </select>
                                     <label for="<?= $field_name; ?>">
                                         <?= $field_label; ?>
                                         <span class="color-red">* <?php
                                                                    if (isset($error5[$field_name])) {
                                                                        echo $error5[$field_name];
                                                                    } ?>
                                         </span>
                                     </label>
                                 </div>
                             </div>

                             <div class="input-field col m4 s12">
                                 <?php
                                    $field_name     = "sub_location_id_barcode";
                                    $field_label    = "Location";
                                    $sql1           = "SELECT * FROM warehouse_sub_locations a WHERE a.enabled = 1  ORDER BY sub_location_name ";
                                    $result1        = $db->query($conn, $sql1);
                                    $count1         = $db->counter($result1);
                                    ?>
                                 <i class="material-icons prefix">question_answer</i>
                                 <div class="select2div">
                                     <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                                    } ?>">
                                         <option value="">Select</option>
                                         <?php
                                            if ($count1 > 0) {
                                                $row1    = $db->fetch($result1);
                                                foreach ($row1 as $data2) { ?>
                                                 <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                     <?php echo $data2['sub_location_name'];
                                                        if ($data2['sub_location_type'] != "") {
                                                            echo " (" . ucwords(strtolower($data2['sub_location_type'])) . ")";
                                                        } ?>
                                                 </option>
                                         <?php }
                                            } ?>
                                     </select>
                                     <label for="<?= $field_name; ?>">
                                         <?= $field_label; ?>
                                         <span class="color-red">* <?php
                                                                    if (isset($error5[$field_name])) {
                                                                        echo $error5[$field_name];
                                                                    } ?>
                                         </span>
                                     </label>
                                 </div>
                             </div>
                             <div class="input-field col m4 s12">
                                 <?php
                                    $field_name     = "serial_no_barcode";
                                    $field_label    = "Product Bar Code";
                                    ?>
                                 <i class="material-icons prefix">description</i>
                                 <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                    echo ${$field_name};
                                                                                                                } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                        } ?>" onkeyup="autoSubmit(event)" autofocus>
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
                             <div class="input-field col m12 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m4 s12"></div>
                             <div class="input-field col m4 s12">
                                 <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="waves-effect waves-light  btn gradient-45deg-purple-deep-orange box-shadow-none border-round mr-1 mb-1" type="submit" name="add">Receive with BarCode</button>
                                 <?php } ?>
                             </div>
                             <div class="input-field col m4 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </div>
             </form>
             <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5" value="Y" />
                 <input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                 <input type="hidden" name="active_tab" value="tab5" />
                 <?php
                    $sql        = " SELECT a.*, c.status_name, d.sub_location_name, d.sub_location_type
                                FROM purchase_order_detail_logistics a
                                LEFT JOIN inventory_status c ON c.id = a.logistics_status
                                LEFT JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                                WHERE a.po_id = '" . $id . "'
                                AND a.arrived_date IS NOT NULL
                                ORDER BY a.tracking_no ";
                    // echo $sql; 
                    $result_log     = $db->query($conn, $sql);
                    $count_log      = $db->counter($result_log);
                    if ($count_log > 0) { ?>
                     <div class="card-panel">
                         <div class="row">
                             <div class="col m6 s12">
                                 <h5>Receive as Category without Serial Nos</h5>
                             </div>
                             <div class="col m6 s12 show_receive_as_category_show_btn" style="<?php if (isset($is_Submit_tab5) && $is_Submit_tab5 == 'Y') {
                                                                                                    echo "display: none;";
                                                                                                } else {;
                                                                                                } ?>">
                                 <a href="javascript:void(0)" class="show_receive_as_category_section">Show Form</a>
                             </div>
                             <div class="col m6 s12 show_receive_as_category_hide_btn" style="<?php if (isset($is_Submit_tab5) && $is_Submit_tab5 == 'Y') {;
                                                                                                } else {
                                                                                                    echo "display: none;";
                                                                                                } ?>">
                                 <a href="javascript:void(0)" class="hide_receive_as_category_section">Hide Form</a>
                             </div>
                         </div>
                         <div id="receive_as_category_section" style="<?php if (isset($is_Submit_tab5) && $is_Submit_tab5 == 'Y') {;
                                                                        } else {
                                                                            echo "display: none;";
                                                                        } ?>">
                             <div class="row">
                                 <?php
                                    if (isset($cmd5) &&  $cmd5 == "add" && isset($detail_id) && $detail_id != "") {  ?>
                                     <div class="col m4 s12"><br><br>
                                         <a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=" . $cmd . "&cmd5=" . $cmd5 . "&active_tab=tab5&id=" . $id) ?>">All Tracking / Pro #</a>
                                     </div> <br>
                                 <?php } ?>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"> </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m4 s12">
                                     <?php
                                        $field_name     = "logistic_id";
                                        $field_label    = "Tracking No";
                                        $count_r2     = $count_log;
                                        ?>
                                     <i class="material-icons prefix pt-8">location_on</i>
                                     <div class="select2div">
                                         <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                                        } ?>">
                                             <?php
                                                if ($count_r2 > 1) { ?>
                                                 <option value="">Select</option>
                                                 <?php
                                                }
                                                if ($count_r2 > 0) {
                                                    $row_r2    = $db->fetch($result_log);
                                                    foreach ($row_r2 as $data_r2) { ?>
                                                     <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                         <?php echo $data_r2['tracking_no']; ?>
                                                     </option>
                                             <?php
                                                    }
                                                } ?>
                                         </select>
                                         <label for="<?= $field_name; ?>">
                                             <?= $field_label; ?>
                                             <span class="color-red">* <?php
                                                                        if (isset($error5[$field_name])) {
                                                                            echo $error5[$field_name];
                                                                        } ?>
                                             </span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"> </div>
                             </div>
                             <?php
                                $sql_r1     = "	SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid
                                                FROM purchase_order_detail a 
                                                INNER JOIN purchase_orders b ON b.id = a.po_id
                                                INNER JOIN products c ON c.id = a.product_id
                                                INNER JOIN product_categories d ON d.id = c.product_category
                                                WHERE 1=1 
                                                AND a.po_id = '" . $id . "' 
                                                ORDER BY c.product_uniqueid, a.product_condition "; //echo $sql_cl;
                                $result_r1  = $db->query($conn, $sql_r1);
                                $count_r1   = $db->counter($result_r1);
                                if ($count_r1 > 0) { ?>
                                 <div class="row">
                                     <div class="col s12">
                                         <table id="page-length-option1" class=" bordered">
                                             <thead>
                                                 <tr>
                                                     <?php
                                                        $headings = '<th>
                                                                        Base Product ID</br>
                                                                        Detail
                                                                    </th>
                                                                    <th>Order Qty</th>
                                                                    <th>Total Received Yet</th>
                                                                    <th>Receiving Qty</th> 
                                                                    <th>Location</th>';
                                                        echo $headings; ?>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php
                                                    $i = 0;
                                                    if ($count_r1 > 0) {
                                                        $row_cl_r1 = $db->fetch($result_r1);
                                                        foreach ($row_cl_r1 as $data_r1) {
                                                            $detail_id_r1   = $data_r1['id'];
                                                            $order_qty      = $data_r1['order_qty'];

                                                            $sql_rc1            = "	SELECT a.* 
                                                                                    FROM purchase_order_detail_receive a 
                                                                                    WHERE 1=1 
                                                                                    AND a.po_detail_id = '" . $detail_id_r1 . "'
                                                                                    AND a.enabled = 1 "; //echo $sql_cl;
                                                            $result_rc1         = $db->query($conn, $sql_rc1);
                                                            $total_received_qty = $db->counter($result_rc1);  ?>
                                                         <tr>
                                                             <td style="width: 400px;">
                                                                 <?php echo $data_r1['product_uniqueid']; ?></br>
                                                                 <?php
                                                                    echo $data_r1['product_desc'];
                                                                    if ($data_r1['category_name'] != '') {
                                                                        echo "(" . $data_r1['category_name'] . ")";
                                                                    } ?>
                                                             </td>
                                                             <td style="width: 150px; text-align: center;"><?php echo $order_qty; ?></td>
                                                             <td style="width: 180px; text-align: center;"><?php echo $total_received_qty; ?></td>
                                                             <td style="width: 150px;">
                                                                 <?php
                                                                    $field_name             = "receiving_qties";
                                                                    $field_label            = "Receiving Qty";
                                                                    $receiving_qty_value    = "";

                                                                    if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                        $receiving_qty_value = ${$field_name}[$detail_id_r1];
                                                                    }

                                                                    if (isset($error5[$field_name])) { ?>
                                                                     <span class="color-red"><?php
                                                                                                echo $error5[$field_name]; ?>
                                                                     </span>
                                                                 <?php
                                                                    } ?>

                                                                 <input type="number" placeholder="<?= $field_label; ?>" class="" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $receiving_qty_value; ?>" style=" text-align: center;" />
                                                             </td>

                                                             <td style="width: 200px;">
                                                                 <?php
                                                                    $field_name             = "receiving_location";
                                                                    $field_label            = "Location";
                                                                    $receiving_location_val = "";

                                                                    if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                        $receiving_location_val = ${$field_name}[$detail_id_r1];
                                                                    }

                                                                    $sql1           = "SELECT * FROM warehouse_sub_locations a WHERE a.enabled = 1  ORDER BY sub_location_name ";
                                                                    $result1        = $db->query($conn, $sql1);
                                                                    $count1         = $db->counter($result1);
                                                                    ?>
                                                                 <span class="color-red"><?php
                                                                                            if (isset($error5[$field_name])) {
                                                                                                echo $error5[$field_name];
                                                                                            } ?>
                                                                 </span>
                                                                 <select id="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                                                                                                } ?>">
                                                                     <option value="">Select</option>
                                                                     <?php
                                                                        if ($count1 > 0) {
                                                                            $row1    = $db->fetch($result1);
                                                                            foreach ($row1 as $data2) { ?>
                                                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset($receiving_location_val) && $receiving_location_val == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                                 <?php echo $data2['sub_location_name'];
                                                                                    if ($data2['sub_location_type'] != "") {
                                                                                        echo " (" . ucwords(strtolower($data2['sub_location_type'])) . ")";
                                                                                    } ?>
                                                                             </option>
                                                                     <?php }
                                                                        } ?>
                                                                 </select>
                                                             </td>
                                                         </tr>
                                                 <?php $i++;
                                                        }
                                                    } ?>
                                         </table>
                                     </div>
                                 </div>
                             <?php } ?>
                             <div class="row">
                                 <div class="input-field col m12 s12"></div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m4 s12"></div>
                                 <div class="input-field col m4 s12">
                                     <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                         <button class="waves-effect waves-light  btn gradient-45deg-purple-deep-orange box-shadow-none border-round mr-1 mb-1" type="submit" name="add">Receive as Category</button>
                                     <?php } ?>
                                 </div>
                                 <div class="input-field col m4 s12"></div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"></div>
                             </div>
                         </div>
                     </div>
                 <?php
                    } else { ?>
                     <div class="card-panel">
                         <div class="row">
                             <div class="col 24 s12"><br>
                                 <div class="card-alert card red lighten-5">
                                     <div class="card-content red-text">
                                         <p>No arrival information is available. </p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 <?php } ?>
             </form>

             <form id="receiving_manual" class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5_5" value="Y" />
                 <input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                 <input type="hidden" name="active_tab" value="tab5" />

                 <div class="card-panel">
                     <div class="row">
                         <div class="col m6 s12">
                             <h5> Receive by Adding Serial Numbers Manually</h5>
                         </div>
                         <div class="col m6 s12 show_receive_as_manual_barcodes_show_btn" style="<?php if (isset($is_Submit_tab5_5) && $is_Submit_tab5_5 == 'Y') {
                                                                                                        echo "display: none;";
                                                                                                    } else {;
                                                                                                    } ?>">
                             <a href="javascript:void(0)" class="show_receive_as_manual_barcodes_section">Show Form</a>
                         </div>
                         <div class="col m6 s12 show_receive_as_manual_barcodes_hide_btn" style="<?php if (isset($is_Submit_tab5_5) && $is_Submit_tab5_5 == 'Y') {;
                                                                                                    } else {
                                                                                                        echo "display: none;";
                                                                                                    } ?>">
                             <a href="javascript:void(0)" class="hide_receive_as_manual_barcodes_section">Hide Form</a>
                         </div>
                     </div>
                     <div id="receive_as_manual_barcodes_section" style="<?php if (isset($is_Submit_tab5_5) && $is_Submit_tab5_5 == 'Y') {;
                                                                            } else {
                                                                                echo "display: none;";
                                                                            } ?>">
                         <div class="row">
                             <div class="input-field col m12 s12"> </div>
                         </div>
                         <div class="section section-data-tables">


                             <div class="row">
                                 <div class="input-field col m12 s12">
                                     <?php
                                        $field_name     = "product_id_manual";
                                        $field_label    = "Product ID";

                                        $sql            = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid
                                                        FROM purchase_order_detail a 
                                                        INNER JOIN purchase_orders b ON b.id = a.po_id
                                                        INNER JOIN products c ON c.id = a.product_id
                                                        INNER JOIN product_categories d ON d.id = c.product_category
                                                        WHERE 1=1 
                                                        AND a.po_id = '" . $id . "' 
                                                        ORDER BY c.product_uniqueid, a.product_condition "; // echo $sql; 
                                        $result_log2    = $db->query($conn, $sql);
                                        $count_r2       = $db->counter($result_log2); ?>

                                     <i class="material-icons prefix pt-1">add_shopping_cart</i>
                                     <div class="select2div">
                                         <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                                        } ?>">
                                             <?php
                                                if ($count_r2 > 1) { ?>
                                                 <option value="">Select</option>
                                                 <?php
                                                }
                                                if ($count_r2 > 0) {
                                                    $row_r2    = $db->fetch($result_log2);
                                                    foreach ($row_r2 as $data_r2) {

                                                        $detail_id_r1       = $data_r2['id'];
                                                        $order_qty          = $data_r2['order_qty'];

                                                        $sql_rc1            = "	SELECT a.* 
                                                                            FROM purchase_order_detail_receive a 
                                                                            WHERE 1=1 
                                                                            AND a.po_detail_id = '" . $detail_id_r1 . "'
                                                                            AND a.enabled = 1 "; //echo $sql_cl;
                                                        $result_rc1         = $db->query($conn, $sql_rc1);
                                                        $total_received_qty = $db->counter($result_rc1);  ?>

                                                     <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                         <?php
                                                            echo " Product ID: " . $data_r2['product_uniqueid'];
                                                            echo " -  Product: " . $data_r2['product_desc'];
                                                            if ($data_r2['category_name'] != "") {
                                                                echo " (" . $data_r2['category_name'] . ") ";
                                                            }
                                                            echo " - Order QTY: " . $order_qty . ", Total Received Yet: " . $total_received_qty; ?>
                                                     </option>
                                             <?php
                                                    }
                                                } ?>
                                         </select>
                                         <label for="<?= $field_name; ?>">
                                             <?= $field_label; ?>
                                             <span class="color-red">* <?php
                                                                        if (isset($error5[$field_name])) {
                                                                            echo $error5[$field_name];
                                                                        } ?>
                                             </span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"> </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m6 s12">
                                     <?php
                                        $sql        = " SELECT a.*, c.status_name, d.sub_location_name, d.sub_location_type
                                                    FROM purchase_order_detail_logistics a
                                                    LEFT JOIN inventory_status c ON c.id = a.logistics_status
                                                    LEFT JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                                                    WHERE a.po_id = '" . $id . "'
                                                    AND a.arrived_date IS NOT NULL
                                                    ORDER BY a.tracking_no ";
                                        // echo $sql; 
                                        $result_log_mn  = $db->query($conn, $sql);
                                        $count_r2       = $db->counter($result_log);

                                        $field_name     = "logistic_id_manual";
                                        $field_label    = "Tracking No";
                                        ?>
                                     <i class="material-icons prefix pt-1">location_on</i>
                                     <div class="select2div">
                                         <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                                        } ?>">
                                             <?php
                                                if ($count_r2 > 1) { ?>
                                                 <option value="">Select</option>
                                                 <?php
                                                }
                                                if ($count_r2 > 0) {
                                                    $row_r3 = $db->fetch($result_log_mn);
                                                    foreach ($row_r3 as $data_r3) { ?>
                                                     <option value="<?php echo $data_r3['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r3['id']) { ?> selected="selected" <?php } ?>>
                                                         <?php echo $data_r3['tracking_no']; ?>
                                                     </option>
                                             <?php
                                                    }
                                                } ?>
                                         </select>
                                         <label for="<?= $field_name; ?>">
                                             <?= $field_label; ?>
                                             <span class="color-red">* <?php
                                                                        if (isset($error5[$field_name])) {
                                                                            echo $error5[$field_name];
                                                                        } ?>
                                             </span>
                                         </label>
                                     </div>
                                 </div>
                                 <div class="input-field col m6 s12">
                                     <?php
                                        $field_name     = "sub_location_id_manual";
                                        $field_label    = "Location";
                                        $sql1           = "SELECT * FROM warehouse_sub_locations a WHERE a.enabled = 1  ORDER BY sub_location_name ";
                                        $result1        = $db->query($conn, $sql1);
                                        $count1         = $db->counter($result1);
                                        ?>
                                     <i class="material-icons prefix">question_answer</i>
                                     <div class="select2div">
                                         <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                                        } ?>">
                                             <option value="">Select</option>
                                             <?php
                                                if ($count1 > 0) {
                                                    $row1    = $db->fetch($result1);
                                                    foreach ($row1 as $data2) { ?>
                                                     <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                         <?php echo $data2['sub_location_name'];
                                                            if ($data2['sub_location_type'] != "") {
                                                                echo " (" . ucwords(strtolower($data2['sub_location_type'])) . ")";
                                                            } ?>
                                                     </option>
                                             <?php }
                                                } ?>
                                         </select>
                                         <label for="<?= $field_name; ?>">
                                             <?= $field_label; ?>
                                             <span class="color-red">* <?php
                                                                        if (isset($error5[$field_name])) {
                                                                            echo $error5[$field_name];
                                                                        } ?>
                                             </span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12">&nbsp;</div>
                             </div>
                             <div class="row">
                                 <?php
                                    $max = 2;
                                    if (isset($serial_no_manual)) {
                                        $max = sizeof($serial_no_manual) - 1;
                                    }
                                    for ($i = 0; $i < 100; $i++) {
                                        $style = $style2 = "";
                                        if ($i > $max) {
                                            $style = "display: none;";
                                        }
                                        if ($i > $max || $i < $max) {
                                            $style2 = "display: none;";
                                        }
                                        $i2 = $i + 1; ?>
                                     <div class="input-field col m3 s12 serial_no_manual_input_<?= $i2; ?>" style="<?= $style; ?>">
                                         <?php
                                            $field_name     = "serial_no_manual";
                                            $field_id       = $field_name . "_" . $i2;
                                            $field_label    = "Serial No";
                                            ?>
                                         <i class="material-icons prefix">description</i>
                                         <input id="<?= $field_id; ?>" type="text" name="<?= $field_name; ?>[]" value="<?php if (isset($serial_no_manual[$i])) {
                                                                                                                            echo $serial_no_manual[$i];
                                                                                                                        } ?>" class="validate ">
                                         <label for="<?= $field_id; ?>">
                                             <?= $field_label; ?>
                                             <span class="color-red">* <?php
                                                                        if (isset($error5["field_name_" . $i2])) {
                                                                            echo $error5["field_name_" . $i2];
                                                                        } ?>
                                             </span>
                                         </label>
                                     </div>
                                     <div style="<?= $style; ?>" class=" input-field col m1 s12 button_div_serial_no_manual" id="button_div_serial_no_manual_<?= $i2; ?>">
                                         <a href="#." style="<?= $style2; ?> font-size: 30px;" class="add_<?= $field_name; ?> add_<?= $field_name; ?>_<?= $i2; ?>" id="add_<?= $field_name; ?>^<?= $i2; ?>">+</a>
                                         &nbsp;
                                         <a href="#." style="<?= $style; ?> font-size: 30px;" class="minus_<?= $field_name; ?> minus_<?= $field_name; ?>_<?= $i2; ?>" id="minus_<?= $field_name; ?>^<?= $i2; ?>">-</a>
                                     </div>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m4 s12"></div>
                             <div class="input-field col m4 s12">
                                 <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="waves-effect waves-light  btn gradient-45deg-purple-deep-orange box-shadow-none border-round mr-1 mb-1" type="submit" name="add">Receive by Manual Serial Numbers</button>
                                 <?php } ?>
                             </div>
                             <div class="input-field col m4 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </div>
             </form>
             <?php
                if (isset($all_deduct_info) && sizeof($all_deduct_info) > 0) { ?>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_4" value="Y" />
                     <input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
                     <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                     <input type="hidden" name="product_id_barcode_deduct" value="<?php if (isset($product_id_barcode_deduct)) echo $product_id_barcode_deduct; ?>" />
                     <input type="hidden" name="is_Submit_tab5_3" value="Y" />
                     <input type="hidden" name="active_tab" value="tab5" />
                     <div class="card-panel">
                         <div class="row">
                             <div class="col m4 s12">
                                 <h5>Connect Devices Deduct Info</h5>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col m12 s12">
                                 <table class="bordered ">
                                     <thead>
                                         <tr>
                                             <th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <label>
                                                     <input type="checkbox" id="all_checked5" class="filled-in" name="all_checked5" value="1" <?php if (isset($all_checked5) && $all_checked5 == '1') {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> />
                                                     <span></span>
                                                 </label>
                                             </th>
                                             <?php
                                                $headings = '   
                                                                <th>Serial Info</th>
                                                                <th>Serial#</th>
                                                                <th>Product Info</th>';
                                                echo $headings;
                                                $headings2 = ' '; ?>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $i = 0;
                                            foreach ($all_deduct_info as $data) {
                                                $serialNumber = $data['serialNumber']; ?>
                                             <tr>
                                                 <td style="<?= $td_padding; ?>">
                                                     <label style="margin-left: 25px;">
                                                         <input type="checkbox" name="serialNumbers[]" id="serialNumbers[]" value="<?= $serialNumber; ?>" <?php
                                                                                                                                                            if (isset($serialNumbers) && in_array($serialNumbers, $data)) {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?> class="checkbox5 filled-in" />
                                                         <span></span>
                                                     </label>
                                                 </td>
                                                 <td style="<?= $td_padding; ?>"><?php echo $data['serialInfo']; ?></td>
                                                 <td style="<?= $td_padding; ?>"><?php echo $serialNumber; ?></td>
                                                 <td style="<?= $td_padding; ?>"><?php echo $data['product_detail_info']; ?></td>
                                             </tr>
                                         <?php
                                                $i++;
                                            } ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>

                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m4 s12"></div>
                             <div class="input-field col m4 s12">
                                 <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="waves-effect waves-light  btn gradient-45deg-purple-deep-orange box-shadow-none border-round mr-1 mb-1" type="submit" name="deduct2">Update Deduct Serial Numbers</button>
                                 <?php } ?>
                             </div>
                             <div class="input-field col m4 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </form>
             <?php }
                $td_padding = "padding:5px 10px !important;";
                $sql            = " SELECT a.*, c.product_desc, c.product_uniqueid, d.category_name, 
                                        e.first_name, e.middle_name, e.last_name, e.username, f.tracking_no, g.sub_location_name
                                FROM purchase_order_detail_receive a
                                INNER JOIN purchase_order_detail b ON b.id = a.po_detail_id
                                INNER JOIN products c ON c.id = b.product_id
                                LEFT JOIN product_categories d ON d.id =c.product_category
                                LEFT JOIN users e ON e.id = a.add_by_user_id
                                INNER JOIN purchase_order_detail_logistics f ON f.id = a.logistic_id
                                LEFT JOIN warehouse_sub_locations g ON g.id = a.sub_location_id
                                WHERE a.enabled = 1 
                                AND b.po_id = '" . $id . "'
                                ORDER BY a.serial_no_barcode DESC, g.sub_location_name, a.id DESC ";
                $result_log     = $db->query($conn, $sql);
                $count_log      = $db->counter($result_log);
                if ($count_log > 0) {
                ?>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_4_2" value="Y" />
                     <input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                     <input type="hidden" name="active_tab" value="tab5" />
                     <div class="card-panel">
                         <div class="row">
                             <div class="col m12 s12">
                                 <h5>Received Products</h5>
                             </div>
                         </div>
                         <?php ///*
                            ?>
                         <div class="row">
                             <table class="bordered">
                                 <tr>
                                     <th>PO No</th>
                                     <th>Diagnostic Invoice#</th>
                                     <th>Base Product ID</th>
                                     <th>Product</th>
                                     <th> Total Received</th>
                                 </tr>
                                 <?php
                                    $sql        = " SELECT DISTINCT b2.po_no, a.po_detail_id, c.product_desc, c.product_uniqueid, d.category_name, count(a.id) as total_products
                                                FROM purchase_order_detail_receive a
                                                INNER JOIN purchase_order_detail b ON b.id = a.po_detail_id
                                                INNER JOIN purchase_orders b2 ON b2.id = b.po_id
                                                INNER JOIN products c ON c.id = b.product_id
                                                LEFT JOIN product_categories d ON d.id =c.product_category
                                                WHERE a.enabled = 1 
                                                AND b.po_id = '" . $id . "'
                                                GROUP BY a.po_detail_id
                                                ORDER BY a.po_detail_id ";
                                    $result_t1  = $db->query($conn, $sql);
                                    $count_t1   = $db->counter($result_t1);
                                    if ($count_t1 > 0) {
                                        if ($count_log > 0) {
                                            $row_t1 = $db->fetch($result_t1);
                                            foreach ($row_t1 as $data_t1) {
                                                $detail_id2 = $data_t1['po_detail_id']; ?>
                                             <tr>
                                                 <td><?php echo $data_t1['po_no']; ?></td>
                                                 <td>
                                                     <?php echo $data_t1['po_no']; ?>P<?php echo $data_t1['po_detail_id']; ?>
                                                     &nbsp;&nbsp;
                                                     <a href="components/<?php echo $module_folder; ?>/<?php echo $module; ?>/printlabels_po_productno_pdf.php?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&id=" . $id . "&detail_id=" . $detail_id2) ?>" target="_blank">
                                                         <i class="material-icons dp48">print</i>
                                                     </a>
                                                 </td>
                                                 <td><?php echo $data_t1['product_uniqueid']; ?></td>
                                                 <td>
                                                     <?php echo $data_t1['product_desc']; ?>
                                                     <?php
                                                        if ($data_t1['category_name'] != "") {
                                                            echo " (" . $data_t1['category_name'] . ")";
                                                        }
                                                        ?>
                                                 </td>
                                                 <td>
                                                     <?php echo $data_t1['total_products']; ?>
                                                 </td>
                                             </tr>
                                 <?php
                                            }
                                        }
                                    } ?>
                             </table>
                         </div>
                         <?php //*/ 
                            ?>
                         <br>
                         <div class="row">
                             <div class="col m12 s12">
                                 <label>
                                     <input type="checkbox" id="all_checked6" class="filled-in" name="all_checked6" value="1" <?php if (isset($all_checked6) && $all_checked6 == '1') {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> />
                                     <span></span>
                                 </label>
                             </div>
                         </div>
                         <div class="section section-data-tables">
                             <div class="row">
                                 <div class="col m12 s12">
                                     <table id="page-length-option" class="display2 ">
                                         <thead>
                                             <tr>
                                                 <?php
                                                    $headings = '   <th class="sno_width_60">S.No</th>
                                                                    <th>Tracking#</th>
                                                                    <th>Serial#</th>
                                                                    <th>Product Base ID /<br>Product Detail</th>
                                                                    <th>Received By /</br>Receiving Date/Time</th>';
                                                    echo $headings;
                                                    $headings2 = ' '; ?>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php
                                                $i = 0;
                                                if ($count_log > 0) {
                                                    $row_cl1 = $db->fetch($result_log);
                                                    foreach ($row_cl1 as $data) {
                                                        $detail_id2 = $data['id']; ?>
                                                     <tr>
                                                         <td style="<?= $td_padding; ?>">
                                                             <?php echo $i + 1; ?>
                                                         </td>
                                                         <td style="<?= $td_padding; ?>">
                                                             <?php
                                                                if (access("delete_perm") == 1 && $data['edit_lock'] == "0") { ?>
                                                                 <label style="margin-left: 25px;">
                                                                     <input type="checkbox" name="receviedProductIds[]" id="receviedProductIds[]" value="<?= $detail_id2; ?>" class="checkbox6 filled-in" />
                                                                     <span></span>
                                                                 </label>
                                                             <?php }
                                                                echo $data['tracking_no']; ?>
                                                         </td>
                                                         <td style="<?= $td_padding; ?>">
                                                             <?php
                                                                $color  = "color-red";
                                                                $serial_no_barcode = $data['serial_no_barcode'];

                                                                $sql        = " SELECT a.*
                                                                                FROM vender_po_data a
                                                                                WHERE a.enabled = 1
                                                                                AND a.serial_no = '" . $serial_no_barcode . "'
                                                                                AND a.po_id             = '" . $id . "'  ";
                                                                $result_log3 = $db->query($conn, $sql);
                                                                $count_log3  = $db->counter($result_log3);
                                                                if ($count_log3 > 0) {
                                                                    $color  = "color-green";
                                                                }
                                                                echo "<span class='" . $color . "'>" . $serial_no_barcode . "</span>"; ?>

                                                         </td>
                                                         <td style="<?= $td_padding; ?>">
                                                             <?php echo $data['product_uniqueid']; ?><br>
                                                             <?php echo $data['product_desc']; ?>
                                                             <?php
                                                                if ($data['category_name'] != "") {
                                                                    echo "(" . $data['category_name'] . ")";
                                                                } ?><br>
                                                             <?php echo $data['sub_location_name']; ?>
                                                         </td>
                                                         <td style="<?= $td_padding; ?>">
                                                             <?php echo $data['first_name']; ?>
                                                             ( <?php echo $data['username']; ?> )
                                                             </br>
                                                             <?php echo dateformat1_with_time($data['add_date']); ?>
                                                         </td>
                                                     </tr>
                                             <?php
                                                        $i++;
                                                    }
                                                } ?>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="input-field col m4 s12"></div>
                             <div class="input-field col m4 s12">
                                 <?php if (isset($id) && $id > 0 &&  access("delete_perm") == 1) { ?>
                                     <button class="waves-effect waves-light  btn gradient-45deg-purple-deep-orange box-shadow-none border-round mr-1 mb-1" type="submit" name="deletepserial">Delete</button>
                                 <?php } ?>
                             </div>
                             <div class="input-field col m4 s12"></div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </form>
             <?php
                }
            } else { ?>
             <div class="card-panel">
                 <div class="row">
                     <div class="col 24 s12"><br>
                         <div class="card-alert card red lighten-5">
                             <div class="card-content red-text">
                                 <p>Nothing receive yet. </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
     <?php }
        } ?>
 </div>
 <script>
     function autoSubmit(event) {
         var keycode_value = event.keyCode;
         if (keycode_value === 8 || keycode_value === 37 || keycode_value === 38 || keycode_value === 39 || keycode_value === 40 || keycode_value === 46 || keycode_value === 17 || keycode_value === 16 || keycode_value === 18 || keycode_value === 20 || keycode_value === 110 || (event.ctrlKey && (keycode_value === 65 || keycode_value === 67 || keycode_value === 88 || keycode_value === 88))) {

         } else {
             document.getElementById('barcodeForm').submit();
         }
     }
 </script>