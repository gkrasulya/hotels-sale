<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";

// ��������, ��� ���������
$place = "������!";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>LinkExchanger Full 2.0 Admin Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
<?php
$backward = "$_GET[backward]"."#"."$_GET[id]";
echo "<table cellspacing=4 cellpadding=0 width=800>
      <tr><td colspan=2 valign=top align=left>";
// ���������� ����
include "menu.php";
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>
      <tr><td colspan=2 valign=top align=left>";
	  

echo "<table cellspacing=0 cellpadding=0 width=940>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td align=center class=title bgcolor=#8f95ac><font face=Verdana size=4 color=red><b>������!</b></font><HR>"."$_SESSION[error]"."<br><br><a href="."$backward".">���������</a><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td align=left bgcolor=#8f95ac>
<b>300 Multiple Choices (��������� ��������� �� �����)</b> - ������������� URL ���������� ����� ������ �������. ��������, URL ����� ���������� ��������, ������������ �� ��������� ������. � ���� �����������, ������������ ��������, ����� ���������� �������� ����� ���������� ������ � ���, ��� ������� ������ ���������. 
<br>
<b>301 Moved Permanently (������ ��������� �� ���������� ������)</b> - ������������� URL ��� �� ������������ ��������, � ��������� � ������� �������� �� ���������. ����� ��������������� �������������� ��������� ����������� � ��������� Location. �� ���� ����������� �������� ������� ��������� ������� ��������� ����� URL. 
<br>
<b>302 Moved Temporarily (������ �������� ���������)</b> - ������������� URL ���������, �� ���� ��������. ��������� Location ��������� �� ����� ���������������. ����� �� ����� ��������� ����� ���� ��������� ������ ������ ��������� ������ ��� ������ ������ URL, �� �� ���� ����������� �������� ���������� ������������ ������ URL. 
<br>
<b>303 See Other (�������� ������ ������)</b> - ������������� URL ����� ����� �� ������� URL (���������� � ��������� Location). ��� ������� ������� ������� GET �� ������� �������. ���� ����� ���������� ������ ����� ��� ����, ����� ����������� ����� ������ ����������������� ������� POST ��������, ��������� ��������������� ������ ������������ �� ��������� ������. ����� URI - ��� �� ������, ���������� ������������� ����������� ������. ����� � ����� ��������� 303 �� ��������, �� ����� �� ������ (���������������) ������ ����� ���� ���������. ���� ����� URI - ��� ������������, �� ������ ������� ��������� URL � ���� Location. ���� ����� ������� ��� �� HEAD, �� ������� ������ ������� ��������� �������� �������������� ���������� � ������������ �� ����� (��� �����) URI. 
<br>
<b>304 Not Modified (�� ���������)</b> - ��� ��� ������ �� ��������� lf-Modified-Since, ���� URL �� ��������� � ��������� ����. ���� ����������� �� ����������, � ������ ������ ������������ ���� ��������� �����. 
<br>
<b>305 Use Proxy (����������� ������-������)</b> - o�������� � ������������ ������� ������ ������������� ����� ������-������, ��������� � ���� Location. � ���� Location ������ URL ������-�������. ���������, ��� ���������� �������� ������ ����� ������-������. 
<br>
<b>400 - Bad Request (������������ ������)</b> - ������ �� ����� ���� ����� �������� ��-�� malformed ����������. ������� �� ������� ��������� ������ ��� �����������.  
<br>
<b>401 Unauthorized (��� ����������)</b> - ������ ������� ������������ ����������� ������������. ����� ������ �������� ���� ��������� WWW-Authenticate, ���������� ����� (challenge), ���������� � ������������ �������. ������ ����� ��������� ������ � ���������� ����� ��������� Authorization. ���� ������ ��� �������� ������������ ������������ ����������� (Authorization credentials) � ���� Authorization, �� ����� � ����� ��������� 401 ���������, ��� � ������������ ����������� ���� ������������� ��������. ���� ����� � ����� ��������� 401 �������� ��� �� ����� �����, ��� � �������������� �����, � ����� ������������ ��� ����� ������� ������������ ����������� �� ������� ���� ���� ���, �� ������� �������� ������������ ������, ������� ��� ��� � ������, ��� ��� ���� ������ ����� �������� relevant ��������������� ����������. 
<br>
<b>402 Payment Required (��������� ������)</b> - ���� ��� �������������� ��� �������� �������������. � ������ ������ � HTTP ��� �� ����������.  
<br>
<b>403 Forbidden (������ ��������)</b> - ������ �������� �� ��� �������, ��� ������ �� ����� (��� �� ����� �����������) �������� �������.  
<br>
<b>404 Not Found (������ �� ������)</b> - �������� �� ���������� URL �� ����������, ������ �� ����� ������, ���������������� ������� �������������� URI (Request-URI). ����� �� ���������� �������� �� ����� ��������� ��������� ��� ����������. ���� ������ �� ������ ������ ������ ���������� ��������� �������, �� ������ ����� ���� ��������� ����� �������������� ��� ��������� 403 (���������, Forbidden). ��� ��������� 410 (������, Gone) ������� ������������, ���� ������ ����� ����� ��������� ��������� ��������������� ��������, ��� ������ ������ ����� ����������, �� �� ����� ������ ������ ��� ���������.  
<br>
<b>405 Method Not Allowed (������������ �����)</b> - ���� ��� �������� � ���������� Allow � ����������, ��� �����, ������������ ��������, ��� ������� URL �� ��������������.  
<br>
<b>406 Not Acceptable (������������ ������)</b> - ������, ���������������� ��������, ����� ����������� ��������� ������ ����� �������� ������, ������� ����� �������������� ����������� (content characteristics), �� ������������� � ����������� ������ (accept headers), ��������������� � �������.  
<br>
<b>407 Proxy Authentication Required (���������� ����������� �� �������-�������������)</b> - ���� ��� ������� ���� 401 (������������������, Unauthorized), �� ���������, ��� ������ ������ ������� ���������� ���� ����������� (authenticate) ������-�������. ������-������ ������ ���������� ���� ��������� Proxy-Authenticate, ���������� ����� (challenge), ����������� ������-�������� ��� ������������ �������. ������ ����� ��������� ������ � ���������� ����� ��������� Proxy-Authorization.  
<br>
<b>408 Request Timeout (����� ��������� ������� �������)</b> - ������ �� �������� ������ � ������� �������, ������� ������ ����� �����. ������ ����� ��������� ������ ��� ����������� �����.  
<br>
<b>409 Conflict (��������)</b> - ������ �� ��� �������� ��-�� ��������� � ������� ���������� �������. ���� ��� ����������� ������ � ���������, ����� ���������, ��� ������������ ����� ������ �������� � �������� �������� ������. ���� ������ ������� ��������� ����������� ���������� ���������� ��� ������������, ����� �� ��� ���������� �������� ���������. � ������, ������ ������ ������ �������� ���������� ���������� ��� ������������ ��� ������ ������������ ��� ������� ��������; ������ ��� ����� �� ���� ��������, �� � �� ���������. ���������, �������� ��������, ����� ��������� � ����� �� ������ PUT. ���� ������������ ������������, � ������, ������� ������ ���� �������, �������� ��������� �������, ������� ��������� � ������������ �� ���������� ������ �����-���� �������� (������� �������), ������ ����� ������������ ����� � ����� ��������� 409, ����� ��������, ��� �� �� ����� ��������� ������. � ���� ������, ������� ������ ������� ��������� ������ ������� ���� ������ � �������, ������������ ����� ��������� ������ Content-Type.  
<br>
<b>410 Gone (������� ������ ���)</b> - ������ ��� ����������, ��� ������������� URL ������ �� ���������� � �������� ������ � �������.  
<br>
<b>411 Length Required (���������� ������� �����)</b> - ������ ������������ ��������� ������ � �������������� Content-Length. ������ ����� ��������� ������, ���� ������� ���������� ���� ��������� Content-Length, ���������� ����� ���� ��������� (message-body) � ��������� �������.  
<br>
<b>412 Precondition Failed (�� ��������� ��������������� �������)</b> - ������ ������������ ������������ ������, ������ ��� ������ ������� ������, ��� ������ ������ ��� �������� ����������. ������ ����� ������� ����������, ����� �� ���� ������� ����������� ���������� ������. ���� ��� ��������� ���������, �� ������� ������� �������� ���� ��������� Retry-After ��� �������� �������, ����� ������� ������ ����� ����� ��������� ������.  
<br>
<b>413 Request Entity Too Large (������������� ������� ������� �����)</b> - ������ �� ����� ������������ ������, ������ ��� ��� ���� ������� ������.  
<br>
<b>414 Request-URI Too Long (������������� ������� � ������� ������� �������)</b> - ������ �� ����� ������������ ������, ������ ��� ��� URL ������� �������.  
<br>
<b>415 Unsupported Media Type (���������������� ��� ����������)</b> - ������ ������������ ����������� ������, ������ ��� ������ ������� ��������� � �������, �� �������������� ����������� �������� ��� ������������ ������.  
<br>
<b>500 Internal Server Error (���������� ������ �������)</b> - ��� ��������� ������� �� ������� ���� �� ��� ����������� (��������, CGI-���������) ����� ��������� ����� ��� ���������� � ������� ������������. 
<br>
<b>501 Not Implemented (������� �� �����������)</b> - ������ �������� ���������� ��������, ������� ������ ��������� �� �����, ������ �� ������������ �������������� �����������, ��������� ��� ���������� �������. ���� ����� ������������� ���������, ����� ������ �� ���������� ����� ������� � �� �������� ����������� ��� ��� ������ �������.  
<br>
<b>502 Bad Gateway (������ �����)</b> - ������, �������� � �������� ����� ��� ������-�������, ������� ������������ ����� �� ���������� ������� � ������� ��������, � �������� ��������� ��� ������� ��������� ������.  
<br>
<b>503 Service Unavailable (������ ����������)</b> - ������ ��� ��������, ��� ������ ������ �������� ����������, �� � ������� ������ � ��� ����� ������������. ���� ������ �����, ����� ��� ����������, ����� ���� ����� ����� ��������� Retry-After.  
<br>
<b>504 Gateway Timeout (����� ����������� ����� ���� �������)</b> - ���� ����� ����� �� 408 (Request Time-out) , �� ����������� ����, ��� ���� ��� �������������� ������ �������� ����� �������.  
<br>
<b>505 HTTP Version Not Supported (���������������� ������ HTTP)</b> - ������ �� ������������ ������ ��������� HTTP, �������������� � �������.	  
	  </a></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr><tr><td valign=top align=left colspan=2></td></tr></table>";

unset($_SESSION['error']);
@ignore_user_abort($old_abort);
?>
</body>
</html>