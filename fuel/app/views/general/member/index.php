<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生団体with</title>
	<?php echo View::forge('common/head'); ?>
</head>
<body>
	<div id="fh5co-page">
		<?php echo View::forge('common/header'); ?>

		<div id="fh5co-work-section" style="padding-top: 7em;">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
	                    <h2>メンバー紹介</h2>
	                </div>
	            </div>
	        </div>
	    </div>

	    <div id="fh5co-work-section">
	        <div class="members_container">
	            <div class="row col-md-12">
	              <ui class="members">
	                <?php 
	                	// echo View::forge('general/member/member_list');
	                	echo View::forge('general/member/create_list')->set('users',$users);
	                ?>
	              </ui>
	            </div>
	        </div>
	    </div>

	    <?php echo View::forge('common/footer'); ?>
	</div>
	<?php echo View::forge('common/foot'); ?>
</body>
</html>