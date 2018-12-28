<?php

foreach ($users as $user) {
	$catchphrase = $user->ut_catchphrase;
	$name        = $user->ut_name;
	$college     = $user->ut_college;
	$imageName   = $user->ut_user_id . '.jpg';

	echo ''.'
	<li class="member_item">
		<div class="member_thumb">
			<img src="../images/members/' . $imageName  . '" alt="' . $name . '" />
		</div>
		<div class="member_detail">
			<p>' . $catchphrase . '</p>
			<p>' . $college . '</p>
		</div>
		<h3 class="member_title">' . $name . '</h3>
	</li>
	';
}