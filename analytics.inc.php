<?php
/*
        [DISCUZ!] dps_exadmincp/analytics.inc.php - 关于谷歌分析

        Version: 0.01
        Author: Bovvic(671064591@qq.com)
        Copyright: For author
        Last Modified: 2012.12.05
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;
$identifier = "dps_exadmincp";
cpheader();
if(!submitcheck('analyticssubmit')) {
	$setting = C::t('common_setting')->fetch_all(array('analytics'));
	$setting['analytics'] = (array)dunserialize($setting['analytics']);
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=' . $identifier . '&pmod=analytics');
	showtableheader();
	showsetting('启用谷歌分析', 'analyticsnew[allow]', $setting['analytics']['allow'], 'radio', 0, 1);
	
		showsetting('谷歌分析媒体资源ID', 'analyticsnew[_setAccount]', $setting['analytics']['_setAccount'], 'text');
		//showsetting('站点域名', 'analyticsnew[siteurl]', $siteurl, 'text');
		showsetting('跟踪站点加载速度的采样率', 'analyticsnew[_setSiteSpeedSampleRate]', $setting['analytics']['_setSiteSpeedSampleRate'], 'text');
	
	showtagfooter('tbody');
	showsubmit('analyticssubmit');
	showtablefooter();
	showformfooter();
	//echo $siteurl;
} else {
	$analyticsnew = serialize($_GET['analyticsnew']);
	C::t('common_setting')->update('analytics', $analyticsnew);
	updatecache(array('setting'));
	cpmsg('setting_update_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier='.$identifier.'&pmod=analytics', 'succeed');
}
?>