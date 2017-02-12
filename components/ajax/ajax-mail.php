<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die("That's all folks"); //only ajax requests

require_once("../../functions.php");
require_once("../mime/htmlmimemail.php");

function sendMail($from, $text, $subj, $to)
{
    $mail = new htmlMimeMail();
    $mail->setHeadCharset('utf-8');
    $mail->setTextCharset('utf-8');
    $mail->setFrom($from);
    $mail->setText($text);
    $mail->setSubject($subj);
    $mail->send($to);
}

$fields = array(
    "email" => "E-mail",
    "message" => "Сообщение"
);

// Admin mail attributes
$subj = g("mail-subject");
if ($subj == "")
    $subj = "Request from " . get_host();
$subj = str_replace(' ', ' ', $subj);

$to = g("email");
$arrto = preg_split("/,/", $to);

$from = g("email-from");
if ($from == "")
    $from = $arrto[0];

// Building messages
$msg = "";

$action = $_POST["action"];

if($action == "message")
{
    if($_POST["email"])
        $msg .= $fields["email"] . ": " . $_POST["email"] . "\n";
    if($_POST["message"])
        $msg .= $fields["message"] . ": " . $_POST["message"] . "\n";
    
    $msg = str_replace("*", "\n", $msg);

    // send e-mail to admin
    sendMail($from, $msg, $subj, $arrto);

    echo 'Сообщение отправлено';
}
else
{
    die("-1");
}