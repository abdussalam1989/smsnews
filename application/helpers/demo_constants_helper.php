<?php
//for site_url and admin_url
$ci= & get_instance();
//echo "<pre>";
//print_r($ci); exit;
//echo "<pre>";
//print_r($ci->config->item('admin_folder')); exit;


define('SITE_URL',$ci->config->base_url());
define('ADMIN_URL',$ci->config->base_url().$ci->config->item('admin_folder'));

//SEND SMS links for api 1
/*define('API1_SCHEDULE_LINK','http://smsh.clickschooldiary.com/api/schedulemsg.php?');
define('API1_INSTANT_LINK','http://smsh.clickschooldiary.com/api/sendmsg.php?');
define('API1_GETSTATUS_LINK','http://smsh.clickschooldiary.com/api/recdlr.php?'); */

define('API1_SCHEDULE_LINK','http://148.251.126.231/api/schedulemsg.php?');
define('API1_INSTANT_LINK','http://148.251.126.231/api/sendmsg.php?');
define('API1_GETSTATUS_LINK','http://148.251.126.231/api/recdlr.php?');


//:http://148.251.126.231/api/sendmsg.php?

//SEND SMS links for api 2
//define('API2_SCHEDULE_LINK','http://smsh.clickschooldiary.com/api/schedulemsg.php?');
define('API2_INSTANT_LINK','http://smartsms.clickschooldiary.com/api2/send/?');
//define('API2_GETSTATUS_LINK','http://smsh.clickschooldiary.com/api/recdlr.php?');

//define table name
define('ADMIN_MASTER','admin_master');
define('EMAIL_FORMATES','email_formats');
define('USERS','users');
define('PAGES','pages');
define('STATICPAGES','staticpages');
define('COUNTRY','country');
define('EMAIL_TEMPLATES','email_templates');
define('STATE','states');
define('CITY','cities');
define('SITE','site_setting');
define('CONTACT_US','account_manager');
define('NEWSLETTER_SUBSCRIBERS','newsletter_subscribers');
define('INSTITUTION','institution');
define('CLASSES','classes');
define('CLASS_TEACHER','class_teacher');
define('GROUP','sms_group');
define('STAFF','staff');
define('STUDENT','student');
define('SMS_TEMPLATE','sms_template');
define('HOMEWORK','homework');
define('SMS_LOG','sms_log');
define('SMS_API','sms_api');
define('ATTENDANCE_SHEET', 'attendance_sheet');
define('SMS_LOG_MASTER','sms_log_master');
define('SMS_GROUP_INFO','sms_group_info');
define('ATTENDANCE_SMS_TEMPLATE','attendance_sms_template');
define('SMS_ALLOCATION_HISTORY', 'sms_allocation_history');
define('SMS_TYPE_LIST','sms_type_list');
define('SMS_PRIORITY_LIST','sms_priority_list');
define('SMS_FOR_LIST','sms_for_list');
define('ATTENDANCE_TAKE_TYPE','attendance_take_type');
define('TINY_URL','tiny_url');
// define folder to upload image
define('ADMIN_PROFILE_IMAGES','upload/admin_image/');
define('ADMIN_PROFILE_IMAGES_THUMB','upload/admin_image/thumb/');

define('USER_IMAGES','upload/user_image/');
define('USER_IMAGES_THUMB','upload/user_image/thumb/');


define('LOGO_IMAGE','upload/logo/');
define('LOGO_IMAGE_THUMB','upload/logo/thumb/');

define('BANNER_IMAGE','upload/banner/');
define('BANNER_IMAGE_THUMB','upload/banner/thumb/');

define('CSV_UPLOAD','upload/csv/temp');
define('CSV_TEMP_UPLOAD','upload/temp');

define('UPLOAD_FILES','upload/files/');

//define url
define('URL',base_url());

//set height width for thumb image
define('USER_PROFILE_HEIGHT','200');
define('USER_PROFILE_WIDTH','200');

define('ADMIN_PROFILE_HEIGHT','200');
define('ADMIN_PROFILE_WIDTH','200');

define('LOGO_HEIGHT','200');
define('LOGO_WIDTH','200');

define('BANNER_HEIGHT','200');
define('BANNER_WIDTH','200');


