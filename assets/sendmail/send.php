<?php
//-------------------------------------------------------------------------------------------------------/
//Enter your email address(es), and your domain name to receive applications from the site.
//If you need to specify several email addresses, list them separated by the "|" symbol, without spaces.
//For example: $my_emails="myadres_1@gmail.com|myadres_2@gmail.com";

$my_emails = "info@mirasov.dev";
$domain = "Nectar";

//-------------------------------------------------------------------------------------------------------/

require 'class.phpmailer.php';

$maillist = explode('|', $my_emails);
$td1_style = "border:1px solid #767676; padding:14px 20px; font-weight:bold; background-color:#eee;";
$td2_style = "border:1px solid #767676; padding:14px 20px;";
$td3_style = "border:1px solid #767676; padding:14px 20px;background-color:#767676;color:#fff;font-weight:bold;text-align:center;";
$msg_top = "
<html>
	<body>
		<table style=\"border-collapse:collapse;\">";

$msg_content = "";
foreach ($_POST as $key => $value) {
	if ($key == "subject") {
		$msg_content .= "
			<tr>
				<td colspan=\"2\" style=\"$td3_style\">" . $value . "</td>
			</tr>";
	} else if ($key == "google_target" || $key == "yandex_code" || $key == "yandex_target" || $key == "my_emails") {
		$msg_content .= "";
	} else {
		$msg_content .= "
			<tr>
				<td style=\"$td1_style\">" . $key . "</td>
				<td style=\"$td2_style\">" . $value . "</td>
			</tr>";
	}
}
$msg_bottom = "
		</table>
	</body>
</html>";
if ($msg_content != "") {
	$subject = $_POST['subject'];
	$messege = $msg_top . $msg_content . $msg_bottom;
	$mail = new PHPMailer();
	$mail->From = "example@example.com";
	$mail->FromName = $domain;
	foreach ($maillist as $mail_send) {
		$mail->AddAddress($mail_send);
	}
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	if (isset($_FILES['file'])) {
		$tmp_attachment = array_combine($_FILES['file']['tmp_name'], $_FILES['file']['name']);
		foreach ($tmp_attachment as $k => $v) {
			$mail->AddAttachment($k, $v);
		}
	}
	$mail->Body = $messege;
	if ($mail->Send()) {
		echo json_encode($_POST["name"]);
	}
}
