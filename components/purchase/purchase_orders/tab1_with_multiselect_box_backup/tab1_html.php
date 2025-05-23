<div id="tab1_html" class="active" style="display: <?php if (isset($active_tab) && $active_tab == 'tab1') {
                                                        echo "block";
                                                    } else {
                                                        echo "none";
                                                    } ?>;">
    <input type="hidden" id="module_id" value="<?= $module_id; ?>" />
    <?php
    if (isset($cmd) && $cmd == 'edit') { ?>
        <form method="post" autocomplete="off" action="<?php echo "?string=" . encrypt('module=' . $module . '&module_id=' . $module_id . '&page=profile&active_tab=tab1&cmd=edit&id=' . $id); ?>">
            <input type="hidden" name="is_Submit2" value="Y" />
        <?php
    } ?>
        <div class="card-panel" style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 5px;">
            <div class="row">
                <div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
                    <h6 class="media-heading">
                        <?= $general_heading; ?> => Master Info
                    </h6>
                </div>
                <div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
                    <?php /*?>
                    <a href="javascript:void(0)" class="btn cyan waves-effect waves-light ">
                        <i class="material-icons ">print</i>
                        Print
                    </a>  &nbsp;&nbsp;
                <?php */ ?>
                    <?php
                    if (isset($po_no) && isset($id)) {
                        if (access("edit_perm") == 1) { ?>
                            <button class="btn cyan waves-effect waves-light green custom_btn_size" type="submit" name="action">
                                Save changes
                            </button>
                    <?php }
                    } ?>
                    <?php include("tab_action_btns.php"); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <div id="Form-advance" class="card card card-default scrollspy custom_margin_section">
                    <div class="card-content custom_padding_section">
                        <?php
                        if (isset($po_no) && isset($id)) { ?>
                            <h5 class="media-heading"><span class=""><?php echo "<b>PO#:</b>" . $po_no; ?></span></h5>
                        <?php } ?>
                        <?php
                        if (isset($cmd) && $cmd == 'add') { ?>
                            <form method="post" autocomplete="off" action="<?php echo "?string=" . encrypt('module=' . $module . '&module_id=' . $module_id . '&page=profile&cmd=edit&active_tab=tab1&cmd=' . $cmd . '&id=' . $id); ?>">

                                <input type="hidden" name="is_Submit" value="Y" />
                            <?php } ?>
                            <div class="row" style="margin-top: 10px;">
                                <?php
                                $field_name     = "po_date";
                                $field_label     = "Order Date (d/m/Y)";
                                ?>
                                <div class="input-field col m2 s12 custom_margin_bottom_col">
                                    <i class="material-icons prefix">date_range</i>
                                    <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                        echo ${$field_name};
                                                                                                                    } else {
                                                                                                                        echo date("d/m/Y");
                                                                                                                    } ?>" class=" datepicker validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                            echo ${$field_name . "_valid"};
                                                                                                                                                        } ?> custom_input_heigh">
                                    <label for="<?= $field_name; ?>">
                                        <?= $field_label; ?>
                                        <span class="color-red">* <?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </label>
                                </div>
                                <?php
                                $field_name     = "vender_invoice_no";
                                $field_label     = "Vendor Invoice #";
                                ?>
                                <div class="input-field col m2 s12 custom_margin_bottom_col">
                                    <i class="material-icons prefix">question_answer</i>
                                    <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                                        echo ${$field_name};
                                                                                                                    } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                            } ?> custom_input_heigh">
                                    <label for="<?= $field_name; ?>">
                                        <?= $field_label; ?>
                                        <span class="color-red"><?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </label>
                                </div>
                                <div class="input-field col m3 s12 custom_margin_bottom_col">
                                    <?php
                                    $field_name     = "vender_id";
                                    $field_label     = "Vendor";
                                    $sql1             = "SELECT * FROM venders WHERE enabled = 1 ORDER BY vender_name ";
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
                                                    <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['vender_name']; ?> - Phone: <?php echo $data2['phone_no']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
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
                                <div class="input-field col m2 s12 custom_margin_bottom_col"><br>
                                    <a class="waves-effect waves-light btn modal-trigger mb-2 mr-1 custom_btn_size" href="#vender_add_modal">Add New Vendor</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m3 s12 custom_margin_bottom_col">
                                    <?php
                                    $field_name     = "is_tested_po";
                                    $field_label     = "To Be Tested";
                                    ?>
                                    <div style="margin-top: -10px; margin-bottom: 10px;">
                                        <?= $field_label; ?>
                                        <span class="color-red">* <?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </div>
                                    <p class="mb-1 custom_radio">
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="Yes" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'Yes') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>Yes</span>
                                        </label> &nbsp;&nbsp;
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="No" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'No') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>No</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="input-field col m3 s12 custom_margin_bottom_col">
                                    <?php
                                    $field_name     = "is_wiped_po";
                                    $field_label     = "To Be Wiped";
                                    ?>
                                    <div style="margin-top: -10px; margin-bottom: 10px;">
                                        <?= $field_label; ?>
                                        <span class="color-red">* <?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </div>
                                    <p class="mb-1 custom_radio">
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="Yes" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'Yes') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>Yes</span>
                                        </label> &nbsp;&nbsp;
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="No" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'No') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>No</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="input-field col m3 s12 custom_margin_bottom_col">
                                    <?php
                                    $field_name     = "is_imaged_po";
                                    $field_label     = "To Be Imaged";
                                    ?>
                                    <div style="margin-top: -10px; margin-bottom: 10px;">
                                        <?= $field_label; ?>
                                        <span class="color-red">* <?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </div>
                                    <p class="mb-1 custom_radio">
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="Yes" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'Yes') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>Yes</span>
                                        </label> &nbsp;&nbsp;
                                        <label>
                                            <input name="<?= $field_name; ?>" id="<?= $field_name; ?>" type="radio" value="No" <?php
                                                                                                                                if (isset(${$field_name}) && ${$field_name} == 'No') {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>
                                            <span>No</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <?php if (($cmd == 'add' &&  access("add_perm") == 1)) { ?>
                                <div class="row">
                                    <div class="input-field col m6 s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo $button_val; ?>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($cmd) && $cmd == 'add') { ?>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (isset($cmd) && $cmd == 'edit') { ?>
                <div class="col s12 m12 l12">
                    <div id="Form-advance2" class="card card card-default scrollspy custom_margin_section">
                        <div class="card-content custom_padding_section">
                            <table id="page-length-option1" class="bordered addproducttable" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>

                                        <th style="width: %;">
                                            Product &nbsp;
                                            <?php
                                            if (isset($order_status) && $order_status == 1) {
                                            ?>
                                                <a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=import_po_details&id=" . $id) ?>" class="btn gradient-45deg-amber-amber waves-effect waves-light custom_btn_size">
                                                    Import
                                                </a> &nbsp;&nbsp;

                                                <a class="add-more add-more-btn2 btn-sm btn-floating waves-effect waves-light cyan first_row" style="line-height: 32px; display: none;" id="add-more^0" href="javascript:void(0)" style="display: none;">
                                                    <i class="material-icons  dp48 md-36">add_circle</i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </th>
                                        <th style="width: 120px;">Condition</th>
                                        <th style="width: 100px;">Qty</th>
                                        <th style="width: 100px;">Price</th>
                                        <th style="width: 300px;">Imaged/Wipped/Tested</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($id) && $id > 0) {

                                        unset($product_ids);
                                        unset($product_condition);
                                        unset($order_price);
                                        unset($order_qty);
                                        unset($is_tested);
                                        unset($is_wiped);
                                        unset($is_imaged);

                                        $sql_ee1    = "SELECT a.* FROM purchase_order_detail a WHERE a.po_id = '" . $id . "' ";
                                        $result_ee1    = $db->query($conn, $sql_ee1);
                                        $count_ee1  = $db->counter($result_ee1);
                                        if ($count_ee1 > 0) {
                                            $row_ee1 = $db->fetch($result_ee1);
                                            foreach ($row_ee1 as $data2) {
                                                $product_ids[]            = $data2['product_id'];
                                                $product_condition[]    = $data2['product_condition'];
                                                $order_price[]            = $data2['order_price'];
                                                $order_qty[]            = $data2['order_qty'];
                                                $is_tested[]            = $data2['is_tested'];
                                                $is_wiped[]                = $data2['is_wiped'];
                                                $is_imaged[]            = $data2['is_imaged'];
                                            }
                                        }
                                    }
                                    $disabled = $readonly = "";
                                    if (isset($order_status) && $order_status != 1) {
                                        $disabled = "disabled='disabled'";
                                        $readonly = "readonly='readonly'";
                                    }
                                    for ($i = 1; $i <= 50; $i++) {
                                        $field_name     = "product_ids";
                                        $field_id       = "productids_" . $i;
                                        $field_label    = "Product";
                                        $style_btn = '';
                                        $style = "";
                                        if (!isset(${$field_name}[$i - 1]) || (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == "" || ${$field_name}[$i - 1] == 0)) {
                                            if ($i > 1) {
                                                if (isset($product_ids) && sizeof($product_ids) > 0) {
                                                    $style = 'style="display:none;"';
                                                } else {
                                                    $style = $i === 1 ? '' : 'style="display:none;"';
                                                }
                                            }
                                        } else {
                                            if (isset($product_ids) && is_array($product_ids) && sizeof($product_ids) > 1) {
                                                $style = $i <= sizeof($product_ids) ? '' : 'style="display:none;"';
                                                $style_btn = $i <= sizeof($product_ids) ? 'style="display:none;"' : '';
                                            } else {
                                                $style = $i === 1 ? '' : 'style="display:none;"';
                                                $style_btn = $i === 1 ? 'style="display:none;"' : '';
                                            }
                                        }

                                        $sql1             = " SELECT a.*, b.category_name
                                                            FROM products a
                                                            LEFT JOIN product_categories b ON b.id = a.product_category
                                                            WHERE a.enabled = 1 
                                                            ORDER BY a.product_desc";
                                        $result1         = $db->query($conn, $sql1);
                                        $count1         = $db->counter($result1);
                                    ?>
                                        <tr class="dynamic-row" id="row_<?= $i; ?>" <?php echo $style; ?>>
                                            <td>
                                                <select <?php echo $disabled;
                                                        echo $readonly; ?> name="<?= $field_name ?>[]" id="<?= $field_id ?>" class="select2-theme browser-default select2-hidden-accessible product-select <?= $field_name ?>_<?= $i ?>">
                                                    <option value="">Select a product</option>
                                                    <?php
                                                    if ($count1 > 0) {
                                                        $row1    = $db->fetch($result1);
                                                        foreach ($row1 as $data2) { ?>
                                                            <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == $data2['id']) { ?> selected="selected" <?php } ?>><?php echo $data2['product_desc']; ?> (<?php echo $data2['category_name']; ?>) - <?php echo $data2['product_uniqueid']; ?></option>
                                                    <?php }
                                                    } ?>
                                                    <option value="product_add_modal">+Add New Product</option>
                                                </select>
                                            </td>
                                            <td>
                                                <?php
                                                $field_name     = "product_condition";
                                                $field_id       = "productcondition_" . $i;
                                                $field_label     = "Product Condition";
                                                ?>

                                                <select <?php echo $disabled;
                                                        echo $readonly; ?> name="<?= $field_name ?>[]" id="<?= $field_id ?>" class="browser-default custom_condition_class">
                                                    <option value="">N/A</option>
                                                    <option value="A" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == "A") { ?> selected="selected" <?php } ?>>A</option>
                                                    <option value="B" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == "B") { ?> selected="selected" <?php } ?>>B</option>
                                                    <option value="C" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == "C") { ?> selected="selected" <?php } ?>>C</option>
                                                    <option value="D" <?php if (isset(${$field_name}[$i - 1]) && ${$field_name}[$i - 1] == "D") { ?> selected="selected" <?php } ?>>D</option>
                                                </select>
                                            </td>
                                            <td>
                                                <?php
                                                $field_name     = "order_qty";
                                                $field_id       = "orderqty_" . $i;
                                                $field_label     = "Quantity";
                                                ?>
                                                <input <?php echo $disabled;
                                                        echo $readonly; ?> name="<?= $field_name; ?>[]" type="number" id="<?= $field_id; ?>" value="<?php if (isset(${$field_name}[$i - 1])) {
                                                                                                                                                        echo ${$field_name}[$i - 1];
                                                                                                                                                    } ?>" class="validate custom_input">
                                            </td>
                                            <td>
                                                <?php
                                                $field_name     = "order_price";
                                                $field_id       = "orderprice_" . $i;
                                                $field_label     = "Unit Price";
                                                ?>
                                                <input <?php echo $disabled;
                                                        echo $readonly; ?> name="<?= $field_name; ?>[]" type="number" id="<?= $field_id; ?>" value="<?php if (isset(${$field_name}[$i - 1])) {
                                                                                                                                                        echo ${$field_name}[$i - 1];
                                                                                                                                                    } ?>" class="validate custom_input">
                                            </td>
                                            <td>
                                                <?php
                                                $field_name     = "isimage_iswipped_istested";
                                                $field_id       = "isimage_iswipped_istested_" . $i;
                                                $field_label     = "Imaged / Wipped / Tested";
                                                ?>
                                                <select <?php echo $disabled;
                                                        echo $readonly; ?> name="<?= $field_id; ?>[]" id="<?= $field_id ?>" multiple="multiple" class="select2 browser-default custom_condition_class select2-hidden-accessible">
                                                    <option value="">Select</option>
                                                    <option value="Tested" <?php if (isset($is_tested[$i - 1]) && $is_tested[$i - 1]    == 'Yes') { ?> selected="selected" <?php } ?>>Tested</option>
                                                    <option value="Imaged" <?php if (isset($is_imaged[$i - 1]) && $is_imaged[$i - 1]    == 'Yes') { ?> selected="selected" <?php } ?>>Imaged</option>
                                                    <option value="Wipped" <?php if (isset($is_wiped[$i - 1])  && $is_wiped[$i - 1]     == 'Yes') { ?> selected="selected" <?php } ?>>Wipped</option>
                                                </select>
                                            </td>
                                            <td>
                                                <?php if (isset($order_status) && $order_status == 1) { ?>
                                                    <a class="remove-row btn-sm btn-floating waves-effect waves-light red" style="line-height: 32px;" id="remove-row^<?= $i ?>" href="javascript:void(0)">
                                                        <i class="material-icons dp48">cancel</i>
                                                    </a> &nbsp;
                                                    <a class="add-more add-more-btn btn-sm btn-floating waves-effect waves-light cyan" style="line-height: 32px;" id="add-more^<?= $i ?>" href="javascript:void(0)">
                                                        <i class="material-icons dp48">add_circle</i>
                                                    </a>&nbsp;&nbsp;
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    $field_name     = "product_id_for_package_material";
                                    ?>
                                    <input name="<?= $field_name; ?>" type="hidden" id="<?= $field_name; ?>" value="">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l12">
                    <div id="Form-advance2" class="card card card-default scrollspy custom_margin_section">
                        <div class="card-content custom_padding_section">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <?php
                                    $field_name     = "po_desc";
                                    $field_label     = "Private Note";
                                    ?>
                                    <i class="material-icons prefix">description</i>
                                    <textarea <?php echo $disabled;
                                                echo $readonly; ?> id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="materialize-textarea validate "><?php if (isset(${$field_name})) {
                                                                                                                                                                    echo ${$field_name};
                                                                                                                                                                } ?></textarea>
                                    <label for="<?= $field_name; ?>">
                                        <?= $field_label; ?>
                                        <span class="color-red"> <?php
                                                                    if (isset($error[$field_name])) {
                                                                        echo $error[$field_name];
                                                                    } ?>
                                        </span>
                                    </label>
                                </div>
                                <div class="input-field col m6 s12">
                                    <?php
                                    $field_name     = "po_desc_public";
                                    $field_label     = "Public Note";
                                    ?>
                                    <i class="material-icons prefix">description</i>
                                    <textarea <?php echo $disabled;
                                                echo $readonly; ?> id="<?= $field_name; ?>" name="<?= $field_name; ?>" class="materialize-textarea validate "><?php if (isset(${$field_name})) {
                                                                                                                                                                    echo ${$field_name};
                                                                                                                                                                } ?></textarea>
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
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        if (isset($cmd) && $cmd == 'edit') { ?>
        </form>
    <?php } ?>
</div>