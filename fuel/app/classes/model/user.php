<?php
/**
 * メンバーテーブルモデル
 */
class Model_User extends \Model_Crud
{
	// table name
	protected static $_table_name = "user_tbl" ;

	// primary key
	protected static $_primary_key = "ut_user_id" ;

	// column
	protected static $_properties = array (
		'ut_name',
		'ut_email',
		'ut_password',
		'ut_college',
		'ut_catchphrase',
		'ut_is_member',
	) ;

	// create date
	protected static $_created_at = "ut_created_at" ;

	// update date
	protected static $_updated_at = "ut_updated_at" ;

	// mysql time stamp
	protected static $_mysq_timestamp = true ;
}