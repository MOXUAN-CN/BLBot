<?php

global $Event, $Queue, $User_id;
loadModule('credit.tools');

//leave("因签到bug签到功能暂时关闭");

$income = rand(10000, 12000);
if(12000==$income)
{
    $income = -1040;
}
clearstatcache();
$lastCheckinTime = filemtime('../storage/data/checkin/'.$Event['user_id']);
if(0 == (int)date('md')-(int)date('md', $lastCheckinTime)){
    $reply = rand(1,14);
    switch ($reply){
        case 1:
        $replyWord = '你今天签到过了！（震声';break;
        case 2:
        $replyWord = '小可爱，你今天签到过了，不要再戳人家啦';break;
        case 3:
        $replyWord = '手也太勤快了吧亲，都已经签到过啦!';break;
        case 4:
        $replyWord = '签到过了呢';break;
        case 5:
        $replyWord = '今日已经签到，请明日再来!';break;
        case 6:
        $replyWord = '不要再戳签到啦，人家怕痛呢~';break;
        case 7:
        $replyWord = '给你讲个鬼故事，你今天签到过了。';break;
        case 8:
        $replyWord = '签到过了啦，到隔壁kjBot那里签到去。';break;
        case 9:
        $replyWord = '你…你失忆了？签到过了啊……';break;
        case 10:
        $replyWord = '还签到！再签到小心我扣光你的金币（';break;
        case 11:
        $replyWord = '签到过了啦（半恼）';break;
        case 12:
        $replyWord = '还签到…嫌金币不够是不是？去py2018962389啊';break;
        case 13:
        $replyWord = '老说签到签到，qiān dào，会读了吗？不要再问我了';break;
        case 14:
        $replyWord = '还签到？我签到你好不好？[CQ:at,qq='.$User_id.'] 签到！';break;
        case 15:
        $replyWord = '签到够了没…我都不知道说什么好……';break;
    };
    $Queue[]= sendBack($replyWord);
}else{
    addCredit($Event['user_id'], $income);
    delData('checkin/'.$Event['user_id']);
    setData('checkin/'.$Event['user_id'], '');
    $Queue[]= sendBack("[CQ:at,qq=".$User_id."]
签到成功，获得 ".$income." 个金币!
Tips: 不知道怎么玩可以发送 #help");
}

?>