<div class="user-list-container">
    <div class="user-list" id="user-list">
        <?php

         $sql1="SELECT b1.order_by,b1.location_id, d.sub_location_name, d.sub_location_type, COUNT(a.id) AS qty
                FROM `purchase_order_detail_receive` a
                INNER JOIN `purchase_orders` c ON c.id = a.po_id
                INNER JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                INNER JOIN users_bin_for_diagnostic b1 ON a.sub_location_id = b1.location_id AND b1.is_processing_done = '0'
                WHERE 1=1
                AND a.is_diagnost = 0 
                AND b1.enabled = 1
                GROUP BY a.sub_location_id, b1.id
                ORDER BY b1.order_by ASC ";
        //echo "<br><br><br><br><br><br>".$sql1;
        $result2 = $db->query($conn, $sql1);
        $count2    = $db->counter($result2);
        if ($count2 > 0) {
            $row2     = $db->fetch($result2);
            foreach ($row2 as $data_2) {
                $detail_id2             = $data_2['id'];
                
 
                $sql1 = "   SELECT b1.order_by,b1.location_id, d.sub_location_name, d.sub_location_type, COUNT(a.id) AS qty
                            FROM `purchase_order_detail_receive` a
                            INNER JOIN `purchase_orders` c ON c.id = a.po_id
                            INNER JOIN warehouse_sub_locations d ON d.id = a.sub_location_id
                            INNER JOIN users_bin_for_diagnostic b1 ON a.sub_location_id = b1.location_id AND b1.is_processing_done = '0'
                            WHERE 1=1
                            AND a.is_diagnost = 0 
                            AND b1.enabled = 1
                            GROUP BY a.sub_location_id, b1.id
                            ORDER BY b1.order_by ASC";
                $result1 = $db->query($conn, $sql1);
                $count1 = $db->counter($result1);
                if ($count1 > 0) {
                    $locations     = array();
                    $row         = $db->fetch($result1);
                    $locations     = $row;
                    foreach ($locations as $location_data) { ?>
                        <?php
                        $sql1 ="SELECT b.id, CONCAT(COALESCE(a.first_name), ' ', COALESCE(a.last_name)) AS user_full_name, a.profile_pic,
                                        b.location_id, b.bin_user_id, b2.sub_location_name, b2.sub_location_type ,b.assignment_no
                                FROM users a
                                INNER JOIN users_bin_for_diagnostic b ON a.id = b.bin_user_id AND b.is_processing_done = '0'
                                INNER JOIN warehouse_sub_locations b2 ON b2.id = b.location_id
                                WHERE b.location_id = '" . $location_data['location_id'] . "' ";
                        //echo "<br><br><br><br><br><br>".$sql1;
                        $result2 = $db->query($conn, $sql1);
                        $count2    = $db->counter($result2);
                        if ($count2 > 0) {
                            $row2     = $db->fetch($result2);
                            foreach ($row2 as $data_2) {

                                $detail_id2             = $data_2['id'];
                                $bin_user_id             = $data_2['bin_user_id'];
                                $location_id             = $data_2['location_id'];
                                $sub_location_name        = $data_2['sub_location_name'];
                                $sub_location_type        = $data_2['sub_location_type'];
                                $assignment_no            = $data_2['assignment_no'];
                                $total_estimated_time     = 0;
                                
                                $sql_time ="SELECT IFNULL((COUNT(a.id) / e.devices_per_user_per_day), 0) AS estimated_time
                                            FROM purchase_order_detail_receive a
                                            LEFT JOIN formula_category e ON e.product_category = a.recevied_product_category AND e.formula_type = 'Diagnostic' AND e.enabled = 1
                                            INNER JOIN users_bin_for_diagnostic d1 ON d1.location_id = a.sub_location_id AND d1.`is_processing_done` = 0 
                                            WHERE 1=1
                                            AND is_diagnost = 0
                                            AND d1.bin_user_id = '$bin_user_id' 
                                            AND d1.location_id = '$location_id' 
                                            GROUP BY a.sub_location_id, e.product_category";
                                $result_time    = $db->query($conn, $sql_time);
                                $count_time    = $db->counter($result_time);
                                if ($count_time > 0) {
                                    $row_time = $db->fetch($result_time);
                                    foreach ($row_time as $data_time) {
                                        $total_estimated_time += $data_time['estimated_time'];  ?>
                                <?php }
                                } ?>
                                <div style="text-align:center;" class="user" draggable="true" data-id="<?php echo $data_2['id']; ?>">
                                    <img src="app-assets/images/logo/<?php echo $data_2['profile_pic']; ?>" alt="images" style="height:100px !important;" class="circle z-depth-2 responsive-img" />
                                
                                    <h6 class=" lighten-4"><?php echo $data_2['user_full_name']; ?>  </h6>
                                    <h5 class=" lighten-4">
                                        <?php echo $sub_location_name;?>
                                    </h5>
                                    <h6 class=" lighten-4">
                                        <?php echo $assignment_no; ?><br><br>
                                        <?php echo round($total_estimated_time, 2); ?> Days</h6>
                                    <a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&page=listing&cmd=disabled&id=" . $detail_id2) ?>" title="Disable" onclick="return confirm('Are you sure, You want to delete this record?')">
                                        <i class="material-icons dp48">delete</i>
                                    </a>
                                    <a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan" href="?string=<?php echo encrypt("module=" . $module . "&module_id=" . $module_id . "&bin_user_id=" . $bin_user_id . "&location_id=" . $location_id . "&page=editAssignment&cmd=edit&id=" . $detail_id2) ?>" title="Edit">
                                        <i class="material-icons dp48">edit</i>
                                    </a>
                                </div>
                        <?php 
                            }
                        }
                    }
                }
            }
        } ?>
    </div>
</div>