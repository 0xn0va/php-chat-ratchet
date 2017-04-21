<?php
$settings = array();
$settings['dbhost'] = 'localhost';
$settings['dbuser'] = 'abdotask';
$settings['dbpass'] = 'nhzh1SWNSKvFZ8A5';
$settings['dbname'] = 'abdotask';

@include_once("config.php");

mysql_connect($settings['dbhost'], $settings['dbuser'], $settings['dbpass']);
mysql_selectdb($settings['dbname']);

function getNick() { return $_SESSION['nick']; }

function setNick($nick) {
	$_SESSION['nick'] = $nick;
	return $_SESSION['nick'];
}

function getMessages($channel, $lastmsg=null) {
	$r = mysql_query("select userid, time, msg, (select max(msgid) from msg) as lastmsg from msg where 1=1 and
		chanid='$channel'".(($lastmsg==null)?' and msgid>(select max(msgid)-20 from msg) ':" and msgid>$lastmsg").
		" order by time asc");
	$ret = array();
	$ret['length'] = 0;
	while ( $msg = mysql_fetch_assoc($r) ) {
		$ret[$ret['length']] = $msg;
		$ret['length']++;
	}
	return $ret;
}

function postMessage($channel, $msg) {
	if ( $msg == "" ) return;
	$r = mysql_query("insert into msg (userid,chanid,msg) ".
		"values ('$_SESSION[nick]','$channel','$msg');");
}

?>
