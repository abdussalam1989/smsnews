<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db extends CI_Controller {	
	public function index()
	{
	
	error_reporting(-1);
	
	

$servername = "localhost";
//$username = "urmilacademy";
$username = "root";
//$password = "pass203012#";
$password = "";
$user = $username ;
$host = $servername;
$pass = $password;


//Create Db
$this->createDb($username,$password,'clicksch_forarumu');

//Create User
$this->createUser($username,$password,'','');

//Add user to DB - ALL Privileges
$this->addUserToDb($username,$password,'','clicksch_forarumu','&ALL=ALL');

//Add user to DB - SELECTED PRIVILEGES
$this->addUserToDb($username,$password,'','clicksch_forarumu','&CREATE=CREATE&ALTER=ALTER');


	}
	
	function createDb($cPanelUser,$cPanelPass,$dbName) {

    $buildRequest = "/frontend/paper_lantern/sql/addb.html?db=".$dbName;

    $openSocket = fsockopen('localhost',2082);
    if(!$openSocket) {
        return "Socket error";
        exit();
    }

    $authString = $cPanelUser . ":" . $cPanelPass;
    $authPass = base64_encode($authString);
    $buildHeaders  = "GET " . $buildRequest ."\r\n";
    $buildHeaders .= "HTTP/1.0\r\n";
    $buildHeaders .= "Host:localhost\r\n";
    $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
    $buildHeaders .= "\r\n";

    fputs($openSocket, $buildHeaders);
    while(!feof($openSocket)) {
        fgets($openSocket,128);
    }
    fclose($openSocket);
}


function createUser($cPanelUser,$cPanelPass,$userName,$userPass) {

    $buildRequest = "/frontend/paper_lantern/sql/adduser.html?user=".$userName."&pass=".$userPass;

    $openSocket = fsockopen('localhost',2082);
    if(!$openSocket) {
        return "Socket error";
        exit();
    }

    $authString = $cPanelUser . ":" . $cPanelPass;
    $authPass = base64_encode($authString);
    $buildHeaders  = "GET " . $buildRequest ."\r\n";
    $buildHeaders .= "HTTP/1.0\r\n";
    $buildHeaders .= "Host:localhost\r\n";
    $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
    $buildHeaders .= "\r\n";

    fputs($openSocket, $buildHeaders);
    while(!feof($openSocket)) {
        fgets($openSocket,128);
    }
    fclose($openSocket);
}

function addUserToDb($cPanelUser,$cPanelPass,$userName,$dbName,$privileges) {

    $buildRequest = "/frontend/paper_lantern/sql/addusertodb.html?user=".$userName."&db=".$dbName.$privileges;

    $openSocket = fsockopen('localhost',2082);
    if(!$openSocket) {
        return "Socket error";
        exit();
    }

    $authString = $cPanelUser . ":" . $cPanelPass;
    $authPass = base64_encode($authString);
    $buildHeaders  = "GET " . $buildRequest ."\r\n";
    $buildHeaders .= "HTTP/1.0\r\n";
    $buildHeaders .= "Host:localhost\r\n";
    $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
    $buildHeaders .= "\r\n";

    fputs($openSocket, $buildHeaders);
    while(!feof($openSocket)) {
        fgets($openSocket,128);
    }
    fclose($openSocket);
}



}
