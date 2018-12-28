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
							<h4 class="title padding-bottom-lg">ユーザー情報</h4>
						</div>
						<p>現在ログインしているユーザー情報は以下の通りです。</p>
						<div>
							<table class="table table-bordered horizon link">
								<tbody>
									<tr>
										<td>ユーザーID</td>
										<td><?php echo $loginUserInfo['ut_user_id']; ?></td>
									</tr>
									<tr>
										<td>ニックネーム</td>
										<td><?php echo $loginUserInfo['ut_name']; ?></td>
									</tr>
									<tr>
										<td>メールアドレス</td>
										<td><?php echo $loginUserInfo['ut_email']; ?></td>
									</tr>
									<tr>
										<td>大学</td>
										<td><?php echo $loginUserInfo['ut_college']; ?></td>
									</tr>
									<tr>
										<td>キャッチフレーズ</td>
										<td><?php echo $loginUserInfo['ut_catchphrase']; ?></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-bordered horizon link">
								<tbody>
									<tr>
										<!-- <td width="30%"><a href="/watcher">登下校監視システム</a></td> -->
										<td><a href="with-admin/logout">ログアウト</a></td>
										<td><a href="with-admin/password">パスワード変更</a></td>
										<td><a href="with-admin/edit">ユーザー情報変更</a></td>
									</tr>
								</tbody>
							</table>
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