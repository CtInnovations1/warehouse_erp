<?php
include('path.php');
include($directory_path . "conf/session_start.php");
include($directory_path . "conf/connection.php");
include($directory_path . "conf/functions.php");
$db 	= new mySqlDB;
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"]) && isset($_SESSION["schoolDirectory"]) && $_SESSION["schoolDirectory"] == $project_folder &&  isset($_SESSION["project_name"]) && $_SESSION["project_name"] == $project_name) {
} else {
	echo redirect_to_page("signin");
	exit();
}

$db 				= new mySqlDB;
$selected_db_name 	= $_SESSION["db_name"];
$user_id 			= $_SESSION["user_id"];

if (isset($_GET['string'])) {
	$string 			= $_GET['string'];
	$parm 				= "?string=" . $string;
	$string 			= decrypt($string);
	$string_explode 	= explode('&', $string);

	$module 			= "";
	$page 				= "";
	$detail_id 			= "";
	$editmaster 		= "";
	$action 			= "";
	foreach ($string_explode as $value) {
		$string_data_explode = explode('=', $value);
		if ($string_data_explode[0] == 'module') {
			$module 			= $string_data_explode[1];
		}
		if ($string_data_explode[0] == 'module_id') {
			$module_id = $string_data_explode[1];
		}
		if ($string_data_explode[0] == 'detail_id') {
			$detail_id = $string_data_explode[1];
		}
		if ($string_data_explode[0] == 'id') {
			$id = $string_data_explode[1];
		}
	}
} else {
	echo redirect_to_page($directory_path . "signout");
}

$parm1 = $parm2 = $parm3 = "";
check_session_exist4($db, $conn, $_SESSION["user_id"], $_SESSION["username"], $_SESSION["user_type"], $_SESSION["db_name"], $parm2, $parm3);

extract($_POST);
$check_module_permission = check_module_permission($db, $conn, $module_id, $_SESSION["user_id"], $_SESSION["user_type"]);
if ($check_module_permission == "") {
	echo redirect_to_page($directory_path . "signout");
}
$css = "
		<style>
			body {
				font-family: Arial, sans-serif;
				margin: 0;
				padding: 10px;
				line-height: 1.6;
			}
			.header {
				text-align: right;
				margin-bottom: 0px;
				color:#0066CC;
			}
			.header h1 {
				font-size: 22px;
				margin: 0;
			}
			.header p {
				font-size: 8px;
				margin: 2px 0;
			}
		
			.table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}
			.table th, .table td {
				border: 1px solid #000;
				padding: 8px;
				text-align: left;
				font-size: 14px;
			}
			.table th {
				background-color:#0066CC;
				color:whitesmoke;
			}
			.table1 th {
				background-color:rgb(236, 237, 244);
			}
			.table1 {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}
			.table1 th, .table1 td {
				border: 1px solid #000;
				padding: 8px;
				text-align: left;
				font-size: 14px;
			}
			.total {
				text-align: right;
				margin-top: 10px;
				font-size: 16px;
				font-weight: bold;
			}
			hr{
				color:#E0E0E0;
			}
		</style>";
require_once $directory_path . 'mpdf/vendor/autoload.php';
// $mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf([
	'format' => 'A4',
	'margin_top' => 5,
	'margin_bottom' => 5,
	'margin_left' => 5,
	'margin_right' => 5,
]);
$sql_ee1 = "SELECT d.category_name, COUNT(a.id) AS total_qty,
					b.so_no, b.customer_invoice_no, b.order_date
			FROM sales_order_detail a  
			INNER JOIN sales_orders b ON b.id = a.sales_order_id
			INNER JOIN product_stock c ON c.id = a.product_stock_id
			INNER JOIN products c1 ON c1.id = c.product_id
			LEFT JOIN product_categories d ON d.id = c1.product_category
			WHERE a.sales_order_id = '" . $id . "' 
			AND a.enabled = 1
			GROUP BY c1.product_category
			ORDER BY c1.product_category ";
$result_ee11 	= $db->query($conn, $sql_ee1);
$counter_ee11	= $db->counter($result_ee11);
if ($counter_ee11 > 0) {
	$row_cl 		= $db->fetch($result_ee11);
	$so_no 			= $row_cl[0]["so_no"];
	$customer_invoice_no = $row_cl[0]["customer_invoice_no"];
	$order_date 	= dateformat2($row_cl[0]["order_date"]);

	$report_data = '<div class="">
						<div class="header">
							<h1>Sale Order Summary</h1>
						</div>
						<div>
							<p>	&nbsp;  <strong>Order#: </strong>' . $so_no . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Customer No#: </strong>' . $customer_invoice_no . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Order Date: </strong>' . $order_date . '</p>
						</div>
						<table class="table1">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Category</th>
									<th>Qty</th>
								</tr>
							</thead>
							<tbody>';
	$i = 0;
	foreach ($row_cl as $data) {
		$category_name	= $data['category_name'];
		$total_qty		= $data['total_qty'];

		$report_data .= '<tr>
															<td style="text-align: center;">' . ($i + 1) . '</td>
															<td>' . ucwords(strtolower($category_name)) . '</td>
															<td>' . $total_qty . '</td> 
                                        				</tr>';

		$i++;
	}
	$report_data .= '	</tbody>
						</table> 
					</div>';
	$report_data = $report_data . $css;
	//echo $report_data;die;
	$mpdf->AddPage('P', '', '', '', '', 10, 10, 15, 10, 0, 0);
	$mpdf->writeHTML($report_data);

	$mpdf->SetTitle('Sales Order Summary - ' . $so_no);
	$file_name = "Sales_Order_Summary_" . $so_no . "_" . date('YmdHis') . ".pdf";
	$mpdf->output($file_name, 'I');
} else {
	$report_data = '
	<div class="text_align_center main_font"> No record found </div>  ';  //echo $report_data;die;
	$report_data = $report_data . $css;
	$mpdf->AddPage('P', '', '', '', '', 10, 10, 15, 10, 0, 0);
	$mpdf->writeHTML($report_data);
	$mpdf->SetTitle('Sales Order Summary');
	$file_name = "Sales_Order_Summary_" . date('YmdHis') . ".pdf";
	$mpdf->output($file_name, 'I');
}
