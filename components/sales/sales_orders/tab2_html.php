<?php
$sql_cl        = "	SELECT a.*, c.product_desc,b2.packing_type, d.category_name,b.order_status, 
                            c.product_uniqueid, b1.order_qty,b1.order_price,b1.product_so_desc,
                            b1.product_stock_id
                    FROM sales_order_detail_packing a  
                    INNER JOIN sales_orders b ON b.id = a.sale_order_id
                    INNER JOIN sales_order_detail b1 ON b1.sales_order_id = a.sale_order_id
                    INNER JOIN product_stock c1 ON c1.id = b1.product_stock_id AND c1.serial_no = a.serial_no_barcode
                    INNER JOIN products c ON c.id = c1.product_id
                    INNER JOIN packing_types b2 ON b2.id = a.packing_type
                    LEFT JOIN product_categories d ON d.id = c.product_category
                    WHERE b1.sales_order_id ='" . $id . "'
                    AND a.is_shipped = 0 ";
if (isset($flt_product_id) && $flt_product_id != "") {
    $sql_cl     .= " AND c.product_uniqueid LIKE '%" . trim($flt_product_id) . "%' ";
}
// if (isset($flt_product_desc) && $flt_product_desc != "") {
// 	$sql_cl 	.= " AND c.product_desc LIKE '%" . trim($flt_product_desc) . "%' ";
// }
if (isset($flt_product_category) && $flt_product_category != "") {
    $sql_cl     .= " AND c.product_category = '" . trim($flt_product_category) . "' ";
}
if (isset($packing_type_filter) && $packing_type_filter > 0) {
    $sql_cl        .= " AND b2.id = '" . $packing_type_filter . "'";
}
if (isset($flt_serial_no) && $flt_serial_no > 0) {
    $sql_cl        .= " AND a.serial_no_barcode = '" . $flt_serial_no . "'";
}

$sql_cl .= "ORDER BY a.serial_no_barcode  "; // echo $sql_cl;
$result_cl    = $db->query($conn, $sql_cl);
$count_cl    = $db->counter($result_cl);
?>
<div id="tab2_html" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab2')) {
                                        echo "block";
                                    } else {
                                        echo "none";
                                    } ?>;">
    <div class="card-panel" style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 5px;">
        <div class="row">
            <div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
                <h6 class="media-heading">
                    <?= $general_heading; ?> --> Shipments
                </h6>
            </div>
            <div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
                <?php include("tab_action_btns.php"); ?>
            </div>
        </div>
        <?php
        if (isset($id) && isset($so_no)) {  ?>
            <div class="row">
                <div class=" col m4 s12">
                    <h6 class="media-heading"><span class=""><?php echo "<b>SO#:</b>" . $so_no; ?></span></h6>
                </div>
                <div class=" col m4 s12">
                    <h6 class="media-heading"><span class=""><?php echo "<b>Order Date: </b>" . $order_date_disp; ?></span></h6>
                </div>
                <div class=" col m4 s12">
                    <h6 class="media-heading"><span class=""><?php echo "<b>Customer Invoice#: </b>" . $customer_invoice_no; ?></span></h6>
                </div>
            </div>
        <?php }  ?>
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
    <?php } ?>

    <?php
    if (!isset($detail_id)) {
        $detail_id1 = "";
    } else {
        $detail_id1 = $detail_id;
    }
    $td_padding = "padding:5px 15px !important;"; ?>
    <?php
    if (isset($id)) {  ?>
        <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=edit&id=" . $id . "&active_tab=tab2") ?>" method="post">
            <input type="hidden" name="is_Submit_tab2" value="Y" />
            <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                echo encrypt($_SESSION['csrf_session']);
                                                            } ?>">

            <div class="card-panel">
                <input type="hidden" name="active_tab" value="tab2" />
                <div class="row">
                    <?php
                    $field_name     = "packed_box_no";
                    $field_label     = "Box #";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <?php
                        $sql1       = " SELECT DISTINCT b.packing_type, a.box_no 
                                            FROM sales_order_detail_packing a 
                                            INNER JOIN packing_types b ON b.id = a.packing_type
                                            WHERE a.sale_order_id = '" . $id . "' 
                                            AND a.enabled = 1
                                            AND a.is_shipped = 0 ";
                        $result1    = $db->query($conn, $sql1);
                        $count1     = $db->counter($result1);
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
                                        <option value="<?php echo $data2['box_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['box_no']) { ?> selected="selected" <?php } ?>> <?php echo $data2['packing_type']; ?> <?php echo $data2['box_no']; ?> </option>
                                <?php }
                                } ?>
                            </select>
                            <label for="<?= $field_name; ?>">
                                <?= $field_label; ?>
                                <span class="color-red"><?php
                                                        if (isset($error2[$field_name])) {
                                                            echo $error2[$field_name];
                                                        } ?>
                                </span>
                            </label>
                        </div>
                    </div>
                    <?php
                    $field_name     = "packed_pallet_no";
                    $field_label     = "Pallet #";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <?php
                        $sql1       = " SELECT DISTINCT a.pallet_no 
                                            FROM sales_order_detail_packing a 
                                            WHERE a.sale_order_id = '" . $id . "' 
                                            AND a.enabled = 1
                                            AND a.is_shipped = 0
                                            AND pallet_no > 0 ";
                        $result1    = $db->query($conn, $sql1);
                        $count1     = $db->counter($result1);
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
                                        <option value="<?php echo $data2['pallet_no']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['pallet_no']) { ?> selected="selected" <?php } ?>> Pallet <?php echo $data2['pallet_no']; ?> </option>
                                <?php }
                                } ?>
                            </select>
                            <label for="<?= $field_name; ?>">
                                <?= $field_label; ?>
                                <span class="color-red"> <?php
                                                            if (isset($error2[$field_name])) {
                                                                echo $error2[$field_name];
                                                            } ?>
                                </span>
                            </label>
                        </div>
                    </div>
                    <?php
                    $field_name     = "shipment_courier_id";
                    $field_label     = "Courier";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <?php
                        $sql1             = "SELECT * FROM couriers WHERE enabled = 1 ORDER BY courier_name ";
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
                                        <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['courier_name']; ?></option>
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
                    <?php
                    $field_name     = "shipment_tracking_no";
                    $field_label    = "Tracking No";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <i class="material-icons prefix">description</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
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
                    <?php
                    $field_name     = "shipment_sent_date";
                    $field_label     = "Shipment Send Date (d/m/Y)";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <i class="material-icons prefix">date_range</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class=" datepicker validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                            } ?>">
                        <label for="<?= $field_name; ?>">
                            <?= $field_label; ?>
                            <span class="color-red">* <?php
                                                        if (isset($error2[$field_name])) {
                                                            echo $error2[$field_name];
                                                        } ?>
                            </span>
                        </label>
                    </div>
                    <?php
                    $field_name     = "expected_delivery_date";
                    $field_label     = "Expected Delivery Date (d/m/Y)";
                    ?>
                    <div class="input-field col m4 s12 custom_margin_bottom_col">
                        <i class="material-icons prefix">date_range</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class=" datepicker validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                            } ?>">
                        <label for="<?= $field_name; ?>">
                            <?= $field_label; ?>
                            <span class="color-red"><?php
                                                    if (isset($error2[$field_name])) {
                                                        echo $error2[$field_name];
                                                    } ?>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class=" col m5 s12"></div>
                    <div class=" col m2 s12">
                        <?php if (isset($id) && $id > 0 &&  access("delete_perm") == 1) { ?>
                            <button class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="deletepserial">Shipment</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
        <?php
        $sql             = "SELECT a.*, c.product_desc, d.category_name,b.order_status, 
                                    c.product_uniqueid, b1.order_qty,b1.order_price,b1.product_so_desc,
                                    b1.product_stock_id, bb.shipment_no,bb.shipment_sent_date,bb.expected_delivery_date,bb.shipment_tracking_no, bb.id AS shipped_id,
                                    cc.courier_name, bb2.id as shipment_detail_id, c1.serial_no
                                FROM sales_order_shipment_detail bb2
                                INNER JOIN sales_order_shipments bb ON bb2.shipment_id = bb.id
                                INNER JOIN sales_order_detail_packing a ON a.id = bb2.packed_id
                                INNER JOIN product_stock c1 ON c1.id = a.product_stock_id 
                                INNER JOIN sales_orders b ON b.id = a.sale_order_id
                                INNER JOIN sales_order_detail b1 ON b1.sales_order_id = a.sale_order_id AND b1.product_stock_id = a.product_stock_id
                                INNER JOIN products c ON c.id = c1.product_id
                                LEFT JOIN product_categories d ON d.id = c.product_category
                                LEFT JOIN couriers cc ON cc.id = bb.shipment_courier_id
                                WHERE b1.sales_order_id = '" . $id . "'
                                AND a.is_shipped = 1  
                                ORDER BY bb.shipment_no, d.category_name, c.product_uniqueid, c1.serial_no";
        $result_log     = $db->query($conn, $sql);
        $count_log      = $db->counter($result_log);
        if ($count_log > 0) { ?>
            <div class="card-panel">
                <div class="row">
                    <div class="col m2 s12">
                        <h5 class="h5">Shipments Detail</h5>
                    </div>
                    <div class="col m9 s12">
                        <div class="text_align_right">
                            <?php 
                            $table_columns	= array('SNo', 'Shipment No', 'Shipment TrackingNo / Shipment Sent Date', 'Courier / Expected Delivery Date', 'Product Detail','Serial No','Actions');
                            $k 				= 0;
                            foreach($table_columns as $data_c1){?>
                                <label>
                                    <input type="checkbox" value="<?= $k?>" name="table_columns[]" class="filled-in toggle-column" data-column="<?= set_table_headings($data_c1)?>" checked="checked">
                                    <span><?= $data_c1?></span>
                                </label>&nbsp;&nbsp;
                            <?php 
                                $k++;
                            }?> 
                        </div>
                    </div>
                    <div class="col m1 s12">
                        <a href="export/export_sales_order_shipmnet_detail.php?string=<?php echo encrypt("module_id=" . $module_id . "&id=" . $id) ?>" class="mb-2 custom_btn_size btn waves-effect waves-light gradient-45deg-green-teal">
                            <i class="material-icons medium icon-demo">vertical_align_bottom</i>
                        </a>
                        <a class="mb-2 btn custom_btn_size waves-effect waves-light cyan" href="components/<?php echo $module_folder; ?>/<?php echo $module; ?>/sales_order_shipmnet_details_print.php?string=<?php echo encrypt("module_id=" . $module_id . "&id=" . $id) ?>" target="_blank">
                            <i class="material-icons medium icon-demo">print</i>
                        </a>
                    </div>
                </div>
                <div class="section section-data-tables">
                    <div class="row">
                        <div class="col m12 s12">

                            <table id="page-length-option" class="display pagelength50_5 dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <?php
                                        $headings = "";
                                        foreach($table_columns as $data_c){
                                            if($data_c == 'SNo'){
                                                $headings .= '<th class="sno_width_60 col-'.set_table_headings($data_c).'">'.$data_c.'</th>';
                                            }
                                            else{
                                                $headings .= '<th class="col-'.set_table_headings($data_c).'">'.$data_c.'</th> ';
                                            }
                                        } 
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
                                            $detail_id2 = $data['shipment_detail_id'];
                                            $packing_id = $data['id']; ?>
                                            <tr>
                                                <td style="text-align: center;" class="col-<?= set_table_headings($table_columns[0]);?>"><?php echo $i + 1; ?></td>
                                                <td class="col-<?= set_table_headings($table_columns[1]);?>"><?php echo $data['shipment_no']; ?></td>
                                                <td class="col-<?= set_table_headings($table_columns[2]);?>"><?php echo $data['shipment_tracking_no']; ?></br><?php echo dateformat2($data['shipment_sent_date']); ?></td>
                                                <td class="col-<?= set_table_headings($table_columns[3]);?>"><?php echo $data['courier_name']; ?></br><?php echo dateformat2($data['expected_delivery_date']); ?></td>
                                                <td class="col-<?= set_table_headings($table_columns[4]);?>">
                                                    <?php echo "" . $data['product_uniqueid']; ?><br>

                                                    <?php echo ucwords(strtolower($data['product_desc'])); ?>
                                                    <?php
                                                    if ($data['category_name'] != "") {
                                                        echo  " (" . $data['category_name'] . ")";
                                                    } ?>
                                                </td>
                                                <td class="col-<?= set_table_headings($table_columns[5]);?>"><?php echo "" . $data['serial_no']; ?></td>
                                                <td class="col-<?= set_table_headings($table_columns[6]);?>">
                                                    <?php
                                                    if ($data['edit_lock'] == 0 && access("edit_perm") == 1) { ?>
                                                        <a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=edit&cmd3=delete&active_tab=tab2&id=" . $id . "&detail_id=" . $detail_id2 . "&detail_id2=" . $packing_id) ?>">
                                                            <i class="material-icons dp48">delete</i>
                                                        </a>
                                                    <?php } ?>
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
            </div>
    <?php
        }
    }
    ?>

</div>