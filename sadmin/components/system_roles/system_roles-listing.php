<?php
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_sadmin_directory_access();
}
$db = new mySqlDB;

extract($_REQUEST);
foreach ($_POST as $key => $value) {
	if (!is_array($value)) {
		$data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}
if (isset($cmd) && $cmd == 'delete') {
	$sql_check 		= "	SELECT * FROM role_permissions a WHERE a.enabled = 1 AND a.role_id = '" . $id . "' ";
	$result_check 	= $db->query($conn, $sql_check);
	$count_check 	= $db->counter($result_check);
	if ($count_check == 0) {
		$sql_ee2 	= " UPDATE roles SET enabled = 0 WHERE id = '" . $id . "' ";
		$ok_del = $db->query($conn, $sql_ee2);
		if ($ok_del) {
			$msg['msg_success'] = "<span class='color-green'>Role has been deleted.";
		}
	} else {
		$error['msg'] = "This Role is in use.";
	}
}
//if(isset($is_filtered) && $is_filtered == 'Y'){
if (empty($error)) {
	$sql_cl = "	SELECT a.* FROM roles a WHERE a.enabled	= 1  "; // AND a.role_name	!= 'Super Admin'
	if (isset($role_name) && $role_name != "") {
		$sql_cl .= " AND a.role_name like '%" . $role_name . "%'";
	}
	$result_cl 	= $db->query($conn, $sql_cl);
	$count_cl 	= $db->counter($result_cl);
	if ($count_cl == 0) {
		$error['msg'] = "Sorry!, No role found, Please create role first and set permisions.";
	}
}
//}
$page_heading = "Create Role or Set Permissions For System Users "; ?>
<!-- BEGIN: Page Main-->
<div id="main" class="<?php echo $page_width; ?>">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
		<div class="breadcrumbs-dark pb-0" id="breadcrumbs-wrapper">
			<!-- Search for small screen-->
			<div class="container">
				<div class="row">
					<div class="col s10 m6 l6">
						<h5 class="breadcrumbs-title mt-0 mb-0"><span><?php echo $page_heading; ?></span></h5>
						<ol class="breadcrumbs mb-0">
							<li class="breadcrumb-item"><a href="home">Home</a>
							</li>
							</li>
							<li class="breadcrumb-item active">List</li>
						</ol>
					</div>
					<div class="col s2 m6 l6">
						<a class="btn waves-effect waves-light green darken-1 breadcrumbs-btn right" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=add") ?>" data-target="dropdown1">
							Add New
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12">
			<div class="container">
				<div class="section section-data-tables">
					<!-- Page Length Options -->
					<div class="row">
						<div class="col s12">
							<div class="card">
								<div class="card-content">
									<h4 class="card-title"><?php echo $page_heading; ?></h4>
									<div class="row">
										<div class="col s12">
											<table id="page-length-option" class="display">
												<thead>
													<tr>
														<th class="text-align-center">Role Name</th>
														<th class="text-align-center">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if ($count_cl > 0) {
														$i = 0;
														$row_cl = $db->fetch($result_cl);
														foreach ($row_cl as $data) {
															$i = $i + 1; ?>
															<tr>
																<td><?php echo $data['role_name']; ?></td>
																<td class="text-align-center">
																	<a class="waves-effect waves-light  btn gradient-45deg-light-blue-cyan box-shadow-none border-round mr-1 mb-1" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $data['id']) ?>">
																		<i class="material-icons dp48">edit</i>
																	</a>
																	<a class="waves-effect waves-light green darken-1  btn gradient-45deg-light-green-cyan box-shadow-none border-round mr-1 mb-1" title="Set Permissions" class="" href="?string=<?php echo encrypt("module=" . $module . "&page=permisions&cmd=edit&id=" . $data['id']) ?>">
																		<i class="material-icons dp48">folder</i>
																	</a>
																	<?php
																	$sql1 		= " SELECT * FROM role_permissions WHERE enabled = 1 AND role_id = '" . $data['id'] . "'";
																	$result1 	= $db->query($conn, $sql1);
																	$count1 	= $db->counter($result1);
																	if ($count1 == 0) { ?>
																		<a class="waves-effect waves-light  btn gradient-45deg-red-pink box-shadow-none border-round mr-1 mb-1" href="?string=<?php echo encrypt("module=" . $module . "&page=listing&cmd=delete&id=" . $data['id']) ?>" onclick="return confirm('Are you sure! You want to Delete Role?')">
																			<i class="material-icons dp48">delete</i>
																		</a>
																	<?php } ?>
																</td>
															</tr>
													<?php }
													} ?>
												<tfoot>
													<tr>
														<th class="text-align-center">Role Name</th>
														<th class="text-align-center">Actions</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Multi Select -->
				</div><!-- START RIGHT SIDEBAR NAV -->
				<?php include('sub_files/right_sidebar.php'); ?>
			</div>
			<div class="content-overlay"></div>
		</div>
	</div>
</div>