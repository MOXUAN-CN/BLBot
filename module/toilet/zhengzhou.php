<?php

requireLvl(6);

$lines = json_decode(file_get_contents('https://api.zzmetro.com/api/stations'), true)['data'];
$stationPage = 'https://www.zzmetro.com/lines/query/station/zid/';
$data = json_decode(getData('toilet/data.json'), true);
setCache('toilet/'.time().'.bak', json_encode($data));
$data['郑州地铁'] = [];

foreach($lines['stations'] as $lineId => $stations){
	if($lineId == '9') $lineName = '城郊线';
	else if($lineId == '17') $lineName = '郑许线';
	else $lineName = $lineId.'号线';
	foreach($stations as $stationId => $station){
		if(!in_array($station, ['郑州火车站', '郑州东站', '郑州西站', '许昌东站', '郑州航空港站'])){
			$station = preg_replace('/站$/', '', $station);
		}
		if(!$data['郑州地铁'][$station]) $data['郑州地铁'][$station] = '';
		$html = file_get_contents($stationPage.$stationId);
		if(preg_match('/<span class="pad03 w170">卫生间<\/span> <p>所在位置：<em>((.|\n)*?)<\/em><\/p>/', $html, $match) && $match[1]){
			$toilets = [];
			foreach(explode(',', str_replace("\n", ',', $match[1])) as $toilet){
				$toilets[] = '［'.$lineName.'］'.$toilet;
			}
			if($data['郑州地铁'][$station]){
				array_splice($toilets, 0, 0, $data['郑州地铁'][$station]);
			}
			$data['郑州地铁'][$station] = implode("\n", $toilets);
		}
	}
}
foreach($data['郑州地铁'] as $stationName => $toilets){
	if(!$toilets){
		$data['郑州地铁'][$stationName] = '无数据，该站可能无卫生间';
	}
}

setData('toilet/data.json', json_encode($data));
replyAndLeave('更新数据成功，共 '.count($data['郑州地铁']).' 条数据');

?>
