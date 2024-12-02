<?php

global $Event;
loadModule('ddl.tools');

$reply = ['你的待办事项：'];
$ddls = getDdl($Event['user_id']);
if(!count($ddls)) {
    replyAndLeave('暂无未完成的待办事项哦…');
}
usort($ddls, function ($a, $b) {
    return $a['time'] <=> $b['time'];
});
foreach($ddls as $ddl) {
    $time = date('Y/m/d', $ddl['time']);
    $reply[] = "{$time} {$ddl['name']}";
}

replyAndLeave(implode("\n", $reply));