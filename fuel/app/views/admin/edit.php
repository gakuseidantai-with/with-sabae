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
							入力エラーがあります。
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
							<h4 class="title padding-bottom-lg">ユーザー情報変更</h4>
							<div style="text-align: none;">
								<p>現在ログインしているユーザー情報は以下の通りです。</p>
							</div>
							
							<form action="/with-admin/edit" method="post" enctype="multipart/form-data">
								<div class="panel">
									<div class="panel-body">
										<table class="table table-bordered horizon link">
											<tbody>
												<tr>
													<td style="vertical-align: middle;" width="30%">ユーザーID</td>
													<td><?php echo $loginUserInfo['ut_user_id']; ?></td>
												</tr>
												<tr>
													<td style="vertical-align: middle;">ニックネーム</td>
													<td>
														<?php isset($error['name']) ? print(error_tag($error['name'])) : ''; ?>
														<div class="form-group">
															<input class="form-control" type="text" id="ut_name" name="ut_name" value="<?php echo $loginUserInfo['ut_name']; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<td style="vertical-align: middle;">メールアドレス</td>
													<td>
														<?php isset($error['mailaddress']) ? print(error_tag($error['mailaddress'])) : ''; ?>
														<div class="form-group">
															<input class="form-control" type="text" id="ut_email" name="ut_email" value="<?php echo $loginUserInfo['ut_email']; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<td style="vertical-align: middle;">大学</td>
													<td>
														<?php isset($error['college']) ? print(error_tag($error['college'])) : ''; ?>
														<div class="form-group">
															<input class="form-control" type="text" id="ut_college" name="ut_college" value="<?php echo $loginUserInfo['ut_college']; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<td style="vertical-align: middle;">キャッチフレーズ</td>
													<td>
														<?php isset($error['catchphrase']) ? print(error_tag($error['catchphrase'])) : ''; ?>
														<div class="form-group">
															<input class="form-control" type="text" id="ut_catchphrase" name="ut_catchphrase" value="<?php echo $loginUserInfo['ut_catchphrase']; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<td style="vertical-align: middle;">画像</td>
													<td>
														<?php isset($error['image']) ? print(error_tag($error['image'])) : ''; ?>
														<div class="form-group">
															<div class="col-xs-12">
																<img id="thumbnail" src="../images/members/<?php echo $loginUserId; ?>.jpg" style="width: 100%; object-fit: contain; height: 150px;">
															</div>
															<table class="table data-table" style="margin: 0;">
																<tbody>
																	<td style="border: none;">
																		<input type="file" id="selfPicture" name="selfPicture" style="display: none;">
																		<button type="button" id="openfile" class="btn btn-primary" style="width:100%">ファイル選択</button>
																	</td>
																</tbody>
															</table>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="btnarea padding-bottom-sm">
											<input class="btn btn-primary" type="submit" value="変更">
										</div>
									</div>
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
	<script type="text/javascript">
		// ボタン、ファイル名テキストを押されたら
		// ファイル選択画面を表示
		$(document).on('click', '#openfile', function() {
			$('#selfPicture').click();
		});

		$('#selfPicture').change(function(){
			if (this.files.length > 0) {
				// 選択されたファイル情報を取得
				var file = this.files[0];

				// readerのresultプロパティに、データURLとしてエンコードされたファイルデータを格納
				var reader = new FileReader();
				reader.readAsDataURL(file);

				reader.onload = function() {
					$('#thumbnail').show();
					$('#thumbnail').attr('src', '' );
					$('#thumbnail').attr('src', reader.result );
				}
			}
		});
	</script>
</body>
</html>