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
				<div class="col-md-6 col-md-offset-3 col-xs-12">
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
					<div class="panel text-center">
						<div class="panel-body">
							<h4 class="title padding-bottom-lg">パスワード変更</h4>
							<div style="text-align: none;">
								<p>現在ログインしているユーザー情報は以下の通りです。</p>
								<p>
									ユーザーID：<?php echo $loginUserId; ?><br />
									ユーザー名：<?php echo $loginUserInfo['ut_name']; ?>
								</p>
							</div>
							
							<form action="/with-admin/password" method="post">
								<div class="inputarea padding-bottom-lg">
									<div class="form-group">
										<input name="old_password" class="form-control" placeholder="古いパスワード" type="password" required="required">
									</div>
									<br />
									<div class="form-group">
										<input name="new_password" class="form-control" placeholder="新しいパスワード" type="password" required="required">
									</div>
									<div class="form-group">
										<input name="re_new_password" class="form-control" placeholder="新しいパスワード（確認）" type="password" required="required">
									</div>
								</div>
								<div class="btnarea padding-bottom-sm">
									<input class="btn btn-primary" type="submit" value="変更">
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