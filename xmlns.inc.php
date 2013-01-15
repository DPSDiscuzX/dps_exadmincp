<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

global $_G;
$identifier = "dps_exadmincp";
cpheader();

if(true){

	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=' . $identifier . '&pmod=xmlns');
	showtableheader('');
	showtablerow('', array('class="td25"', 'class="td28"', 'class="td25"', 'class="td25"', '', '', '', 'class="td23"', 'class="td25"'), array(
		'',
		cplang('display_order'),
		'',
		cplang('available'),
		cplang('前缀'),
		cplang('引用'),
		cplang('(预留位置)'),
	));
	print "
<script type=\"text/JavaScript\">
	var rowtypedata = [
		[
			[1,'', 'td25'],
			[1,'<input type=\"text\" class=\"txt\" name=\"newdisplayorder[]\" size=\"3\">', 'td28'],
			[1,'', 'td25'],
			[1,'<input type=\"checkbox\" name=\"newavailable[]\" value=\"1\">', 'td25'],
			[1,'xmlns:<input type=\"text\" class=\"txt\" name=\"newprefix[]\" size=\"10\">='],
			[1,'\"<input type=\"text\" class=\"txt\" name=\"newhref[]\" size=\"20\">\"'],
			[1,'', 'td23']
		]
	];
</script>"
	;

	$_CA['xmlns'] = (array)dunserialize($_CA['xmlns']);
	//echo sizeof($_CA['xmlns']);
	foreach($_CA['xmlns'] as $xmlns) {

		if(!$xmlns['prefix'] == ''){
			$checkavailable = $xmlns['available'] ? 'checked' : '';
			$xmlns['idtype'] = cplang('click_edit_'.$xmlns['idtype']);
			showtablerow('', array('class="td25"', 'class="td28"', 'class="td25"', 'class="td25"', '', '', '', 'class="td23"', 'class="td25"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$xmlns[xmlnsid]\">",
				"<input type=\"text\" class=\"txt\" size=\"3\" name=\"displayorder[$xmlns[xmlnsid]]\" value=\"$xmlns[displayorder]\">",
				//	"<img src=\"static/image/click/$xmlns[icon]\">",
				"&nbsp;",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"available[$xmlns[xmlnsid]]\" value=\"1\" $checkavailable>",
				"xmlns:<input type=\"text\" class=\"txt\" size=\"10\" name=\"prefix[$xmlns[xmlnsid]]\" value=\"$xmlns[prefix]\">=",
				"\"<input type=\"text\" class=\"txt\" size=\"20\" name=\"href[$xmlns[xmlnsid]]\" value=\"$xmlns[href]\">\"",
				$xmlns['idtype']
			));
		}
	}
	echo '<tr><td></td><td colspan="8"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.'添加命名空间'.'</a></div></td></tr>';
	showsubmit('settingsubmit', 'submit', 'del');
	showtablefooter();
	showformfooter();
} else {
	$settingnew = $_GET['settingnew'];
	//$ids = array();
	//$xmlns = array($settingnew['xmlns']);


	if(is_array($_GET['prefix'])) {
		foreach($_GET['prefix'] as $xmlnsid => $val) {
			//$xmlnsid = intval($xmlnsid);
			//echo intval($xmlnsid == '');
			$updatearr = array(
				'xmlnsid' => dhtmlspecialchars($_GET['prefix'][$xmlnsid]),
				'prefix' => dhtmlspecialchars($_GET['prefix'][$xmlnsid]),
				'href' => $_GET['href'][$xmlnsid],
				'idtype' => 'xmlns',
				'available' => intval($_GET['available'][$xmlnsid]),
				'displayorder' => intval($_GET['displayorder'][$xmlnsid]),
			);
			//C::t('home_click')->update($id, $updatearr);
			$settingnew['xmlns'][$xmlnsid] = $updatearr;
		}
	}
	if(is_array($_GET['delete'])) {
		foreach($_GET['delete'] as  $id => $val) {
			//$ids[] = $id;
			//echo $_GET['delete'][$id];
			//echo '=';
			//echo $_GET['delete'][$id];
			//echo ';';
			//$xmlns[($id)] = array();
			//$xmlns = array_splice($xmlns, intval($id), 1);
			unset($settingnew['xmlns'][$_GET['delete'][$id]]);
		}
		if($ids) {
			//C::t('home_click')->delete($ids, true);
		}
	}

	if(is_array($_GET['newprefix'])) {
		foreach($_GET['newprefix'] as $key => $value) {
			//echo $key;
			//echo "=";
			//echo $value;
			if($value != '' && $_GET['newhref'][$key] != '') {
				$data = array(
					'xmlnsid' => dhtmlspecialchars($value),
					'prefix' => dhtmlspecialchars($value),
					'href' => $_GET['newhref'][$key],
					'idtype' => 'xmlns',
					'available' => intval($_GET['newavailable'][$key]),
					'displayorder' => intval($_GET['newdisplayorder'][$key])
				);
				//C::t('home_click')->insert($data);
				//print_r( $data);
				//array_push($xmlns, $data);
				$settingnew['xmlns'][dhtmlspecialchars($value)] = $data;
			}
		}
	}
	$settingnew['xmlns'] = serialize($settingnew['xmlns']);
	C::t('common_setting')->update_batch($settingnew);
	updatecache('setting');


	//echo $settingnew['xmlns'];
	/*
		$keys = $ids = $_G['cache']['click'] = array();
		foreach(C::t('home_click')->fetch_all_by_available() as $value) {
			if(count($_G['cache']['click'][$value['idtype']]) < 8) {
				$keys[$value['idtype']] = $keys[$value['idtype']] ? ++$keys[$value['idtype']] : 1;
				$_G['cache']['click'][$value['idtype']][$keys[$value['idtype']]] = $value;
			} else {
				$ids[] = $value['clickid'];
			}
		}
		if($ids) {
			C::t('home_click')->update($ids, array('available'=>0), true);
		}
		*/


	//$_G['cache']['plugin'][$identifier]['analytics'] = $settingnew['analytics'];
	//echo "<textarea>".$_G['cache']['plugin'][$identifier]."</textarea>";


	////////////////////////////////////////////////////////////////////////////////


	/*
	$msg = '&#20026;&#20102;&#27491;&#24120;&#20351;&#29992;&#27492;&#25554;&#20214;&#65292;&#24744;&#21487;
	&#33021;&#36824;&#38656;&#35201;&#19978;&#20256;&#25110;&#20462;&#25913;&#30456;&#24212;&#30340;&#25991;
	&#20214;&#25110;&#27169;&#26495;&#65292;&#35814;&#24773;&#35831;&#26597;&#30475;&#26412;&#25554;&#20214;&#30340;&#23433;&#35013;&#35828;&#26126;';
	$file = DISCUZ_ROOT.'./template/default/common/header_common.htm';
	function xm_file_content_exists($file, $message, $method = 'stripos') {
		if(file_exists($file)) {
			$content = file_get_contents($file);
			if($method == 'stripos') {
				return stripos($content, $message) !== false;
			}elseif($method == 'preg_match'){
				return preg_match($message, $content);
			}
		}
		return false;
	}
	function xm_file_replace($file, $pattern, $replace, $method = 'str_replace', $limit = -1) {
		if(file_exists($file)) {
			$content = file_get_contents($file);
			if($method == 'str_replace') {
				$content = str_replace($pattern, $replace, $content, $limit);
			}elseif($method == 'preg_replace_callback' || $method == 'preg' && is_callable($replace)) {
				$content = preg_replace_callback($pattern, $replace, $content, $limit);
			}else{
				$content = preg_replace($pattern, $replace, $content, $limit);
			}
			if($content !== false) {
				file_put_contents($file, $content);
				return true;
			}
		}
		return false;
	}




	$hooker = '{hook/global_header_xmlns}';
	$pattern = "/<html( xmlns(\:[a-z0-9]+)?\=(\'|\")[a-zA-Z0-9\:\/\.]+(\'|\"))*>/i";
	$replacement = "<html$1$hooker>";
	$method = "preg_replace";
	if(!xm_file_content_exists($file, $hooker)){
		if(!xm_file_content_exists($file, $pattern, "preg_match") || !xm_file_replace($file, $pattern, $replacement, $method))
			cpmsg($msg, 'action=plugins&operation=config&do='.$pluginid.'&identifier='.$identifier.'&pmod=footercp', 'error');
	}




	$hooker = "<!--{hook/global_header_meta}-->";
	$pattern = "/(\t*)(<!--{csstemplate}-->)/i";
	$replacement = "$1$2\r\n$1$hooker";
	if(!xm_file_content_exists($file, $hooker)){
		if(!xm_file_content_exists($file, $pattern, "preg_match") || !xm_file_replace($file, $pattern, $replacement, $method))
			cpmsg($msg, 'action=plugins&operation=config&do='.$pluginid.'&identifier='.$identifier.'&pmod=footercp', 'error');
	}

	*/


	//////////////////////////////////////////////////////////////////////////////



	cpmsg('setting_update_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier='.$identifier.'&pmod=xmlns', 'succeed');
}

?>