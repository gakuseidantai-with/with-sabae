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

		<div class="login content">
		<div class="container">
			<div class="row">
<?php if (!is_empty($error)) { ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $error; ?>
				</div>
<?php } ?>
<?php if (!is_empty($success)) { ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $success; ?>
				</div>
<?php } ?>
				<div class="col-md-6 col-xs-12" style="margin-top: 50px;">
					<img src="/images/with_logo.png" width="100%">
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="panel text-center">
						<div class="panel-body">
							<h4 class="title padding-bottom-lg">ログイン</h4>
							<form action="/with-admin/login" method="post">
								<div class="inputarea padding-bottom-lg">
									<div class="form-group">
										<input name="mailaddress" class="form-control" value="<?php echo $mail; ?>" placeholder="メールアドレス" type="email" required="required">
									</div>
									<div class="form-group">
										<input name="password" class="form-control" placeholder="パスワード" type="password" required="required">
									</div>
								</div>
								<div class="btnarea padding-bottom-sm">
									<input class="btn btn-primary" type="submit" value="ログイン">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

		<?php echo View::forge('common/footer'); ?>
	</div>
	<?php echo View::forge('common/foot'); ?>
</body>
</html>