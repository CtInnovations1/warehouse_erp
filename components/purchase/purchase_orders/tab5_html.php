 <div id="tab5_html" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab5')) {
                                            echo "block";
                                        } else {
                                            echo "none";
                                        } ?>;">
     <div class="card-panel" style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 5px;">
         <div class="row">
             <div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
                 <h6 class="media-heading">
                     <?= $general_heading; ?> => Receive
                 </h6>
             </div>
             <div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
                 <?php include("tab_action_btns.php"); ?>
             </div>
         </div>
         <?php
            if (isset($id) && isset($po_no)) {  ?>
             <div class="row">
                 <div class="input-field col m4 s12">
                     <h6 class="media-heading"><span class=""><?php echo "<b>PO#:</b>" . $po_no; ?></span></h6>
                 </div>
                 <div class="input-field col m4 s12">
                     <h6 class="media-heading"><span class=""><?php echo "<b>Vendor Invoice#: </b>" . $vender_invoice_no; ?></span></h6>
                 </div>
                 <div class="input-field col m4 s12">
                     <span class="chip green lighten-5">
                         <span class="green-text">
                             <?php echo $disp_status_name; ?>
                         </span>
                     </span>
                 </div>
                 <?php /* 
                <div class="input-field col m4 s12">
                    $entry_type = "receive"; ?>
                    <a class="btn gradient-45deg-light-blue-cyan timer_<?= $entry_type; ?>" title="Timer" href="javascript:void(0)" id="timer_<?= $entry_type; ?>_<?= $id ?>"
                        <?php
                        if (
                            !isset($_SESSION['is_start']) ||
                            !isset($_SESSION[$entry_type]) ||
                            (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] != $entry_type)
                        ) { ?> style="display: none;" <?php } ?>>00:00:00
                    </a>
                    <a class="btn gradient-45deg-green-teal startButton_<?= $entry_type; ?>" title="Start <?= $entry_type; ?>" href="javascript:void(0)" id="startButton_<?= $entry_type; ?>_<?= $id ?>" onclick="startTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                                    if ((
                                                                                                                                                                                                                                                                        isset($_SESSION['is_start']) && $_SESSION['is_start'] == 1) && (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] == $entry_type)) {
                                                                                                                                                                                                                                                                        echo "display: none;";
                                                                                                                                                                                                                                                                    } ?>">
                        Start
                    </a> &nbsp;
                    <a class="btn gradient-45deg-red-pink stopButton_<?= $entry_type; ?>" title="Stop <?= $entry_type; ?>" href="javascript:void(0)" id="stopButton_<?= $entry_type; ?>_<?= $id ?>" onclick="stopTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                                if (!isset($_SESSION['is_start']) || !isset($_SESSION[$entry_type])) {
                                                                                                                                                                                                                                                                    echo "display: none; ";
                                                                                                                                                                                                                                                                } else if (isset($_SESSION['is_start']) && $_SESSION['is_start'] != 1 && isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] !=  $entry_type || (isset($_SESSION['is_paused']) && $_SESSION['is_paused'] == '1')) {
                                                                                                                                                                                                                                                                    echo "display: none;";
                                                                                                                                                                                                                                                                } ?> ">
                        Stop
                    </a>&nbsp;
                    <a class="btn gradient-45deg-amber-amber pauseButton_<?= $entry_type; ?>" title="Pause Timer" href="javascript:void(0)" id="pauseButton_<?= $entry_type; ?>_<?= $id ?>" onclick="pauseTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                        if (!isset($_SESSION['is_start']) || !isset($_SESSION[$entry_type])) {
                                                                                                                                                                                                                                                            echo "display: none; ";
                                                                                                                                                                                                                                                        } else if (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] ==  $entry_type && (isset($_SESSION['is_paused']) && $_SESSION['is_paused'] == '1')) {
                                                                                                                                                                                                                                                            echo "display: none;";
                                                                                                                                                                                                                                                        } ?> ">
                        Pause
                    </a>&nbsp;
                    <a class="btn gradient-45deg-green-teal resumeButton_<?= $entry_type; ?>" title="Resume <?= $entry_type; ?>" href="javascript:void(0)" id="resumeButton_<?= $entry_type; ?>_<?= $id ?>" onclick="resumeTimer(<?= $id ?>, '<?= $entry_type ?>')" style="<?php
                                                                                                                                                                                                                                                                        if (!isset($_SESSION['is_paused']) || (isset($_SESSION['is_paused']) && $_SESSION['is_paused'] == '0') && (isset($_SESSION[$entry_type]) && $_SESSION[$entry_type] == $entry_type)) {
                                                                                                                                                                                                                                                                            echo "display: none;";
                                                                                                                                                                                                                                                                        } ?> ">
                        Resume
                    </a>&nbsp;
                </div>
                <?php */ ?>
                 <input type="hidden" name="total_pause_duration" id="total_pause_duration" value="0">
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
        if (!isset($id) || (isset($id) && $id == '')) { ?>
         <div class="card-panel custom_padding_card_content_table_top_bottom">
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
        } else  if (isset($active_tab) && $active_tab == 'tab5') {
            if (isset($cmd5_1) && $cmd5_1 == 'edit') { ?>
             <div class="card-panel">
                 <h5>Update Received Product Info</h5><br>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&cmd5_1=edit&detail_id=" . $detail_id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_1" value="Y" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="active_tab" value="tab5" />
                     <div class="row">
                         <div class="input-field col m9 s12">
                             <?php
                                $field_name     = "update_receive_id";
                                $field_label    = "Product";
                                $sql            = " SELECT * FROM(
                                                        SELECT  a.id, a.po_detail_id, a.edit_lock, a.serial_no_barcode, c.product_uniqueid AS base_product_id,
                                                                c.product_desc, d.category_name,  c.product_uniqueid, a.is_rma_processed, a.price, h.status_name,
                                                                i.sub_location_name, i.sub_location_type
                                                        FROM purchase_order_detail_receive a
                                                        INNER JOIN purchase_order_detail b ON b.id = a.po_detail_id
                                                        INNER JOIN products c ON c.id = b.product_id
                                                        LEFT JOIN product_categories d ON d.id =c.product_category
                                                        LEFT JOIN inventory_status h ON h.id = a.inventory_status
                                                        LEFT JOIN warehouse_sub_locations i ON i.id = a.sub_location_id
                                                        INNER JOIN product_stock j ON j.receive_id = a.id 
                                                        WHERE a.enabled = 1 
                                                        AND b.enabled   = 1
                                                        AND b.po_id     = '" . $id . "'
                                                         AND a.edit_lock = 1 
                                                        
                                                        UNION ALL 

                                                        SELECT  a.id, a.po_detail_id, a.edit_lock, a.serial_no_barcode, c.product_uniqueid AS base_product_id,
                                                            c.product_desc, d.category_name,  c.product_uniqueid, a.is_rma_processed, a.price, h.status_name,
                                                            i.sub_location_name, i.sub_location_type
                                                        FROM purchase_order_detail_receive a
                                                        INNER JOIN products c ON c.id = a.product_id
                                                        LEFT JOIN product_categories d ON d.id = c.product_category
                                                        LEFT JOIN inventory_status h ON h.id = a.inventory_status
                                                        LEFT JOIN warehouse_sub_locations i ON i.id = a.sub_location_id
                                                        INNER JOIN product_stock j ON j.receive_id = a.id 
                                                        WHERE a.enabled = 1 
                                                        AND a.po_id = '" . $id . "'
                                                        AND a.edit_lock = 1 
                                                    ) AS t1
                                                    WHERE id = '" . $detail_id . "'
                                                    ORDER BY  is_rma_processed, base_product_id, serial_no_barcode DESC ";
                                // echo $sql; 
                                $result_log2    = $db->query($conn, $sql);
                                $count_r2       = $db->counter($result_log2); ?>
                             <i class="material-icons prefix pt-1">add_shopping_cart</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" readonly disabled class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                        } ?>">
                                     <?php
                                        if ($count_r2 > 0) {
                                            $row_r2    = $db->fetch($result_log2);
                                            foreach ($row_r2 as $data_r2) {

                                                $detail_id_r1       = $data_r2['id'];
                                                $product_uniqueid_r1  = $data_r2['product_uniqueid'];  ?>

                                             <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                 <?php
                                                    echo $product_uniqueid_r1;
                                                    if ($data_r2['category_name'] != "") {
                                                        echo " (" . $data_r2['category_name'] . ")";
                                                    }
                                                    if ($data_r2['serial_no_barcode'] != "") {
                                                        echo ", Serial#: " . $data_r2['serial_no_barcode'] . " ";
                                                    }
                                                    if ($data_r2['status_name'] != "") {
                                                        echo ", Status: " . $data_r2['status_name'] . "";
                                                    }
                                                    if ($data_r2['sub_location_name'] != "") {
                                                        echo ", Location: " . $data_r2['sub_location_name'] . "";
                                                        if ($data_r2['sub_location_type'] != "") {
                                                            echo " (" . $data_r2['sub_location_type'] . ")";
                                                        }
                                                    }
                                                    echo " - ";
                                                    if ($data_r2['price'] != "") {
                                                        echo " PO Price: " . number_format($data_r2['price'], 2) . "";
                                                    } ?>
                                             </option>
                                     <?php
                                            }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red">* <?php
                                                                if (isset($error7[$field_name])) {
                                                                    echo $error7[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>
                     </div>
                     <br>
                     <div class="row">
                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "rc_price";
                                $field_label    = "Value";
                                ?>
                             <i class="material-icons prefix">attach_money</i>
                             <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                echo ${$field_name};
                                                                                                            } ?>" class="twoDecimalNumber validate  <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                    } ?>">
                             <label for="<?= $field_name; ?>">
                                 <?= $field_label; ?>
                                 <span class="color-red"> * <?php
                                                            if (isset($error2[$field_name])) {
                                                                echo $error2[$field_name];
                                                            } ?>
                                 </span>
                             </label>
                         </div>

                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "rc_status_id";
                                $field_label     = "Status";
                                $sql1             = "SELECT * FROM inventory_status WHERE enabled = 1 AND id IN(5,6) ORDER BY status_name ";
                                $result1         = $db->query($conn, $sql1);
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
                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['status_name']; ?> </option>
                                     <?php }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red">* <?php
                                                                if (isset($error2[$field_name])) {
                                                                    echo $error2[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>

                         <div class="input-field col m3 s12">
                             <?php
                                $field_name        = "rc_sub_location_id";
                                $field_label       = "Location";
                                $sql1              = "SELECT * FROM warehouse_sub_locations WHERE enabled = 1 ORDER BY sub_location_name ";
                                $result1           = $db->query($conn, $sql1);
                                $count1            = $db->counter($result1);
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
                                                 <?php
                                                    echo $data2['sub_location_name'];
                                                    if ($data2['sub_location_type'] != "") {
                                                        echo "(" . $data2['sub_location_type'] . ")";
                                                    } ?>
                                             </option>
                                     <?php }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red">* <?php
                                                                if (isset($error2[$field_name])) {
                                                                    echo $error2[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="input-field col m6 s12 text_align_right">
                             <?php if (access("add_perm") == 1) { ?>
                                 <button class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="update_logistics">Update</button>
                             <?php } ?>
                         </div>
                         <div class="input-field col m6 s12"><br>
                             <a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&cmd5=add&active_tab=tab5") ?>">Cancel</a>
                         </div>
                     </div>
                 </form>
             </div>
         <?php
            }
            $td_padding = "padding:5px 15px !important;";

            $sql            = " SELECT a.* FROM purchase_order_detail_logistics_receiving a 
                                WHERE a.enabled = 1
                                AND a.po_id = '" . $id . "' ";
            // echo $sql; 
            $result_log     = $db->query($conn, $sql);
            $count_log      = $db->counter($result_log);
            if ($count_log > 0) { ?>
             <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5" value="Y" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                 <input type="hidden" name="active_tab" value="tab5" />

                 <div class="card-panel custom_padding_card_content_table_top_bottom">
                     <div class="row">
                         <div class="col m6 s12">
                             <h6>
                                 Receive by Category
                                 <?php
                                    if ($is_tested_po == 'Yes') { ?>
                                     <span class="color-red">(Recommended)</span>
                                 <?php } ?>
                             </h6>
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
                             <div class="input-field col m12 s12"> </div>
                         </div>
                         <?php
                            $sql_r1     = "	SELECT c.product_category, d.category_name, sum(a.order_qty) as order_qty
                                            FROM purchase_order_detail a 
                                            INNER JOIN purchase_orders b ON b.id = a.po_id
                                            INNER JOIN products c ON c.id = a.product_id
                                            INNER JOIN product_categories d ON d.id = c.product_category
                                            WHERE 1=1 
                                            AND a.po_id = '" . $id . "' 
                                            AND a.enabled =1
                                            GROUP BY d.category_name
                                            ORDER BY d.category_name"; //echo $sql_cl;
                            $result_r1  = $db->query($conn, $sql_r1);
                            $count_r1   = $db->counter($result_r1);
                            if ($count_r1 > 0) { ?>
                             <div class="row">
                                 <div class="col s12">
                                     <table id="page-length-option1" class=" bordered addproducttable">
                                         <thead>
                                             <tr>
                                                 <?php
                                                    $headings = '   <th>Product Category</th>
                                                                    <th>Expected Receive</th>
                                                                    <th>Received Yet</th>
                                                                    <th>Receiving Qty<span class="color-red">*</span> </th>
                                                                    <th>Location<span class="color-red">*</span></th>
                                                                    <th>Package</th>
                                                                    <th>Package Qty</th>
                                                                    <th>Package Cost</th>
                                                                    <th>Package Location</th>';
                                                    echo $headings; ?>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php
                                                $i = 0;
                                                if ($count_r1 > 0) {
                                                    $row_cl_r1 = $db->fetch($result_r1);
                                                    foreach ($row_cl_r1 as $data_r1) {
                                                        $detail_id_r1       = $data_r1['product_category'];
                                                        $order_qty          = $data_r1['order_qty'];
                                                        $sql_rc1            = "	SELECT a.*
                                                                                FROM purchase_order_detail_receive a 
                                                                                WHERE 1=1 
                                                                                AND a.recevied_product_category =  '" . $detail_id_r1 . "'
                                                                                AND a.po_id = '" . $id . "' 
                                                                                AND a.enabled = 1 "; //echo $sql_rc1;
                                                        $result_rc1         = $db->query($conn, $sql_rc1);
                                                        $total_received_qty = $db->counter($result_rc1);  ?>
                                                     <tr>
                                                         <td style="width: 250px;">
                                                             <?php
                                                                if ($data_r1['category_name'] != '') {
                                                                    echo "" . $data_r1['category_name'] . "";
                                                                } else {
                                                                    echo "No Category";
                                                                }  ?>
                                                         </td>
                                                         <td style="width: 150px; text-align: center;"><?php echo $order_qty; ?></td>
                                                         <td style="width: 150px; text-align: center;"><?php echo $total_received_qty; ?></td>
                                                         <td style="width: 150px;">
                                                             <?php
                                                                $field_name             = "receiving_qties";
                                                                $field_label            = "Receiving Qty";
                                                                $receiving_qty_value    = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_qty_value = ${$field_name}[$detail_id_r1];
                                                                }
                                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && $receiving_qty_value == "") {
                                                                    $receiving_qty_value = 5;
                                                                }
                                                                if (isset($error5[$field_name][$detail_id_r1])) { ?>
                                                                 <span class="color-red"><?php echo $error5[$field_name][$detail_id_r1]; ?></span>
                                                             <?php } ?>
                                                             <input type="number" placeholder="<?= $field_label; ?>" class="" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $receiving_qty_value; ?>" style=" text-align: center;" />
                                                         </td>
                                                         <td style="width: 180px;">
                                                             <?php
                                                                $field_name             = "receiving_location";
                                                                $field_label            = "Location";
                                                                $receiving_location_val = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_location_val = ${$field_name}[$detail_id_r1];
                                                                }

                                                                $sql1       = " SELECT b.* FROM warehouse_sub_locations b 
                                                                                WHERE b.enabled = 1 
                                                                                 AND b.purpose != 'Arrival'
                                                                                ORDER BY b.sub_location_name ";
                                                                $result1    = $db->query($conn, $sql1);
                                                                $count1     = $db->counter($result1);

                                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && $receiving_location_val == "") {
                                                                    $receiving_location_val = 2289;
                                                                } ?>
                                                             <span class="color-red"><?php
                                                                                        if (isset($error5[$field_name][$detail_id_r1])) {
                                                                                            echo $error5[$field_name][$detail_id_r1];
                                                                                        } ?>
                                                             </span>
                                                             <select id="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                                                                                                                            } ?>">
                                                                 <?php
                                                                    if ($count1 > 1) { ?>
                                                                     <option value="">Select</option>
                                                                     <?php }
                                                                    if ($count1 > 0) {
                                                                        $row1    = $db->fetch($result1);
                                                                        foreach ($row1 as $data2) { ?>
                                                                         <option value="<?php echo $data2['id']; ?>" <?php if (isset($receiving_location_val) && $receiving_location_val == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                             <?php echo $data2['sub_location_name']; ?>
                                                                         </option>
                                                                 <?php }
                                                                    } ?>
                                                             </select>
                                                         </td>
                                                         <td>
                                                             <?php
                                                                $sql1           = "SELECT b.category_name, GROUP_CONCAT(' ',  c.product_uniqueid) AS product_uniqueids, a.*
                                                                                FROM packages a
                                                                                LEFT JOIN product_categories b ON b.id = a.product_category
                                                                                LEFT JOIN products c ON FIND_IN_SET(c.id, a.product_ids)
                                                                                WHERE a.enabled = 1 
                                                                                GROUP BY a.id
                                                                                ORDER BY a.package_name, b.category_name";
                                                                $result1        = $db->query($conn, $sql1);
                                                                $count1         = $db->counter($result1);

                                                                $field_name             = "package_ids";
                                                                $receiving_location_val = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_location_val = ${$field_name}[$detail_id_r1];
                                                                } ?>
                                                             <select id="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                                                                                                                            } ?>">
                                                                 <?php
                                                                    if ($count1 > 1) { ?>
                                                                     <option value="">Select Package</option>
                                                                     <?php }
                                                                    if ($count1 > 0) {
                                                                        $row1    = $db->fetch($result1);
                                                                        foreach ($row1 as $data2) { ?>
                                                                         <option value="<?php echo $data2['id']; ?>" <?php if (isset($receiving_location_val) && $receiving_location_val == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                             <?php echo $data2['package_name']; ?> (<?php echo $data2['category_name']; ?>) - <?php if ($data2['sku_code'] != "") {
                                                                                                                                                                    echo "SKU Code: " . $data2['sku_code'];
                                                                                                                                                                } ?>
                                                                         </option>
                                                                 <?php }
                                                                    } ?>
                                                             </select>
                                                         </td>
                                                         <td style="width: 150px;">
                                                             <?php
                                                                $field_name             = "package_qties";
                                                                $field_label            = "Package Qty";
                                                                $receiving_qty_value    = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_qty_value = ${$field_name}[$detail_id_r1];
                                                                }
                                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && $receiving_qty_value == "") {
                                                                    //$receiving_qty_value = 5;
                                                                }
                                                                if (isset($error5[$field_name][$detail_id_r1])) { ?>
                                                                 <span class="color-red"><?php echo $error5[$field_name][$detail_id_r1]; ?></span>
                                                             <?php } ?>
                                                             <input type="number" placeholder="<?= $field_label; ?>" class="" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $receiving_qty_value; ?>" style=" text-align: center;" />
                                                         </td>
                                                         <td style="width: 150px;">
                                                             <?php
                                                                $field_name             = "package_costs";
                                                                $field_label            = "Package Cost";
                                                                $receiving_qty_value    = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_qty_value = ${$field_name}[$detail_id_r1];
                                                                }
                                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && $receiving_qty_value == "") {
                                                                    // $receiving_qty_value = 5;
                                                                }
                                                                if (isset($error5[$field_name][$detail_id_r1])) { ?>
                                                                 <span class="color-red"><?php echo $error5[$field_name][$detail_id_r1]; ?></span>
                                                             <?php } ?>
                                                             <input type="text" placeholder="<?= $field_label; ?>" class="twoDecimalNumber" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $receiving_qty_value; ?>" style=" text-align: center;" />
                                                         </td>
                                                         <td style="width: 180px;">
                                                             <?php
                                                                $field_name             = "package_location";
                                                                $field_label            = "Location";
                                                                $receiving_location_val = "";

                                                                if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                    $receiving_location_val = ${$field_name}[$detail_id_r1];
                                                                }

                                                                $sql1       = " SELECT b.* FROM warehouse_sub_locations b 
                                                                                WHERE b.enabled = 1 
                                                                                 AND b.purpose != 'Arrival'
                                                                                ORDER BY b.sub_location_name ";
                                                                $result1    = $db->query($conn, $sql1);
                                                                $count1     = $db->counter($result1);

                                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && $receiving_location_val == "") {
                                                                    // $receiving_location_val = 2289;
                                                                } ?>
                                                             <span class="color-red"><?php
                                                                                        if (isset($error5[$field_name][$detail_id_r1])) {
                                                                                            echo $error5[$field_name][$detail_id_r1];
                                                                                        } ?>
                                                             </span>
                                                             <select id="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                                                                                                                            } ?>">
                                                                 <?php
                                                                    if ($count1 > 1) { ?>
                                                                     <option value="">Select</option>
                                                                     <?php }
                                                                    if ($count1 > 0) {
                                                                        $row1    = $db->fetch($result1);
                                                                        foreach ($row1 as $data2) { ?>
                                                                         <option value="<?php echo $data2['id']; ?>" <?php if (isset($receiving_location_val) && $receiving_location_val == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                             <?php echo $data2['sub_location_name']; ?>
                                                                         </option>
                                                                 <?php }
                                                                    } ?>
                                                             </select>
                                                         </td>
                                                     </tr>


                                             <?php
                                                        /*
                                                     $sql1       = "SELECT b.category_name, GROUP_CONCAT(' ',  c.product_uniqueid) AS product_uniqueids, a.*
                                                                    FROM packages a
                                                                    LEFT JOIN product_categories b ON b.id = a.product_category
                                                                    LEFT JOIN products c ON FIND_IN_SET(c.id, a.product_ids)
                                                                    WHERE a.enabled = 1 
                                                                    GROUP BY a.id
                                                                    ORDER BY a.package_name, b.category_name";
                                                    $result1    = $db->query($conn, $sql1);
                                                    $count1     = $db->counter($result1); ?>
                                                    <tr>
                                                        <td>
                                                            <select <?php echo $disabled;
                                                                    echo $readonly; ?> name="<?= $field_name ?>[]" id="<?= $field_id ?>" class="select2-theme browser-default select2-hidden-accessible product_packages <?= $field_name ?>_<?= $i ?>">
                                                                <option value="">Select a Package</option>
                                                                <?php
                                                                if ($count1 > 0) {
                                                                    $row1    = $db->fetch($result1);
                                                                    foreach ($row1 as $data2) { ?>
                                                                        <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['package_name']; ?> (<?php echo $data2['category_name']; ?>) - <?php if ($data2['sku_code'] != "") {
                                                                                                                                                                                                                                                                                                                                echo "SKU Code: " . $data2['sku_code'];
                                                                                                                                                                                                                                                                                                                            } ?></option>
                                                                <?php }
                                                                } ?>
                                                                <option value="package_add_modal">+Add New Package/Part</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            $field_name     = "order_part_qty";
                                                            $field_id       = "orderpartqty_" . $i;

                                                            if (isset($order_part_qty[$i - 1])) {
                                                                $sum_part_qty += $order_part_qty[$i - 1];
                                                            }
                                                            ?>
                                                            <input <?php echo $disabled;
                                                                    echo $readonly; ?> name="<?= $field_name; ?>[]" type="number" id="<?= $field_id; ?>" value="<?php if (isset(${$field_name}[$i - 1])) {
                                                                                                                                                                    echo ${$field_name}[$i - 1];
                                                                                                                                                                } ?>" class="validate custom_input order_part_qty">
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $field_name     = "order_part_price";
                                                            $field_id       = "orderpartprice_" . $i;
                                                            ?>
                                                            <input <?php echo $disabled;
                                                                    echo $readonly; ?> name="<?= $field_name; ?>[]" type="number" id="<?= $field_id; ?>" value="<?php if (isset(${$field_name}[$i - 1])) {
                                                                                                                                                                    echo ${$field_name}[$i - 1];
                                                                                                                                                                } ?>" class="validate custom_input order_part_price">
                                                        </td>
                                                        <td class="text_align_right">
                                                            <span id="part_value_<?= $i; ?>">
                                                                <?php
                                                                $part_value = 0;
                                                                if (isset($order_part_qty[$i - 1]) && isset($order_part_price[$i - 1])) {
                                                                    $part_value =  ($order_part_price[$i - 1] * $order_part_qty[$i - 1]);
                                                                    $sum_part_price += $order_part_price[$i - 1];
                                                                }
                                                                echo number_format($part_value, 2);
                                                                $sum_part_value += $part_value; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span id="case_pack_<?= $i; ?>"><?php if (isset($case_pack[$i - 1])) {
                                                                                                echo $case_pack[$i - 1];
                                                                                            } ?></span>
                                                        </td>
                                                        <td>
                                                            <span id="total_case_pack_<?= $i; ?>">
                                                                <?php
                                                                if (isset($case_pack[$i - 1]) && $case_pack[$i - 1] > 0 && isset($order_part_qty[$i - 1]) && $order_part_qty[$i - 1] > 0) {
                                                                    echo ceil($order_part_qty[$i - 1] / $case_pack[$i - 1]);
                                                                } ?>
                                                            </span>
                                                        </td>
                                                        <td colspan="3">
                                                            <?php
                                                            if (isset($stage_status) && $stage_status != "Committed") { ?>
                                                                <a class="remove-row-part btn-sm btn-floating waves-effect waves-light red" style="line-height: 32px;" id="removepartrow_<?= $i ?>" href="javascript:void(0)">
                                                                    <i class="material-icons dp48">cancel</i>
                                                                </a> &nbsp;
                                                                <a class="add-more add-more-part-btn btn-sm btn-floating waves-effect waves-light cyan" style="line-height: 32px; display:none;" id="addpartmore_<?= $i ?>" href="javascript:void(0)">
                                                                    <i class="material-icons dp48">add_circle</i>
                                                                </a>&nbsp;&nbsp;
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                             <?php 
                                             */
                                                        $i++;
                                                    }
                                                } ?>
                                     </table>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"></div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12 text_align_center">
                                     <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                         <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Receive</button>
                                     <?php } ?>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="input-field col m12 s12"></div>
                             </div>
                         <?php } else { ?>
                             <div class="card-panel custom_padding_card_content_table_top_bottom">
                                 <div class="row">
                                     <div class="col 24 s12"><br>
                                         <div class="card-alert card red lighten-5">
                                             <div class="card-content red-text">
                                                 <p>Please add product in PO. </p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         <?php } ?>
                     </div>
                 </div>
             </form>

             <?php /*?>
             <form id="barcodeForm" class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5_2" value="Y" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
            <?php */ ?>
             <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">

             <div class="card-panel custom_padding_card_content_table_top_bottom">
                 <div class="row">
                     <div class="col m6 s12">
                         <h6>
                             Receive from BarCode
                             <?php
                                $sql_vd             = "SELECT a.*  FROM vender_po_data a WHERE a.enabled = 1 AND a.po_id = '" . $id . "'";
                                $result_log_vd      = $db->query($conn, $sql_vd);
                                $total_vender_date  = $db->counter($result_log_vd);
                                if ($is_tested_po == 'No' && isset($total_vender_date) && $total_vender_date > 0) { ?>
                                 <span class="color-red">(Recommended)</span>
                             <?php } ?>
                         </h6>
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
                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "sub_location_id_barcode";
                                $field_label    = "Device Location";
                                $sql1           = " SELECT b.*
                                                    FROM warehouse_sub_locations  b
                                                    WHERE b.enabled = 1  
                                                    AND b.purpose != 'Arrival'
                                                    ORDER BY b.sub_location_name ";
                                $result1        = $db->query($conn, $sql1);
                                $count1         = $db->counter($result1);
                                ?>
                             <i class="material-icons prefix">question_answer</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <?php
                                        if ($count1 > 1) { ?>
                                         <option value="">Select</option>
                                         <?php }
                                        if ($count1 > 0) {
                                            $row1    = $db->fetch($result1);
                                            foreach ($row1 as $data2) { ?>
                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data2['sub_location_name'];
                                                    if ($data2['sub_location_type'] != "") {
                                                        echo " (" . ucwords(strtolower($data2['sub_location_type'])) . ")";
                                                    }
                                                    if ($data2['purpose'] != "") {
                                                        echo " - " . ucwords(strtolower($data2['purpose'])) . "";
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
                         <div class="input-field col m3 s12">
                             <?php
                                $sql1           = "SELECT b.category_name, GROUP_CONCAT(' ',  c.product_uniqueid) AS product_uniqueids, a.*
                                                FROM packages a
                                                LEFT JOIN product_categories b ON b.id = a.product_category
                                                LEFT JOIN products c ON FIND_IN_SET(c.id, a.product_ids)
                                                WHERE a.enabled = 1 
                                                GROUP BY a.id
                                                ORDER BY a.package_name, b.category_name";
                                $result1        = $db->query($conn, $sql1);
                                $count1         = $db->counter($result1);
                                $field_name     = "package_id_bar_code";
                                $field_label    = "Package";
                                ?>
                             <i class="material-icons prefix">question_answer</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <?php
                                        if ($count1 > 1) { ?>
                                         <option value="">Select</option>
                                         <?php }
                                        if ($count1 > 0) {
                                            $row1    = $db->fetch($result1);
                                            foreach ($row1 as $data2) { ?>
                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data2['package_name']; ?> (<?php echo $data2['category_name']; ?>) - <?php if ($data2['sku_code'] != "") {
                                                                                                                                        echo "SKU Code: " . $data2['sku_code'];
                                                                                                                                    } ?>
                                             </option>
                                     <?php }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red"><?php
                                                                if (isset($error5[$field_name])) {
                                                                    echo $error5[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>

                         <div class="input-field col m3 s12">
                             <?php
                                $sql1           = "SELECT b.* 
                                                FROM warehouse_sub_locations b 
                                                WHERE b.enabled = 1 
                                                AND b.purpose != 'Arrival'
                                                ORDER BY b.sub_location_name";
                                $result1        = $db->query($conn, $sql1);
                                $count1         = $db->counter($result1);
                                $field_name     = "package_location_bar_code";
                                $field_label    = "Package Location";
                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && !isset($package_location)) {
                                    // $package_location = 2289;
                                }
                                ?>
                             <i class="material-icons prefix">question_answer</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <?php
                                        if ($count1 > 1) { ?>
                                         <option value="">Select</option>
                                         <?php }
                                        if ($count1 > 0) {
                                            $row1    = $db->fetch($result1);
                                            foreach ($row1 as $data2) { ?>
                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data2['sub_location_name']; ?>
                                             </option>
                                     <?php }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red"><?php
                                                                if (isset($error5[$field_name])) {
                                                                    echo $error5[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>
                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "package_qty_bar_code";
                                $field_label    = "Package Qty";
                                ?>
                             <i class="material-icons prefix">description</i>
                             <input id="<?= $field_name; ?>" type="number" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                    echo ${$field_name};
                                                                                                                } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                        } ?>">
                             <label for="<?= $field_name; ?>">
                                 <?= $field_label; ?>
                                 <span class="color-red"><?php
                                                            if (isset($error5[$field_name])) {
                                                                echo $error5[$field_name];
                                                            } ?>
                                 </span>
                             </label>
                         </div>
                     </div>
                     <div class="row"><br></div>
                     <div class="row">
                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "package_cost_bar_code";
                                $field_label    = "Package Cost";
                                ?>
                             <i class="material-icons prefix">description</i>
                             <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                echo ${$field_name};
                                                                                                            } ?>" class="twoDecimalNumber validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                    } ?>">
                             <label for="<?= $field_name; ?>">
                                 <?= $field_label; ?>
                                 <span class="color-red"><?php
                                                            if (isset($error5[$field_name])) {
                                                                echo $error5[$field_name];
                                                            } ?>
                                 </span>
                             </label>
                         </div>
                         <div class="input-field col m3 s12">
                             <?php
                                $field_name     = "serial_no_barcode";
                                $field_label    = "Device BarCode";
                                $sql            = " SELECT a.*, COUNT(b.id) AS total_received
                                                FROM vender_po_data a  
                                                LEFT JOIN purchase_order_detail_receive b ON b.po_id = a.po_id AND b.serial_no_barcode = a.serial_no
                                                WHERE a.enabled = 1
                                                AND a.po_id = '" . $id . "'
                                                GROUP BY a.serial_no
                                                HAVING COUNT(b.id) = 0 ";
                                $result_log2    = $db->query($conn, $sql);
                                $count_r2       = $db->counter($result_log2); ?>
                             <i class="material-icons prefix pt-1">add_shopping_cart</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <option value="">Select</option>
                                     <?php
                                        if ($count_r2 > 0) {
                                            $row_r2    = $db->fetch($result_log2);
                                            if ($count_r2 > 1 && $_SERVER['HTTP_HOST'] != HTTP_HOST_IP) { ?>

                                         <?php }
                                            foreach ($row_r2 as $data_r2) { ?>
                                             <option value="<?php echo $data_r2['serial_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['serial_no']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data_r2['serial_no']; ?>
                                             </option>
                                     <?php
                                            }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red"> * <?php
                                                                if (isset($error5[$field_name])) {
                                                                    echo $error5[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div>

                         <?php /*?>
                             <div class="input-field col m6 s12">
                                 <?php
                                    $field_name     = "product_id_barcode";
                                    $field_label    = "Product ID";

                                    $sql            = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid
                                                    FROM purchase_order_detail a 
                                                    INNER JOIN purchase_orders b ON b.id = a.po_id
                                                    INNER JOIN products c ON c.id = a.product_id
                                                    INNER JOIN product_categories d ON d.id = c.product_category
                                                    WHERE 1=1 
                                                    AND a.po_id = '" . $id . "' 
                                                    AND a.enabled = 1
                                                    ORDER BY c.product_uniqueid, a.product_condition ";
                                    // echo $sql; 
                                    $result_log2    = $db->query($conn, $sql);
                                    $count_r2       = $db->counter($result_log2);
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
                                                        echo "" . $data_r2['product_uniqueid'];
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
                                         <span class="color-red"><?php
                                                                    if (isset($error5[$field_name])) {
                                                                        echo $error5[$field_name];
                                                                    } ?>
                                         </span>
                                     </label>
                                 </div>
                             </div>
                             <?php */ ?>
                         <div class="input-field col m1 s12">
                             <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                 <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add" id="receive_using_barcode_btn">Receive</button>
                             <?php } ?>
                         </div>
                     </div>
                     <div class="row">
                         <div class="input-field col m12 s12"></div>
                     </div>
                 </div>
             </div>
             <?php /*?>
             </form> 
             <?php */ ?>

             <form id="fakeserialno" class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab6_2_2" id="is_Submit_tab6_2_2" value="Y" />
                 <input type="hidden" name="cmd6" value="<?php if (isset($cmd6)) echo $cmd6; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">

                 <div class="card-panel custom_padding_card_content_table_top_bottom">
                     <div class="row">
                         <div class="col m6 s12">
                             <h6>Generate Serial# </h6>
                         </div>
                         <div class="col m3 s12 show_fake_serial_no_show_btn_tab6" style="<?php if (isset($is_Submit_tab6_2_2) && $is_Submit_tab6_2_2 == 'Y') {
                                                                                                echo "display: none;";
                                                                                            } else {;
                                                                                            } ?>">
                             <a href="javascript:void(0)" class="show_fake_serial_no_section_tab6">Show Form</a>
                         </div>
                         <div class="col m3 s12 show_fake_serial_no_hide_btn_tab6" style="<?php if (isset($is_Submit_tab6_2_2) && $is_Submit_tab6_2_2 == 'Y') {;
                                                                                            } else {
                                                                                                echo "display: none;";
                                                                                            } ?>">
                             <a href="javascript:void(0)" class="hide_fake_serial_no_section_tab6">Hide Form</a>
                         </div>
                     </div>
                     <div id="fake_serial_no_section_tab6" style="<?php if (isset($is_Submit_tab6_2_2) && $is_Submit_tab6_2_2 == 'Y') {;
                                                                    } else {
                                                                        echo "display: none;";
                                                                    } ?>">
                         <br>
                         <div class="row">
                             <div class="input-field col m8 s12">
                                 <?php
                                    $field_name     = "product_id_generate";
                                    $field_label    = "Product ID";
                                    $sql            = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid, e.status_name
                                                        FROM purchase_order_detail a 
                                                        INNER JOIN purchase_orders b ON b.id = a.po_id
                                                        INNER JOIN products c ON c.id = a.product_id
                                                        INNER JOIN product_categories d ON d.id = c.product_category
                                                        LEFT JOIN inventory_status e ON e.id = a.expected_status
                                                        WHERE 1=1 
                                                        AND a.po_id = '" . $id . "' 
                                                        AND a.enabled = 1
                                                        AND a.is_fk_serial_generated = 0
                                                        ORDER BY c.product_uniqueid, a.product_condition, e.status_name "; // echo $sql; 
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
                                                foreach ($row_r2 as $data_r2) { ?>
                                                 <option value="<?php echo $data_r2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['id']) { ?> selected="selected" <?php } ?>>
                                                     <?php
                                                        echo " " . $data_r2['product_uniqueid'];
                                                        if ($data_r2['category_name'] != "") {
                                                            echo " (" . $data_r2['category_name'] . ") - ";
                                                        }
                                                        if ($data_r2['status_name'] != "") {
                                                            echo " Status: " . $data_r2['status_name'] . "";
                                                        }
                                                        if ($data_r2['product_condition'] != "") {
                                                            echo ", Condition: " . $data_r2['product_condition'] . "";
                                                        }
                                                        if ($data_r2['order_price'] != "") {
                                                            echo ", Price: " . $data_r2['order_price'] . "";
                                                        }
                                                        ?>
                                                 </option>
                                         <?php
                                                }
                                            } ?>
                                     </select>
                                     <label for="<?= $field_name; ?>">
                                         <?= $field_label; ?>
                                         <span class="color-red"> * <?php
                                                                    if (isset($error6[$field_name])) {
                                                                        echo $error6[$field_name];
                                                                    } ?>
                                         </span>
                                     </label>
                                 </div>
                             </div>
                             <div class="input-field col m2 s12">
                                 <?php
                                    $field_name     = "received_qty";
                                    $field_label    = "Total Received";
                                    ?>
                                 <i class="material-icons prefix">description</i>
                                 <input id="<?= $field_name; ?>" type="number" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                    echo ${$field_name};
                                                                                                                } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                        } ?>">
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red">* <?php
                                                                if (isset($error6[$field_name])) {
                                                                    echo $error6[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                             <div class="input-field col m2 s12 ">
                                 <?php if (isset($id) && $id > 0 && (($cmd6 == 'add' || $cmd6 == '') && access("add_perm") == 1)  || ($cmd6 == 'edit' && access("edit_perm") == 1) || ($cmd6 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Generate</button>
                                 <?php } ?>
                             </div>
                         </div>
                     </div>
                 </div>
             </form>
             <form id="receiving_manual" class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                 <input type="hidden" name="is_Submit_tab5_5" value="Y" />
                 <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                 <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                 <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                 <input type="hidden" name="active_tab" value="tab5" />

                 <div class="card-panel custom_padding_card_content_table_top_bottom">
                     <div class="row">
                         <div class="col m6 s12">
                             <h6> Receive by Adding Serial Numbers Manually</h6>
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
                                 <div class="input-field col m8 s12">
                                     <?php
                                        $field_name     = "product_id_manual";
                                        $field_label    = "Product ID";

                                        $sql            = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid, e1.status_name
                                                        FROM purchase_order_detail a 
                                                        INNER JOIN purchase_orders b ON b.id = a.po_id
                                                        INNER JOIN products c ON c.id = a.product_id
                                                        INNER JOIN product_categories d ON d.id = c.product_category
                                                        LEFT JOIN inventory_status e1 ON e1.id = a.expected_status
                                                        WHERE 1=1 
                                                        AND a.po_id = '" . $id . "' 
                                                        AND a.enabled = 1
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
                                                            echo "" . $data_r2['product_uniqueid'];
                                                            if ($data_r2['category_name'] != "") {
                                                                echo " (" . $data_r2['category_name'] . ") - ";
                                                            }
                                                            if ($data_r2['status_name'] != "") {
                                                                echo " Status: " . $data_r2['status_name'] . "";
                                                            }
                                                            if ($data_r2['product_condition'] != "") {
                                                                echo ", Condition: " . $data_r2['product_condition'] . "";
                                                            }
                                                            if ($data_r2['order_price'] != "") {
                                                                echo ", Price: " . $data_r2['order_price'] . "";
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
                                 <div class="input-field col m4 s12">
                                     <?php
                                        $field_name     = "sub_location_id_manual";
                                        $field_label    = "Location";
                                        $sql1           = " SELECT * FROM warehouse_sub_locations a 
                                                            WHERE a.enabled = 1 
                                                            AND a.purpose != 'Arrival' 
                                                            ORDER BY sub_location_name ";
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
                                                            }
                                                            if ($data2['purpose'] != "") {
                                                                echo " - " . ucwords(strtolower($data2['purpose'])) . "";
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
                                        // Filter out empty values from the array
                                        $filtered = array_filter($serial_no_manual, function ($value) {
                                            return !empty($value); // Keep only non-empty values
                                        });
                                        // Check if there are any non-empty values
                                        if (!empty($filtered)) {
                                            $max = sizeof($filtered) - 1;
                                        }
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
                                         <a href="javascript:void(0)" style="<?= $style2; ?> font-size: 30px;" class="add_<?= $field_name; ?> add_<?= $field_name; ?>_<?= $i2; ?>" id="add_<?= $field_name; ?>^<?= $i2; ?>">+</a>
                                         &nbsp;
                                         <a href="javascript:void(0)" style="<?= $style; ?> font-size: 30px;" class="minus_<?= $field_name; ?> minus_<?= $field_name; ?>_<?= $i2; ?>" id="minus_<?= $field_name; ?>^<?= $i2; ?>">-</a>
                                     </div>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12 text_align_center">
                                 <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Receive by Manual Serial Numbers</button>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </div>
             </form>
             <?php
                //*/
                $sql_r1     = "	SELECT  aa.id, b.package_name,c.category_name AS package_material_category_name, aa.order_qty AS package_material_qty
                                FROM purchase_order_packages_detail aa
                                INNER JOIN purchase_order_detail a ON a.po_id = aa.po_id
                                INNER JOIN packages b ON b.id = aa.package_id
                                INNER JOIN product_categories c ON c.id = b.product_category
                                INNER JOIN products d ON d.id = a.product_id
                                INNER JOIN product_categories e ON e.id = d.product_category
                                WHERE a.enabled = 1 
                                AND a.po_id = '$id' 
                                GROUP BY b.package_name, c.category_name , aa.order_qty
                                ORDER BY b.package_name, c.category_name , aa.order_qty"; //echo $sql_cl;
                $result_r1  = $db->query($conn, $sql_r1);
                $count_r1   = $db->counter($result_r1);
                if ($count_r1 > 0) { ?>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_6" value="Y" />
                     <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                     <input type="hidden" name="active_tab" value="tab5" />
                     <?php
                        $sql        = " SELECT a.*, c.status_name, d.sub_location_name, d.sub_location_type
                                        FROM purchase_order_detail_logistics a
                                        INNER JOIN purchase_order_detail_logistics_receiving a1 ON a1.logistics_id = a.id
                                        LEFT JOIN inventory_status c ON c.id = a.logistics_status
                                        LEFT JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                                        WHERE a.po_id = '" . $id . "'
                                        ORDER BY a.tracking_no ";
                        // echo $sql; 
                        $result_log     = $db->query($conn, $sql);
                        $count_log      = $db->counter($result_log);
                        if ($count_log > 0) { ?>
                         <div class="card-panel custom_padding_card_content_table_top_bottom">
                             <div class="row">
                                 <div class="col m6 s12">
                                     <h6>Receive Package Materials in PO</h6>
                                 </div>
                                 <div class="col m6 s12 show_receive_package_materials_show_btn" style="<?php if (isset($is_Submit_tab5_6) && $is_Submit_tab5_6 == 'Y') {
                                                                                                            echo "display: none;";
                                                                                                        } else {;
                                                                                                        } ?>">
                                     <a href="javascript:void(0)" class="show_receive_package_materials_section">Show Form</a>
                                 </div>
                                 <div class="col m6 s12 show_receive_package_materials_hide_btn" style="<?php if (isset($is_Submit_tab5_6) && $is_Submit_tab5_6 == 'Y') {;
                                                                                                        } else {
                                                                                                            echo "display: none;";
                                                                                                        } ?>">
                                     <a href="javascript:void(0)" class="hide_receive_package_materials_section">Hide Form</a>
                                 </div>
                             </div>
                             <div id="receive_package_materials_section" style="<?php if (isset($is_Submit_tab5_6) && $is_Submit_tab5_6 == 'Y') {;
                                                                                } else {
                                                                                    echo "display: none;";
                                                                                } ?>">

                                 <div class="row">
                                     <div class="input-field col m12 s12"> </div>
                                 </div>
                                 <div class="row">
                                     <div class="col s12">
                                         <table id="page-length-option1" class="bordered addproducttable">
                                             <thead>
                                                 <tr>
                                                     <?php
                                                        $headings = '   <th>Package Materials</th>
                                                                        <th>Category</th>
                                                                        <th>Qty</th>
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
                                                            $detail_id_r1           = $data_r1['id'];
                                                            $package_material_qty   = $data_r1['package_material_qty'];
                                                            $sql_rc1            = "	SELECT a.* 
                                                                                        FROM purchase_order_detail_receive_package_material a 
                                                                                        WHERE 1=1 
                                                                                        AND a.po_detail_id = '" . $detail_id_r1 . "'
                                                                                        AND a.enabled = 1 "; //echo $sql_cl;
                                                            $result_rc1         = $db->query($conn, $sql_rc1);
                                                            $total_received_qty = $db->counter($result_rc1);  ?>
                                                         <tr>
                                                             <td style="width: 400px;">
                                                                 <?php echo $data_r1['package_name']; ?>
                                                             </td>
                                                             <td style="width: 400px;">
                                                                 <?php
                                                                    if ($data_r1['package_material_category_name'] != '') {
                                                                        echo " " . $data_r1['package_material_category_name'] . "";
                                                                    } ?>
                                                             </td>
                                                             <td style="width: 150px; text-align: center;"><?php echo $package_material_qty; ?></td>
                                                             <td style="width: 180px; text-align: center;"><?php echo $total_received_qty; ?></td>
                                                             <td style="width: 150px;">
                                                                 <?php
                                                                    $field_name             = "receiving_qties2";
                                                                    $field_label            = "Receiving Qty";
                                                                    $receiving_qty_value    = $total_received_qty ?? "";

                                                                    if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                        $receiving_qty_value = ${$field_name}[$detail_id_r1];
                                                                    }

                                                                    if (isset($error5[$field_name])) { ?>
                                                                     <span class="color-red"><?php
                                                                                                echo $error5[$field_name]; ?>
                                                                     </span>
                                                                 <?php
                                                                    } ?>

                                                                 <input type="hidden" name="previous_<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $total_received_qty; ?>" style=" text-align: center;" />
                                                                 <input type="number" placeholder="<?= $field_label; ?>" class="" name="<?= $field_name; ?>[<?= $detail_id_r1; ?>]" value="<?= $total_received_qty; ?>" style=" text-align: center;" />
                                                             </td>

                                                             <td style="width: 200px;">
                                                                 <?php
                                                                    $field_name             = "receiving_location2";
                                                                    $field_label            = "Location";
                                                                    $receiving_location_val = "";

                                                                    if (isset(${$field_name}[$detail_id_r1]) && ${$field_name}[$detail_id_r1] > 0) {
                                                                        $receiving_location_val = ${$field_name}[$detail_id_r1];
                                                                    }
                                                                    $sql1       = " SELECT * FROM warehouse_sub_locations a 
                                                                                    WHERE a.enabled = 1 
                                                                                    AND a.purpose != 'Arrival'
                                                                                    ORDER BY a.sub_location_name ";
                                                                    $result1    = $db->query($conn, $sql1);
                                                                    $count1     = $db->counter($result1);
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
                                                                                    }
                                                                                    if ($data2['purpose'] != "") {
                                                                                        echo " - " . ucwords(strtolower($data2['purpose'])) . "";
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

                                 <div class="row">
                                     <div class="input-field col m12 s12"></div>
                                 </div>
                                 <div class="row">
                                     <div class="input-field col m12 s12 text_align_center">
                                         <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                             <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Receive Package Materials</button>
                                         <?php } ?>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="input-field col m12 s12"></div>
                                 </div>
                             </div>
                         </div>
                     <?php
                        } else { ?>
                         <div class="card-panel custom_padding_card_content_table_top_bottom">
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
             <?php }
                /*?>
                <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                    <input type="hidden" name="is_Submit_tab6_5" value="Y" />
                    <input type="hidden" name="cmd6" value="<?php if (isset($cmd6)) echo $cmd6; ?>" />
                    <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                    <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
    
                    <div class="card-panel custom_padding_card_content_table_top_bottom">
                        <div class="row">
                            <div class="col m6 s12">
                                <h6>Update Serial Numbers Manually</h6>
                            </div>
                            <div class="col m3 s12 show_receive_as_manual_barcodes_show_btn_tab6" style="<?php if (isset($is_Submit_tab6_5) && $is_Submit_tab6_5 == 'Y') {
                                                                                                                echo "display: none;";
                                                                                                            } else {;
                                                                                                            } ?>">
                                <a href="javascript:void(0)" class="show_receive_as_manual_barcodes_section_tab6">Show Form</a>
                            </div>
                            <div class="col m3 s12 show_receive_as_manual_barcodes_hide_btn_tab6" style="<?php if (isset($is_Submit_tab6_5) && $is_Submit_tab6_5 == 'Y') {;
                                                                                                            } else {
                                                                                                                echo "display: none;";
                                                                                                            } ?>">
                                <a href="javascript:void(0)" class="hide_receive_as_manual_barcodes_section_tab6">Hide Form</a>
                            </div>
                        </div>
                        <div id="receive_as_manual_barcodes_section_tab6" style="<?php if (isset($is_Submit_tab6_5) && $is_Submit_tab6_5 == 'Y') {;
                                                                                    } else {
                                                                                        echo "display: none;";
                                                                                    } ?>">
                            <div class="row">
                                <div class="input-field col m12 s12"> </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m8 s12">
                                    <?php
                                    $field_name     = "product_id_manual_diagnostic";
                                    $field_label    = "Product ID";
                                    $sql            = " SELECT a.*, c.product_desc, d.category_name, c.product_uniqueid
                                                        FROM purchase_order_detail a 
                                                        INNER JOIN purchase_orders b ON b.id = a.po_id
                                                        INNER JOIN products c ON c.id = a.product_id
                                                        INNER JOIN product_categories d ON d.id = c.product_category
                                                        WHERE 1=1 
                                                        AND a.enabled = 1
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
                                                        echo "" . $data_r2['product_uniqueid'];
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
                                                                        if (isset($error6[$field_name])) {
                                                                            echo $error6[$field_name];
                                                                        } ?>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="input-field col m4 s12">
                                    <?php
                                    $field_name     = "sub_location_id_manual_diagnostic";
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
                                                                        if (isset($error6[$field_name])) {
                                                                            echo $error6[$field_name];
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
                                if (isset($serial_no_manual_diagnostic)) {
                                    $serial_no_manual_diagnostic = array_filter($serial_no_manual_diagnostic);
                                    $max = sizeof($serial_no_manual_diagnostic) - 1;
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
                                    <div class="input-field col m3 s12 serial_no_manual_diagnostic_input_<?= $i2; ?>" style="<?= $style; ?>">
                                        <?php
                                        $field_name     = "serial_no_manual_diagnostic";
                                        $field_id       = $field_name . "_" . $i2;
                                        $field_label    = "Serial No";
                                        ?>
                                        <i class="material-icons prefix">description</i>
                                        <input id="<?= $field_id; ?>" type="text" name="<?= $field_name; ?>[]" value="<?php if (isset($serial_no_manual_diagnostic[$i])) {
                                                                                                                            echo $serial_no_manual_diagnostic[$i];
                                                                                                                        } ?>" class="validate ">
                                        <label for="<?= $field_id; ?>">
                                            <?= $field_label; ?>
                                            <span class="color-red">* <?php
                                                                        if (isset($error6["field_name_" . $i2])) {
                                                                            echo $error6["field_name_" . $i2];
                                                                        } ?>
                                            </span>
                                        </label>
                                    </div>
                                    <div style="<?= $style; ?>" class=" input-field col m1 s12 button_div_serial_no_manual_diagnostic" id="button_div_serial_no_manual_diagnostic_<?= $i2; ?>">
                                        <a href="#." style="<?= $style2; ?> font-size: 30px;" class="add_<?= $field_name; ?> add_<?= $field_name; ?>_<?= $i2; ?>" id="add_<?= $field_name; ?>^<?= $i2; ?>">+</a>
                                        &nbsp;
                                        <a href="#." style="<?= $style; ?> font-size: 30px;" class="minus_<?= $field_name; ?> minus_<?= $field_name; ?>_<?= $i2; ?>" id="minus_<?= $field_name; ?>^<?= $i2; ?>">-</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="input-field col m12 s12 text_align_center">
                                    <?php if (isset($id) && $id > 0 && (($cmd6 == 'add' || $cmd6 == '') && access("add_perm") == 1)  || ($cmd6 == 'edit' && access("edit_perm") == 1) || ($cmd6 == 'delete' && access("delete_perm") == 1)) { ?>
                                        <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Update</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m12 s12"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php */ ?>
             <?php
                /*
                if (isset($all_deduct_info) && sizeof($all_deduct_info) > 0) { ?>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_4" value="Y" />
                     <input type="hidden" name="cmd5" value="<?php if (isset($cmd5)) echo $cmd5; ?>" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                     <input type="hidden" name="product_id_barcode_deduct" value="<?php if (isset($product_id_barcode_deduct)) echo $product_id_barcode_deduct; ?>" />
                     <input type="hidden" name="is_Submit_tab5_3" value="Y" />
                     <input type="hidden" name="active_tab" value="tab5" />
                     <div class="card-panel custom_padding_card_content_table_top_bottom">
                         <div class="row">
                             <div class="col m4 s12">
                                 <h6>Connect Devices Deduct Info</h6>
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
                             <div class="input-field col m12 s12 text_align_center">
                                 <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                     <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="deduct2">Update Deduct Serial Numbers</button>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </form>
             <?php }
             */ ?>
             <div class="card-panel custom_padding_card_content_table_top_bottom">
                 <div class="row">
                     <div class="col m6 s12">
                         <h6>Receive Package Material From Category</h6>
                     </div>
                     <div class="col m6 s12 show_receive_packages_from_category_show_btn" style="<?php if (isset($is_Submit_tab5_7) && $is_Submit_tab5_7 == 'Y') {
                                                                                                        echo "display: none;";
                                                                                                    } else {;
                                                                                                    } ?>">
                         <a href="javascript:void(0)" class="show_receive_packages_from_category_section">Show Form</a>
                     </div>
                     <div class="col m6 s12 show_receive_packages_from_category_hide_btn" style="<?php if (isset($is_Submit_tab5_7) && $is_Submit_tab5_7 == 'Y') {;
                                                                                                    } else {
                                                                                                        echo "display: none;";
                                                                                                    } ?>">
                         <a href="javascript:void(0)" class="hide_receive_packages_from_category_section">Hide Form</a>
                     </div>
                 </div>
                 <div id="receive_packages_from_category_section" style="<?php if (isset($is_Submit_tab5_7) && $is_Submit_tab5_7 == 'Y') {;
                                                                            } else {
                                                                                echo "display: none;";
                                                                            } ?>">
                     <div class="row">
                         <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                             <input type="hidden" name="is_Submit_tab5_7" value="Y" />
                             <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                                echo encrypt($_SESSION['csrf_session']);
                                                                            } ?>">
                             <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                             <div class="card-panel custom_padding_card_content_table_top_bottom">
                                 <div class="row">
                                     <div class="input-field col m12 s12"> </div>
                                 </div>
                                 <div class="row">
                                     <div class="input-field col m12 s12"> </div>
                                 </div>
                                 <?php
                                    $sql_r1     = "	SELECT c.product_category, d.category_name, sum(a.order_qty) as order_qty
                                                FROM purchase_order_detail a 
                                                INNER JOIN purchase_orders b ON b.id = a.po_id
                                                INNER JOIN products c ON c.id = a.product_id
                                                INNER JOIN product_categories d ON d.id = c.product_category
                                                WHERE 1=1 
                                                AND a.po_id = '" . $id . "' 
                                                AND a.enabled =1
                                                GROUP BY d.category_name
                                                ORDER BY d.category_name"; //echo $sql_cl;
                                    $result_r1  = $db->query($conn, $sql_r1);
                                    $count_r1   = $db->counter($result_r1);
                                    if ($count_r1 > 0) { ?>
                                     <div class="row">
                                         <div class="input-field col m2 s12">
                                             <?php
                                                $field_name     = "receive_package_category_id";
                                                $field_label    = "Category";
                                                ?>
                                             <i class="material-icons prefix">question_answer</i>
                                             <div class="select2div">
                                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                                } ?>">
                                                     <?php
                                                        if ($count_r1 > 1) { ?>
                                                         <option value="">Select</option>
                                                         <?php }
                                                        if ($count_r1 > 0) {
                                                            $row1    = $db->fetch($result_r1);
                                                            foreach ($row1 as $data2) { ?>
                                                             <option value="<?php echo $data2['product_category']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['product_category']) { ?> selected="selected" <?php } ?>>
                                                                 <?php echo $data2['category_name']; ?>
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
                                                $sql1           = "SELECT b.category_name, GROUP_CONCAT(' ',  c.product_uniqueid) AS product_uniqueids, a.*
                                                                FROM packages a
                                                                LEFT JOIN product_categories b ON b.id = a.product_category
                                                                LEFT JOIN products c ON FIND_IN_SET(c.id, a.product_ids)
                                                                WHERE a.enabled = 1 
                                                                GROUP BY a.id
                                                                ORDER BY a.package_name, b.category_name";
                                                $result1        = $db->query($conn, $sql1);
                                                $count1         = $db->counter($result1);
                                                $field_name     = "package_id";
                                                $field_label    = "Package";
                                                ?>
                                             <i class="material-icons prefix">question_answer</i>
                                             <div class="select2div">
                                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                                } ?>">
                                                     <?php
                                                        if ($count1 > 1) { ?>
                                                         <option value="">Select</option>
                                                         <?php }
                                                        if ($count1 > 0) {
                                                            $row1    = $db->fetch($result1);
                                                            foreach ($row1 as $data2) { ?>
                                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                 <?php echo $data2['package_name']; ?> (<?php echo $data2['category_name']; ?>) - <?php if ($data2['sku_code'] != "") {
                                                                                                                                                        echo "SKU Code: " . $data2['sku_code'];
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
                                         <div class="input-field col m2 s12">
                                             <?php
                                                $field_name     = "package_qty";
                                                $field_label    = "Package Qty";
                                                ?>
                                             <i class="material-icons prefix">description</i>
                                             <input id="<?= $field_name; ?>" type="number" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                                    echo ${$field_name};
                                                                                                                                } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                        } ?>">
                                             <label for="<?= $field_name; ?>">
                                                 <?= $field_label; ?>
                                                 <span class="color-red">* <?php
                                                                            if (isset($error5[$field_name])) {
                                                                                echo $error5[$field_name];
                                                                            } ?>
                                                 </span>
                                             </label>
                                         </div>
                                         <div class="input-field col m2 s12">
                                             <?php
                                                $field_name     = "package_cost";
                                                $field_label    = "Package Cost";
                                                ?>
                                             <i class="material-icons prefix">description</i>
                                             <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                                echo ${$field_name};
                                                                                                                            } ?>" class="twoDecimalNumber validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                        echo ${$field_name . "_valid"};
                                                                                                                                                                    } ?>">
                                             <label for="<?= $field_name; ?>">
                                                 <?= $field_label; ?>
                                                 <span class="color-red">* <?php
                                                                            if (isset($error5[$field_name])) {
                                                                                echo $error5[$field_name];
                                                                            } ?>
                                                 </span>
                                             </label>
                                         </div>

                                         <div class="input-field col m2 s12">
                                             <?php
                                                $sql1           = "SELECT b.* 
                                                                FROM warehouse_sub_locations b 
                                                                WHERE b.enabled = 1 
                                                                AND b.purpose != 'Arrival'
                                                                ORDER BY b.sub_location_name";
                                                $result1        = $db->query($conn, $sql1);
                                                $count1         = $db->counter($result1);
                                                $field_name     = "package_location";
                                                $field_label    = "Location";
                                                if ($_SERVER['HTTP_HOST'] == HTTP_HOST_IP && !isset($package_location)) {
                                                    // $package_location = 2289;
                                                }
                                                ?>
                                             <i class="material-icons prefix">question_answer</i>
                                             <div class="select2div">
                                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                                } ?>">
                                                     <?php
                                                        if ($count1 > 1) { ?>
                                                         <option value="">Select</option>
                                                         <?php }
                                                        if ($count1 > 0) {
                                                            $row1    = $db->fetch($result1);
                                                            foreach ($row1 as $data2) { ?>
                                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                                 <?php echo $data2['sub_location_name']; ?>
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
                                         <div class="input-field col m12 s12"></div>
                                     </div>
                                     <div class="row">
                                         <div class="input-field col m12 s12 text_align_center">
                                             <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                                 <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Receive</button>
                                             <?php } ?>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="input-field col m12 s12"></div>
                                     </div>
                                 <?php } else { ?>
                                     <div class="card-panel custom_padding_card_content_table_top_bottom">
                                         <div class="row">
                                             <div class="col 24 s12"><br>
                                                 <div class="card-alert card red lighten-5">
                                                     <div class="card-content red-text">
                                                         <p>Please add product in PO. </p>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 <?php } ?>
                             </div>
                         </form>
                         <?php /*?>
                         <div class="input-field col m4 s12">
                             <?php
                                $field_name     = "sub_location_id_barcode";
                                $field_label    = "Location";
                                $sql1           = " SELECT b.*
                                                        FROM warehouse_sub_locations  b
                                                        WHERE b.enabled = 1  
                                                        AND b.purpose != 'Arrival'
                                                        ORDER BY b.sub_location_name ";
                                $result1        = $db->query($conn, $sql1);
                                $count1         = $db->counter($result1);
                                ?>
                             <i class="material-icons prefix">question_answer</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <?php
                                        if ($count1 > 1) { ?>
                                         <option value="">Select</option>
                                         <?php }
                                        if ($count1 > 0) {
                                            $row1    = $db->fetch($result1);
                                            foreach ($row1 as $data2) { ?>
                                             <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data2['sub_location_name'];
                                                    if ($data2['sub_location_type'] != "") {
                                                        echo " (" . ucwords(strtolower($data2['sub_location_type'])) . ")";
                                                    }
                                                    if ($data2['purpose'] != "") {
                                                        echo " - " . ucwords(strtolower($data2['purpose'])) . "";
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
                                $field_label    = "BarCode";
                                $sql            = " SELECT a.*, COUNT(b.id) AS total_received
                                                    FROM vender_po_data a  
                                                    LEFT JOIN purchase_order_detail_receive b ON b.po_id = a.po_id AND b.serial_no_barcode = a.serial_no
                                                    WHERE a.enabled = 1
                                                    AND a.po_id = '" . $id . "'
                                                    GROUP BY a.serial_no
                                                    HAVING COUNT(b.id) = 0 ";
                                $result_log2    = $db->query($conn, $sql);
                                $count_r2       = $db->counter($result_log2); ?>
                             <i class="material-icons prefix pt-1">add_shopping_cart</i>
                             <div class="select2div">
                                 <select id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="select2 browser-default select2-hidden-accessible validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                                    echo ${$field_name . "_valid"};
                                                                                                                                                                } ?>">
                                     <option value="">Select</option>
                                     <?php
                                        if ($count_r2 > 0) {
                                            $row_r2    = $db->fetch($result_log2);
                                            if ($count_r2 > 1 && $_SERVER['HTTP_HOST'] != HTTP_HOST_IP) { ?>

                                         <?php }
                                            foreach ($row_r2 as $data_r2) { ?>
                                             <option value="<?php echo $data_r2['serial_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data_r2['serial_no']) { ?> selected="selected" <?php } ?>>
                                                 <?php echo $data_r2['serial_no']; ?>
                                             </option>
                                     <?php
                                            }
                                        } ?>
                                 </select>
                                 <label for="<?= $field_name; ?>">
                                     <?= $field_label; ?>
                                     <span class="color-red"> * <?php
                                                                if (isset($error5[$field_name])) {
                                                                    echo $error5[$field_name];
                                                                } ?>
                                     </span>
                                 </label>
                             </div>
                         </div> 
                         <div class="input-field col m1 s12">
                             <?php if (isset($id) && $id > 0 && (($cmd5 == 'add' || $cmd5 == '') && access("add_perm") == 1)  || ($cmd5 == 'edit' && access("edit_perm") == 1) || ($cmd5 == 'delete' && access("delete_perm") == 1)) { ?>
                                 <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add" id="receive_using_barcode_btn">Receive</button>
                             <?php } ?>
                         </div>
                        <?php */ ?>
                     </div>
                     <div class="row">
                         <div class="input-field col m12 s12"></div>
                     </div>
                 </div>
             </div>
             <?php
                $sql        =  "SELECT IFNULL(a.po_detail_id, 0) AS po_detail_id, IFNULL(b.category_name, '') AS category_name, a.sub_location_id, a.device_category_id, c.sub_location_name, c.sub_location_type, d.package_name, d.`sku_code`,
                                    COUNT(a.id) AS total_received, SUM(a.per_package_cost) AS total_cost
                                FROM purchase_order_detail_receive_package_material a
                                INNER JOIN product_categories b ON b.id = a.device_category_id
                                LEFT JOIN warehouse_sub_locations c ON c.id = a.sub_location_id
                                INNER JOIN packages d ON d.id = a.package_id
                                WHERE a.device_po_id = '" . $id . "'
                                GROUP BY device_category_id, a.sub_location_id, a.package_id

                                UNION ALL 

                                SELECT IFNULL(a.po_detail_id, 0) AS po_detail_id, IFNULL(b2.category_name, '') AS category_name, a.sub_location_id, a.device_category_id, c.sub_location_name, c.sub_location_type, d.package_name, d.`sku_code`,
                                    COUNT(a.id) AS total_received, SUM(a.per_package_cost) AS total_cost
                                FROM purchase_order_detail_receive_package_material a
                                INNER JOIN purchase_order_packages_detail b ON b.id = a.`po_detail_id`
                                LEFT JOIN product_categories b2 ON b2.id = a.device_category_id
                                LEFT JOIN warehouse_sub_locations c ON c.id = a.sub_location_id
                                INNER JOIN packages d ON d.id = b.package_id
                                WHERE b.po_id = '" . $id . "'
                                GROUP BY device_category_id, a.sub_location_id, a.package_id
";
                $result_t1  = $db->query($conn, $sql);
                $count_t1   = $db->counter($result_t1);
                if ($count_t1 > 0) { ?>
                 <div class="card-panel custom_padding_card_content_table_top_bottom">
                     <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                         <input type="hidden" name="is_Submit_tab5_4_3" value="Y" />
                         <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                            echo encrypt($_SESSION['csrf_session']);
                                                                        } ?>">
                         <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                         <div class="row">
                             <div class="col m12 s12">
                                 <h6>Device Packages Received</h6>
                             </div>
                         </div>
                         <div class="row">
                             <table class="bordered">
                                 <tr>
                                     <th width="80px" class="text_align_center">
                                         <label>
                                             <input type="checkbox" id="all_checked7" class="filled-in" name="all_checked7" value="1">
                                             <span></span>
                                         </label>
                                     </th>
                                     <th>Package Name</th>
                                     <th>SKU</th>
                                     <th>Location</th>
                                     <th>Device Category</th>
                                     <th>Total Received</th>
                                     <th>Packages Cost</th>
                                 </tr>
                                 <?php
                                    $row_t1 = $db->fetch($result_t1);
                                    foreach ($row_t1 as $data_t1) {
                                        $detail_id2             = $data_t1['sub_location_id'];
                                        $product_category_rc2   = $data_t1['device_category_id']; ?>
                                     <tr>
                                         <td class="text_align_center">
                                             <label>
                                                 <input type="checkbox" name="delete_received_packages_ids[]" id="delete_received_packages_ids[]" value="<?= $data_t1['po_detail_id']; ?>-<?= $data_t1['sub_location_id']; ?>-<?= $data_t1['device_category_id']; ?>" class="checkbox7 filled-in" />
                                                 <span></span>
                                             </label>
                                         </td>
                                         <td><?php echo $data_t1['package_name']; ?></td>
                                         <td><?php echo $data_t1['sku_code']; ?></td>
                                         <td>
                                             <?php echo $data_t1['sub_location_name']; ?>
                                             <?php
                                                if ($data_t1['sub_location_type'] != "") {
                                                    echo " (" . $data_t1['sub_location_type'] . ")";
                                                } ?>
                                         </td>
                                         <td><?php echo $data_t1['category_name']; ?></td>
                                         <td><?php echo $data_t1['total_received']; ?></td>
                                         <td><?php echo number_format($data_t1['total_cost'], 2); ?></td>
                                     </tr>
                                 <?php  } ?>
                             </table>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12 text_align_center">
                                 <?php if (isset($id) && $id > 0 &&  access("delete_perm") == 1) { ?>
                                     <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="deletepserial">Delete</button>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </form>
                 </div>
             <?php }
                $td_padding = "padding:5px 10px !important;";
                $sql            = " SELECT * FROM (
                                        SELECT 'ProductReceived' as record_type, 'PO Product' as product_type, '1' as total_qty_received, a.*, c.product_desc, c.product_uniqueid, d.category_name, 
                                        e.first_name, e.middle_name, e.last_name, e.username, g.sub_location_name, g.sub_location_type, b1.is_pricing_done, c.product_category, h.status_name 
                                        FROM purchase_order_detail_receive a
                                        INNER JOIN purchase_order_detail b ON b.id = a.po_detail_id
                                        INNER JOIN purchase_orders b1 ON b1.id = b.po_id
                                        INNER JOIN products c ON c.id = b.product_id
                                        LEFT JOIN product_categories d ON d.id =c.product_category
                                        LEFT JOIN users e ON e.id = a.add_by_user_id
                                        LEFT JOIN warehouse_sub_locations g ON g.id = a.sub_location_id
                                        LEFT JOIN inventory_status h ON h.id = a.inventory_status
                                        WHERE a.enabled     = 1 
                                        AND b.po_id         = '" . $id . "'
                                        AND (a.recevied_product_category = 0 || a.recevied_product_category IS NULL || a.serial_no_barcode IS NOT NULL)

                                        UNION ALL

                                        SELECT 'ProductReceived' AS record_type, 'Added During Diagnostic' as product_type, '1' AS total_qty_received, a.*, c.product_desc, c.product_uniqueid, d.category_name, 
                                            e.first_name, e.middle_name, e.last_name, e.username, g.sub_location_name, g.sub_location_type, b1.is_pricing_done, c.product_category, h.status_name 
                                        FROM purchase_order_detail_receive a
                                        INNER JOIN purchase_orders b1 ON b1.id = a.po_id
                                        INNER JOIN products c ON c.id = a.product_id
                                        LEFT JOIN product_categories d ON d.id =c.product_category
                                        LEFT JOIN users e ON e.id = a.add_by_user_id
                                        LEFT JOIN warehouse_sub_locations g ON g.id = a.sub_location_id
                                        LEFT JOIN inventory_status h ON h.id = a.inventory_status
                                        WHERE a.enabled = 1 
                                        AND a.po_id = '" . $id . "'

                                        UNION ALL

                                        SELECT 'CateogryReceived' AS record_type, 'PO Product' as product_type, COUNT(a.id) AS total_qty_received, a.*, '' AS product_desc, '' AS product_uniqueid, d.category_name, 
                                            e.first_name, e.middle_name, e.last_name, e.username, g.sub_location_name, g.sub_location_type, b1.is_pricing_done, a.recevied_product_category AS product_category, '' as status_name 
                                        FROM purchase_order_detail_receive a 
                                        INNER JOIN purchase_orders b1 ON b1.id = a.po_id
                                        INNER JOIN product_categories d ON d.id = a.recevied_product_category  
                                        LEFT JOIN users e ON e.id = a.add_by_user_id
                                        LEFT JOIN warehouse_sub_locations g ON g.id = a.sub_location_id
                                         WHERE a.po_id = '" . $id . "'
                                        AND (a.is_diagnost = 1 || (a.serial_no_barcode = '' || a.serial_no_barcode IS NULL))
                                        AND a.po_detail_id = 0
                                        AND a.product_id = 0
                                        GROUP BY a.recevied_product_category, sub_location_id
                                    ) AS t1
                                    ORDER BY product_type DESC, record_type, product_category, sub_location_id, serial_no_barcode ";  //echo $sql;
                $result_log     = $db->query($conn, $sql);
                $count_log      = $db->counter($result_log);
                if ($count_log > 0) { ?>
                 <div class="card-panel custom_padding_card_content_table_top_bottom">
                     <div class="row">
                         <div class="col m12 s12">
                             <h6>Location & Category Wise Total</h6>
                         </div>
                     </div>
                     <div class="row">
                         <table class="bordered">
                             <tr>
                                 <th>Category</th>
                                 <th>Location</th>
                                 <th>Qty</th>
                                 <th>Actions</th>
                             </tr>
                             <?php
                                $sql        =  "SELECT sub_location_id, sub_location_name, sub_location_type, product_category, category_name, SUM(total_products) AS total_products
                                                FROM (
                                                    SELECT a.sub_location_id, e.sub_location_name, e.sub_location_type, c.product_category, d.`category_name`, COUNT(a.id) AS total_products
                                                    FROM purchase_order_detail b 
                                                    INNER JOIN products c ON c.id = b.product_id
                                                    INNER JOIN purchase_order_detail_receive a ON a.`po_detail_id` = b.id
                                                    LEFT JOIN warehouse_sub_locations e ON e.id = a.sub_location_id
                                                    INNER JOIN product_categories d ON d.id = c.product_category  
                                                    WHERE a.enabled = 1 
                                                    AND b.po_id     = '" . $id . "'
                                                    AND a.`receive_type` != 'CateogryReceived'
                                                    GROUP BY c.product_category, a.sub_location_id

                                                    UNION ALL 

                                                    SELECT a.sub_location_id, e.sub_location_name, e.sub_location_type, a.recevied_product_category AS product_category, d.`category_name`, COUNT(a.id) AS total_products
                                                    FROM purchase_order_detail_receive a 
                                                    INNER JOIN purchase_orders b1 ON b1.id = a.po_id
                                                    INNER JOIN product_categories d ON d.id = a.recevied_product_category  
                                                    LEFT JOIN warehouse_sub_locations e ON e.id = a.sub_location_id
                                                    WHERE a.po_id = '" . $id . "'
                                                    GROUP BY a.recevied_product_category, a.sub_location_id
                                                ) AS t1
                                                GROUP BY category_name, sub_location_id
                                                ORDER BY category_name, sub_location_name ";
                                $result_t1  = $db->query($conn, $sql);
                                $count_t1   = $db->counter($result_t1);
                                if ($count_t1 > 0) {
                                    if ($count_log > 0) {
                                        $row_t1 = $db->fetch($result_t1);
                                        foreach ($row_t1 as $data_t1) {
                                            $detail_id2             = $data_t1['sub_location_id'];
                                            $product_category_rc2   = $data_t1['product_category']; ?>
                                         <tr>
                                             <td><?php echo $data_t1['category_name']; ?></td>
                                             <td>
                                                 <?php echo $data_t1['sub_location_name']; ?>
                                                 <?php
                                                    if ($data_t1['sub_location_type'] != "") {
                                                        echo " (" . $data_t1['sub_location_type'] . ")";
                                                    } ?>
                                             </td>
                                             <td><?php echo $data_t1['total_products']; ?></td>
                                             <td>
                                                 <a href="components/<?php echo $module_folder; ?>/<?php echo $module; ?>/print_receive_labels_pdf.php?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&id=" . $id . "&sub_location_id=" . $detail_id2 . "&product_category=" . $product_category_rc2)  ?>" target="_blank">
                                                     <i class="material-icons dp48">print</i>
                                                 </a>
                                             </td>
                                         </tr>
                             <?php
                                        }
                                    }
                                } ?>
                         </table>
                     </div>
                 </div>
                 <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab5") ?>" method="post">
                     <input type="hidden" name="is_Submit_tab5_4_2" value="Y" />
                     <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                        echo encrypt($_SESSION['csrf_session']);
                                                                    } ?>">
                     <input type="hidden" name="duplication_check_token" value="<?php echo (time() . session_id()); ?>">
                     <div class="card-panel custom_padding_card_content_table_top_bottom">
                         <div class="row">
                             <div class="col m12 s12">
                                 <h6>Received Products</h6>
                             </div>
                         </div>
                         <?php /*?>
                         <div class="row">
                             <table class="bordered">
                                 <tr>
                                     <th>Product ID</th>
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
                                                    AND b.enabled   = 1
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
                         <?php */ ?>
                         <br>
                         <div class="row">
                             <div class="col m2 s12">
                                 <label>
                                     <input type="checkbox" id="all_checked6" class="filled-in" name="all_checked6" value="1" <?php if (isset($all_checked6) && $all_checked6 == '1') {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> />
                                     <span></span>
                                 </label>
                             </div>
                             <div class="col m10 s12">
                                 <div class="text_align_right">
                                     <?php
                                        $table_columns    = array('SNo', '-', 'Type', 'Category', 'Product ID', 'Serial NO', 'Status', 'Condition', 'Defective Note', 'Location', 'Qty', 'Received By', 'Receiving Date/Time');
                                        $k                 = 0;
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
                         </div>
                         <div class="section section-data-tables">
                             <div class="row">
                                 <div class="col m12 s12">
                                     <table id="page-length-option" class="display pagelength50_5">
                                         <thead>
                                             <tr>
                                                 <?php
                                                    $headings = "";
                                                    foreach ($table_columns as $data_c) {
                                                        if ($data_c == 'SNo') {
                                                            $headings .= '<th class="sno_width_60 col-' . set_table_headings($data_c) . '">' . $data_c . '</th>';
                                                        } else if ($data_c == '-') {
                                                            $headings .= '<th class="sno_width_60 col-' . set_table_headings($data_c) . '">' . $data_c . '</th>';
                                                        } else {
                                                            $headings .= '<th class="col-' . set_table_headings($data_c) . '">' . $data_c . '</th> ';
                                                        }
                                                    }
                                                    echo $headings;
                                                    $headings2 = ' '; ?>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php
                                                $i = $checkbox_del = 0;
                                                if ($count_log > 0) {
                                                    $row_cl1 = $db->fetch($result_log);
                                                    foreach ($row_cl1 as $data) {
                                                        $column_no = 0;
                                                        $detail_id2 = $data['id'];
                                                        $detail_id3 = $data['sub_location_id'];
                                                        if ($data['record_type'] == 'CateogryReceived') {
                                                            $detail_id2 = $data['product_category'];
                                                        } ?>
                                                     <tr>
                                                         <td style="width:80px; <?= $td_padding; ?>; text-align: center;" class="col-<?= set_table_headings($table_columns[$column_no]); ?>">
                                                             <?php
                                                                echo $i + 1;
                                                                $column_no++;
                                                                ?>
                                                         </td>
                                                         <td style="width:80px; <?= $td_padding; ?>; text-align: center;" class="col-<?= set_table_headings($table_columns[$column_no]); ?>">
                                                             <?php
                                                                $column_no++;
                                                                if (access("delete_perm") == 1 && (($data['edit_lock'] == "0" && $data['is_diagnost'] == "0") || ($data['is_diagnostic_bypass'] == 1)) && $stage_status == 'Draft') {
                                                                    // if (access("delete_perm") == 1 && (($data['edit_lock'] == "0" && $data['is_diagnost'] == "0") || ($data['is_diagnostic_bypass'] == 1 && $data['is_pricing_done'] == 0))) {
                                                                    $checkbox_del++; ?>
                                                                 <label>
                                                                     <input type="checkbox" name="receviedProductIds[]" id="receviedProductIds[]" value="<?= $data['record_type']; ?>-<?= $detail_id2; ?>-<?= $detail_id3; ?>" class="checkbox6 filled-in" />
                                                                     <span></span>
                                                                 </label>
                                                                 <?php
                                                                    if ($data['inventory_status'] == '6') { ?>
                                                                     <a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=" . $cmd . "&cmd5_1=edit&active_tab=tab5&id=" . $id . "&detail_id=" . $detail_id2) ?>">
                                                                         <i class="material-icons dp48">edit</i>
                                                                     </a>
                                                             <?php
                                                                    }
                                                                } ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                echo $data['product_type'];
                                                                $column_no++;
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                if ($data['category_name'] != "") {
                                                                    if ($data['record_type'] == "CateogryReceived") {
                                                                        echo "" . $data['category_name'] . "";
                                                                    } else {
                                                                        echo " " . $data['category_name'] . "";
                                                                    }
                                                                } ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                echo $data['product_uniqueid'];
                                                                $column_no++;
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                $color              = "color-red";
                                                                $serial_no_barcode  = $data['serial_no_barcode'];
                                                                if ($data['serial_no_barcode'] != "" && $data['serial_no_barcode'] != null) {
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
                                                                    echo "<span class='" . $color . "'>" . $serial_no_barcode . "</span>";
                                                                } ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['status_name'];
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['overall_grade'];
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['defects_or_notes'];
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['sub_location_name']; ?>
                                                             <?php
                                                                if ($data['sub_location_type'] != "") {
                                                                    echo " (" . $data['sub_location_type'] . ")";
                                                                } ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['total_qty_received'];
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo $data['first_name'];
                                                                ?>
                                                         </td>
                                                         <td class="col-<?= set_table_headings($table_columns[$column_no]); ?>" style="<?= $td_padding; ?>">
                                                             <?php
                                                                $column_no++;
                                                                echo dateformat1_with_time($data['add_date']); ?>
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
                             <div class="input-field col m12 s12 text_align_center">
                                 <?php if (isset($id) && $id > 0 &&  access("delete_perm") == 1 && $checkbox_del > 0) { ?>
                                     <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="deletepserial">Delete</button>
                                 <?php } ?>
                             </div>
                         </div>
                         <div class="row">
                             <div class="input-field col m12 s12"></div>
                         </div>
                     </div>
                 </form>
             <?php }
            } else { ?>
             <div class="card-panel custom_padding_card_content_table_top_bottom">
                 <div class="row">
                     <div class="col 24 s12"><br>
                         <div class="card-alert card red lighten-5">
                             <div class="card-content red-text">
                                 <p>Nothing arrive yet. </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
     <?php
            }
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