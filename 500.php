<?php
include('path.php');
include($directory_path . "conf/session_start.php");
include($directory_path . "conf/connection.php");
include($directory_path . "conf/functions.php");
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="author" content="ThemeSelect">
  <title>500 Error | <?php echo ucwords(strtolower(PROJECT_TITLE)); ?> </title>
  <link rel="alternate" hreflang="en" href="<?php echo PROJECT_URL; ?>/500" />
  <link rel="canonical" href="<?php echo PROJECT_URL; ?>/500" />
  <link rel="apple-touch-icon" href="<?php echo $directory_path; ?>app-assets/images/favicon/apple-touch-icon-152x152.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $directory_path; ?>app-assets/images/favicon/favicon-32x32.png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- BEGIN: VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/vendors.min.css">
  <!-- END: VENDOR CSS-->
  <!-- BEGIN: Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/themes/vertical-modern-menu-template/materialize.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/themes/vertical-modern-menu-template/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/page-500.css">
  <!-- END: Page Level CSS-->
  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/custom/custom.css">
  <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column    blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
  <div class="row">
    <div class="col s12">
      <div class="container">
        <div class="section p-0 m-0 height-100vh section-500">
          <div class="row">
            <!-- 404 -->
            <div class="col s12 center-align white">
              <img src="<?php echo $directory_path; ?>app-assets/images/gallery/error-2.png" alt="" class="bg-image-500">
              <h1 class="error-code m-0">500</h1>
              <h6 class="mb-2">BAD REQUEST</h6>
              <a class="btn waves-effect waves-light gradient-45deg-deep-purple-blue gradient-shadow mb-4" href="<?php echo $directory_path; ?>main">Back
                TO Home</a>
            </div>
          </div>
        </div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>

  <!-- BEGIN VENDOR JS-->
  <script src="<?php echo $directory_path; ?>app-assets/js/vendors.min.js"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN THEME  JS-->
  <script src="<?php echo $directory_path; ?>app-assets/js/plugins.js"></script>
  <script src="<?php echo $directory_path; ?>app-assets/js/search.js"></script>
  <script src="<?php echo $directory_path; ?>app-assets/js/custom/custom-script.js"></script>
  <!-- END THEME  JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <!-- END PAGE LEVEL JS-->
</body>

</html>