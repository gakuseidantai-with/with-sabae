<?php
// [
//  'position' => '',
// 	'name' => 'cccccc',
// 	'college' => 'cccccc',
// 	'image' => '../images/members/sample.jpg',
// 	'date' => 'xxxx-xx',
// ],
$lists = [
	// 代表 学部4年
	[
		'position' => 'パリピっぽい陰キャな代表',
		'name'     => 'ざわ',
		'college'  => '福井大学 工学部',
		'image'    => '../images/members/naoto.jpg',
		'date'     => 'null',
	],
	// 副代表 学部4年
	[
		'position' => 'withの特攻隊長🐻（副代表）',
		'name'     => 'みさも',
		'college'  => '福井県立大学 経済学部',
		'image'    => '../images/members/misamo.jpg',
		'date'     => 'null',
	],
	// 会計 学部4年
	[
		'position' => 'withのお姉さん担当（会計）',
		'name'     => 'りな',
		'college'  => '福井県立大学 経済学部',
		'image'    => '../images/members/rina.jpg',
		'date'     => 'null',
	],
	[
		'position' => '人狼ですぐに騙される人',
		'name'     => 'にーのみ',
		'college'  => '東京大学',
		'image'    => '../images/members/ryota.jpg',
		'date'     => 'null',
	],
	// 大学院
	[
		'position' => 'withの右手中指',
		'name'     => 'りょーへー',
		'college'  => '福井大学大学院 工学専攻科',
		'image'    => '../images/members/ryohei.jpg',
		'date'     => '2018-07',
	],
	// 学部4年
	[
		'position' => '夢の世界の住人',
		'name'     => 'りんちょ',
		'college'  => '福井大学 ',
		'image'    => '../images/members/rincho.jpg',
		'date'     => 'null',
	],
	[
		'position' => '明日やろうは馬鹿野郎の人',
		'name'     => 'はっしー',
		'college'  => '福井工業大学 工学部',
		'image'    => '../images/members/hashimoto.jpg',
		'date'     => '2018-02',
	],
	[
		'position' => 'withのルフィ',
		'name'     => 'うっちー',
		'college'  => '福井大学 医学部',
		'image'    => '../images/members/yusuke.jpg',
		'date'     => '2018-11',
	],
	[
		'position' => 'withのマイナスイオン',
		'name'     => 'みむ',
		'college'  => '福井高専 環境システム工学専攻',
		'image'    => '../images/members/mimu.jpg',
		'date'     => '2018-10',
	],
	// 学部3年
	[
		'position' => 'with研究生',
		'name'     => 'なおや',
		'college'  => '福井県立大学 経済学部',
		'image'    => '../images/members/naoya.jpg',
		'date'     => '2018-11',
	],
	[
		'position' => 'withのDJ',
		'name'     => 'のむのむ',
		'college'  => '福井高専 生産システム工学専攻',
		'image'    => '../images/members/nomunomu.jpg',
		'date'     => 'null',
	],
	[
		'position' => 'withの海外支局長',
		'name'     => 'たまみ',
		'college'  => '福井県立大学 経済学部',
		'image'    => '../images/members/tamami.jpg',
		'date'     => '2018-06',
	],
	[
		'position' => 'withの童顔担当',
		'name'     => 'きょーか',
		'college'  => '仁愛大学 子ども教育',
		'image'    => '../images/members/kyouka.jpg',
		'date'     => 'null',
	],
	[
		'position' => 'まだまだ新人ちゃん',
		'name'     => 'るみ',
		'college'  => '福井県立大学 経済学部',
		'image'    => '../images/members/rumi.jpg',
		'date'     => '2018-07',
	],
	[
		'position' => 'with東京支部',
		'name'     => 'そすけ',
		'college'  => '慶應義塾大学',
		'image'    => '../images/members/sosuke.jpg',
		'date'     => '2018-09',
	],
	// 学部1年
	// 高校生
	[
		'position' => 'withの納豆マスター',
		'name'     => 'しもけん',
		'college'  => '武生商業高校',
		'image'    => '../images/members/shimoken.jpg',
		'date'     => '2018-09',
	],
	[
		'position' => 'with期待の新人',
		'name'     => 'ゆーた',
		'college'  => '鯖江高校',
		'image'    => '../images/members/yuuta.jpg',
		'date'     => '2018-09',
	],
	[
		'position' => 'With最年少',
		'name'     => 'しづき',
		'college'  => '藤島高校1年',
		'image'    => '../images/members/shiduki.jpg',
		'date'     => '2018-11',
	],
];

$now_date = new DateTime();
$entered_date = null;
$diff = null;

foreach ($lists as $list) {
		$position = $list['position'];
		$name = $list['name'];
		$college = $list['college'];
		$image = $list['image'];

		if ( $list['date'] != "null" ) {
			global $entered_date, $diff;
			$entered_date = DateTime::createFromFormat('Y-m', $list['date']);
			$diff = $now_date->diff($entered_date);
		}

echo <<< END
<li class="member_item">
	<div class="member_thumb">
		<img src="$image" alt="$name" />
	</div>
	<div class="member_detail">
END;

if ( $list['date'] != "null" ) {
	if ( $diff->m < 2 ) {
		echo "<p>$position</p>";
	}else {
		echo "<p>$position</p>";
	}
}else {
	echo "<p>$position</p>";
}

if ( $list['college'] != 'null' ) {
		echo "<p>$college</p>";
}else {
		echo "<p>　　</p>";
}
echo <<< END
	</div>
	<h3 class="member_title">$name</h3>
</li>
END;

}
