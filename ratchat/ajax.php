<?php
session_start();
require_once('ratchat.php');
header("Content-type: application/json");

$data = json_decode(file_get_contents("php://input"));
$params = $data->params;
$ret = new StdClass();
$ret->error = null;
$ret->id=$data->id;

switch ($data->method) {
	case 'post':
		if ( !isset($params->msg)||!isset($params->chanid) ) {
			$ret->error='Bad msg';
			break;
		}
		postMessage($params->chanid, $params->msg);
		$ret->result = "ACK";
		break;
	case 'get':
		$ret->result = getMessages($params->chanid, $params->lastmsg);
		break;
	case 'setNick':
		$ret->result = setNick($params->nick);
		break;
	case 'addRoom':
		if ( !isset($params->sysmsg)||!isset($params->newchannel) ) {
			$ret->error='Bad msg';
			break;
		}
		addRoom($params->newchannel, $params->sysmsg);
		$ret->result = "ACK";
		break;
	case 'getRooms':
		$ret->result = getRooms();
		break;

	case 'getNick':
		$ret->result = getNick();
		break;
	
	default:
	case 'time':
		$ret->result=time();
}
echo json_encode($ret);

session_commit();
?>
