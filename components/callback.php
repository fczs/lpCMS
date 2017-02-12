<?php

function punydecode($inp)
{
    $p = new Punycode();
    return $p->decode($inp);
}

function callback($fields = "default")
{
    if ($fields == "default")
        $fields = array("person" => "Имя", "phone" => "Телефон", "email" => "Почта", "message" => "Сообщение", "where" => "Из формы", "good" => "Товар");

    $msg = "";
    foreach ($fields as $key => $val) {
        if (isset($_POST[$key]) and (strlen($_POST[$key]) > 0))
            $msg .= $val . ": " . $_POST[$key] . "\n";
    }

    if (strlen($msg) > 0) {

        include("mime/htmlmimemail.php");
        include("punycode/punycode.php");


        if (g("track-user") == 1) {
            cms_session_start();
            if (isset($_SESSION['referer']) and (strlen($_SESSION['referer']) > 0))
                $msg .= "Переход на сайт со страницы: " . $_SESSION['referer'] . "\n";
            $msg .= "Сообщение отправлено с IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
        }
        $msg .= "Адрес сайта: " . punydecode($_SERVER['HTTP_HOST']) . "\n";
        $subj = g("mail-subject");
        if (isset($_REQUEST['force-subj']))
            $subj = $_REQUEST['force-subj'];

        if ($subj == "")
            $subj = "Request from ".get_host();
        $subj = str_replace(' ', ' ', $subj);

        $to = g("email");
        if ($to == "")
            $to = "a@a.ru";

        $arrto = preg_split("/,/", $to);

        $mail = new htmlMimeMail();
        $mail->setHeadCharset('utf-8');
        $mail->setTextCharset('utf-8');
        $mail->setFrom($arrto[0]);
        $mail->setText($msg);
        $mail->setSubject($subj);
        if($_FILES) {
            $attachment= $mail->getFile($_FILES['user_file']['tmp_name']);
            $mail->addAttachment($attachment, $_FILES['user_file']['name']);
        }
        $mail->send($arrto);

        return true;
    }
}

