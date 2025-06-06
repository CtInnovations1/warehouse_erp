<div id="tab2_html" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab2')) {
                                        echo "block";
                                    } else {
                                        echo "none";
                                    } ?>;">
    <div class="card-panel" style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 5px;">
        <div class="row">
            <div class="input-field col m6 s12" style="margin-top: 3px; margin-bottom: 3px;">
                <h6 class="media-heading">
                    <?= $general_heading; ?> => Logistics
                </h6>
            </div>
            <div class="input-field col m6 s12" style="text-align: right; margin-top: 3px; margin-bottom: 3px;">
                <?php include("tab_action_btns.php"); ?>
            </div>
        </div>
        <?php
        if (isset($id) && isset($return_no)) {  ?>
            <div class="row">
                <div class="input-field col m4 s12">
                    <h6 class="media-heading"><span class=""><?php echo "<b>Return#:</b>" . $return_no; ?></span></h6>
                </div>
                <div class="input-field col m4 s12">
                    <h6 class="media-heading"><span class=""><?php echo "<b>Vendor Invoice#: </b>" . $removal_order_id; ?></span></h6>
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
    if (isset($cmd2_1) && $cmd2_1 == 'edit') { ?>
        <div class="card-panel">
            <h5>Update Single Record</h5>
            <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&cmd2_1=edit&detail_id=" . $detail_id . "&active_tab=tab2") ?>" method="post">
                <input type="hidden" name="is_Submit_tab2_1" value="Y" />
                <input type="hidden" name="detail_id" value="<?php if (isset($detail_id)) echo $detail_id; ?>" />
                <input type="hidden" name="return_id" value="<?php if (isset($return_id)) echo $return_id; ?>" />
                <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                <input type="hidden" name="active_tab" value="tab2" />
                <div class="row">
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "tracking_no_update";
                        $field_label    = "Tracking No";
                        ?>
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
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "logistics_cost_update";
                        $field_label    = "Logistics Cost";
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
                        $field_name     = "no_of_boxes_update";
                        $field_label    = "Total Boxes";
                        ?>
                        <i class="material-icons prefix">description</i>
                        <input id="<?= $field_name; ?>" type="number" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } else {
                                                                                                            echo "1";
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
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "status_id_update";
                        $field_label     = "Status";
                        $sql1             = "SELECT * FROM inventory_status WHERE enabled = 1 AND id IN(" . $logistics_page_status . ") ORDER BY status_name ";
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
                </div>
                <div class="row">
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "courier_name_update";
                        $field_label    = "Courier Name";
                        ?>
                        <i class="material-icons prefix">description</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
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
                    <?php
                    $field_name     = "shipment_date_update";
                    $field_label     = "Shipment Date (d/m/Y)";
                    ?>
                    <div class="input-field col m3 s12">
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
                    <?php
                    $field_name     = "expected_arrival_date_update";
                    $field_label     = "Expected Arrival Date (d/m/Y)";
                    ?>
                    <div class="input-field col m3 s12">
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
                    <div class="input-field col m6 s12 text_align_right">
                        <?php if (access("add_perm") == 1) { ?>
                            <button class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="update_logistics">Update</button>
                        <?php } ?>
                    </div>
                    <div class="input-field col m6 s12"><br>
                        <a href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&cmd2=add&active_tab=tab2") ?>">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    $td_padding = "padding:5px 15px !important;";

    if (isset($id)) {
        $sql             = " SELECT a.*, c.status_name, a.logistics_cost
                            FROM return_order_detail_logistics a
 						    LEFT JOIN inventory_status c ON c.id = a.logistics_status
 						    INNER JOIN returns d ON d.id = a.return_id
                            WHERE a.return_id = '" . $id . "'
                            ORDER BY a.tracking_no";
        $result_log     = $db->query($conn, $sql);
        $count_log      = $db->counter($result_log);
        if ($count_log > 0) { ?>
            <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=edit&id=" . $id . "&active_tab=tab2") ?>" method="post">
                <input type="hidden" name="is_Submit_tab2_3" value="Y" />
                <input type="hidden" name="return_id" value="<?php if (isset($return_id)) echo $return_id; ?>" />
                <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                <input type="hidden" name="active_tab" value="tab2" />
                <div class="card-panel">
                    <div class="row">
                        <div class="col m12 s12">
                            <h5>
                                Logistics Detail
                                <?php
                                if ($count_log > 0) {?>
                                    <a href="components/<?php echo $module_folder; ?>/<?php echo $module; ?>/printlabels_pdf.php?string=<?php echo encrypt("module_id=" . $module_id . "&id=" . $id) ?>" target="_blank">
                                        <i class="material-icons dp48">print</i>
                                    </a>
                                <?php }?>
                            </h5>
                            <table class="bordered">
                                <thead>
                                    <tr>
                                        <?php
                                        $headings = '	<th class="sno_width_60">
                                                            <label>
                                                                <input type="checkbox" id="all_checked3" class="filled-in" name="all_checked3" value="1"   ';
                                        if (isset($all_checked3) && $all_checked3 == '1') {
                                            $headings .= ' checked ';
                                        }
                                        $headings .= ' 			/>
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th>Tracking#</th>
                                                        <th>Logistics <br>Cost (PO)</th> 
                                                        <th>Total Boxes</th> 
                                                        <th>Status</th> 
                                                        <th>Courier</th>
                                                        <th>Shipment Date</th>
                                                        <th>Expected <br>Arrival Date</th>
                                                        <th>Action</th>';
                                        echo $headings;
                                        $headings2 = ' '; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    if ($count_log > 0) {?> 
                                    <?php 
                                        $row_cl1 = $db->fetch($result_log);
                                        foreach ($row_cl1 as $data) {
                                            $detail_id2     = $data['id'];
                                            $arrived_date_11   = $data['arrived_date']; ?>
                                            <tr>
                                                <td style="text-align: center; <?= $td_padding; ?>">
                                                    <?php
                                                    if ($arrived_date_11 == '' || $arrived_date_11 == null) { ?>
                                                        <label style="margin-left: 25px;">
                                                            <input type="checkbox" name="logistics_ids[]" id="logistics_ids[]" value="<?= $detail_id2; ?>" <?php
                                                                                                                                                            if (isset($logistics_ids) && in_array($detail_id2, $logistics_ids)) {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?> class="checkbox3 filled-in" />
                                                            <span></span>
                                                        </label>
                                                    <?php
                                                    } ?>  
                                                </td>
                                                <td style="<?= $td_padding; ?>"><?php echo $data['tracking_no']; ?></td>
                                                <td style="text-align: right;<?= $td_padding; ?>"><?php echo number_format($data['logistics_cost'], 2); ?></td>
                                                <td style="text-align: center; <?= $td_padding; ?>"><?php echo $data['no_of_boxes']; ?></td>
                                                <td style="<?= $td_padding; ?>"><?php echo $data['status_name']; ?></td>
                                                <td style="<?= $td_padding; ?>"><?php echo $data['courier_name']; ?></td>
                                                <td style="<?= $td_padding; ?>"><?php echo dateformat2($data['shipment_date']); ?></td>
                                                <td style="<?= $td_padding; ?>"><?php echo dateformat2($data['expected_arrival_date']); ?></td>
                                                <td style="<?= $td_padding; ?>">
                                                    <?php
                                                    if ($data['edit_lock'] == 0 && access("edit_perm") == 1 && ($arrived_date_11 == '' || $arrived_date_11 == null)) { ?>
                                                        <a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=" . $cmd . "&cmd2_1=edit&active_tab=tab2&id=" . $id . "&detail_id=" . $detail_id2) ?>">
                                                            <i class="material-icons dp48">edit</i>
                                                        </a> &nbsp;

                                                        <a class="" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=" . $page . "&cmd=" . $cmd . "&cmd2_1=delete&active_tab=tab2&id=" . $id . "&detail_id=" . $detail_id2) ?>">
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

                    <div class="row">
                        <div class="input-field col m12 s12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m4 s12">
                            <?php
                            $field_name     = "logistics_status";
                            $field_label     = "Status";
                            $sql1             = "SELECT * FROM inventory_status WHERE enabled = 1 AND id IN(" . $logistics_page_status . ") ORDER BY status_name ";
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
                        <div class="input-field col m6 s12">
                            <?php if (isset($id) && $id > 0 && access("edit_perm") == 1) { ?>
                                <button class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="update_logistics">Update</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        <?php }
    }
    if (isset($cmd) && !isset($cmd2_1)) { ?>
        <form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=profile&cmd=edit&id=" . $id . "&cmd2=add&active_tab=tab2") ?>" method="post">
            <div class="card-panel">
                <input type="hidden" name="is_Submit_tab2" value="Y" />
                <input type="hidden" name="return_id" value="<?php if (isset($return_id)) echo $return_id; ?>" />
                <input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
                                                                    echo encrypt($_SESSION['csrf_session']);
                                                                } ?>">
                <input type="hidden" name="active_tab" value="tab2" />
                <div class="row">
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "tracking_no";
                        $field_label    = "Tracking No";
                        ?>
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
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "logistics_cost";
                        $field_label    = "PO Logistics Cost";
                        ?>
                        <i class="material-icons prefix">attach_money</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class="twoDecimalNumber validate <?php if (isset(${$field_name . "_valid"})) {
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
                        $field_name     = "no_of_boxes";
                        $field_label    = "Total Boxes";
                        ?>
                        <i class="material-icons prefix">description</i>
                        <input id="<?= $field_name; ?>" type="number" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } else {
                                                                                                            echo "1";
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
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "status_id";
                        $field_label     = "Status";
                        $sql1             = "SELECT * FROM inventory_status WHERE enabled = 1 AND id IN(" . $logistics_page_status . ") ORDER BY status_name ";
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
                                        <option value="<?php echo $data2['id']; ?>" <?php if (isset(${$field_name}) && ${$field_name} == $data2['id']) { ?> selected="selected" <?php } else if (!isset(${$field_name}) && $data2['id'] == '10') { ?> selected="selected" <?php } ?>><?php echo $data2['status_name']; ?> </option>
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
                    <div class="input-field col m3 s12">
                        <?php
                        $field_name     = "courier_name";
                        $field_label    = "Courier Name";
                        ?>
                        <i class="material-icons prefix">description</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class="validate <?php if (isset(${$field_name . "_valid"})) {
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
                    <?php
                    $field_name     = "shipment_date";
                    $field_label     = "Shipment Date (d/m/Y)";
                    ?>
                    <div class="input-field col m3 s12">
                        <i class="material-icons prefix">date_range</i>
                        <input id="<?= $field_name; ?>" type="text" name="<?= $field_name; ?>" value="<?php if (isset(${$field_name})) {
                                                                                                            echo ${$field_name};
                                                                                                        } ?>" class=" datepicker validate <?php if (isset(${$field_name . "_valid"})) {
                                                                                                                                                echo ${$field_name . "_valid"};
                                                                                                                                            } ?>">
                        <label for="<?= $field_name; ?>">
                            <?= $field_label; ?>
                            <span class="color-red"> <?php
                                                        if (isset($error2[$field_name])) {
                                                            echo $error2[$field_name];
                                                        } ?>
                            </span>
                        </label>
                    </div>
                    <?php
                    $field_name     = "expected_arrival_date";
                    $field_label     = "Expected Arrival Date (d/m/Y)";
                    ?>
                    <div class="input-field col m3 s12">
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
                    <div class="input-field col m12 s12 text_align_center">
                        <?php if (isset($id) && $id > 0 && access("edit_perm") == 1) { ?>
                            <button class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange" type="submit" name="add">Create</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    <?php
    } ?>
</div>