<style>
    .tabs .tab a:hover,
    .tabs .tab a.active {
        color: rgb(7, 123, 218);
        background-color: rgba(17, 116, 245, 0.15);
    }

    .tabs .tab a.active {
        color: rgb(7, 123, 218);
        background-color: rgba(17, 116, 245, 0.15);
    }
</style>
<div class="row">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab">
            <a href="#tab1_html" class="<?php if (isset($active_tab) && $active_tab == 'tab1') {
                                            echo "active";
                                        } ?>">
                <i class="material-icons">receipt</i>
                <span>Purchase Order</span>
            </a>
        </li>
        <?php
        if (po_permisions("Pkg_Logistics") == 1) {  ?>
            <li class="tab">
                <a href="#tab2_html" class="<?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab2')) {
                                                echo "active";
                                            } ?>">
                    <i class="material-icons">add_shopping_cart</i>
                    <span>Logistics</span>
                </a>
            </li>
        <?php }
        if (po_permisions("Pkg_Receive") == 1) { ?>
            <li class="tab">
                <a href="#tab3_html" class="<?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab3')) {
                                                echo "active";
                                            } ?>">
                    <i class="material-icons">assistant</i>
                    <span>Receive
                        <?php
                        $total_items_ordered = 0;
                        $sql2       = " SELECT sum(a.order_qty) as order_qty
                                        FROM package_materials_order_detail a
                                        WHERE a.po_id = '" . $id . "'
                                        AND a.enabled = 1 ";
                        $result_r2  = $db->query($conn, $sql2);
                        $count2     = $db->counter($result_r2);
                        if ($count2 > 0) {
                            $row_lg2                = $db->fetch($result_r2);
                            $total_items_ordered    = $row_lg2[0]['order_qty'];
                        }

                        $j = 0;
                        $sql3               = "SELECT a.id
                                                FROM package_materials_order_detail_receive a
                                                INNER JOIN package_materials_order_detail b ON b.id = a.po_detail_id 
                                                WHERE b.po_id = '" . $id . "'
                                                AND a.enabled = 1 ";
                        $result3            = $db->query($conn, $sql3);
                        $total_received     = $db->counter($result3);
                        if ($total_items_ordered > 0 && $total_received > 0) {
                            $total_received_percentage = ($total_received / $total_items_ordered) * 100;
                            if ($total_received_percentage > 0) {
                                if($total_received_percentage == '100'){
                                    echo " <span class='color-green'>(" . round(($total_received_percentage)) . "%)</span>";
                                }
                                else if ($total_received_percentage < '100') { 
                                    echo " <span class='color-yellow'>(" . round(($total_received_percentage)) . "%)</span>";
                                    ?>
                                    <i class="material-icons dp48 color-yellow">warning</i>
                                    <?php
                                }else if($total_received_percentage > '100'){
                                    echo " <span class='color-red'>(" . round(($total_received_percentage)) . "%)</span>";
                                }
                            }
                        } ?>
                    </span>
                </a>
            </li>
        <?php } ?>
        <li class="indicator" style="left: 0px; right: auto;"></li>
    </ul>
</div>