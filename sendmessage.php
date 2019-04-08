<?php
// CSV function
function writeInCsv($filePath, $val, $delimiter = ';', $endOfRow = "\n") {

   if (file_exists($filePath)) {
      $file = fopen($filePath, "a+");
   } else {
      $file = fopen($filePath, "a+");
      fseek($file, 0);
      fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
   }

   if (is_array($val)) {
      foreach ($val as $key => $row) {
         $rowLength = count($row);
         for ($i = 0; $i < $rowLength; $i++) {
            if ($i+1 == $rowLength) {
               fwrite($file, $row[$i].$endOfRow);
            } else {
               fwrite($file, $row[$i].$delimiter);
            }
         }
      }
   }elseif (is_string($val)) {
      fwrite($file, $val);
   }

}

// переменные, полученные из форм на сайте
if(isset($_POST["tel"])){
   $phone = $_POST["tel"];
}else{
   $phone = '-';
};

if(isset($_POST["name"])){
   $name = $_POST["name"];
}else{
   $name = '-';
};
if(isset($_POST["size"])){
   $size = $_POST["size"];
}else{
   $size = '-';
};

if(isset($_POST["dop"])){
   $dop = $_POST["dop"];
}else{
   $dop = '-';
};
if(isset($_POST["comment"])){
   $comment = $_POST["comment"];
}else{
   $comment = '-';
};

if(isset($_POST["photo"])){
   $photo = $_POST["photo"];
}else{
   $photo = '-';
};

require_once("php/class.phpmailer.php");
$mail = new PHPMailer();
$mail->CharSet = 'utf-8';

$email_body = "
<p>Телефон:</p><h2>".$phone."</h2>
<p>Имя:</p><h2>".$name."</h2>
<p>Доп. информация:</p><h2>".$dop."</h2>
<p>Размер выбранной модели:</p><h2>".$size."</h2>;


$mail->From = 'mux41@yandex.ru';
$mail->FromName = 'Лендинг sweater.ru';

//$mail->AddAddress('analytics@mediabc.ru', 'ANALYTICS');
//$mail->AddAddress('mux41@yandex.ru', 'SMART-BALANCER.RU');
$mail->AddAddress('a.eismond@gmail.com', 'sweater.ru');
//$mail->AddAddress('kevas777@mail.ru', 'SMART-BALANCER.RU');

$mail->Subject = 'Новая заявка с лендинга sweater.ru';
$mail->MsgHTML($email_body);

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
} else {
   $datenow = date('Y-m-d');
   $timenow = date('H:i:s');
   $inputspace2 = $datenow.";".$timenow.";".$name.";".$phone.";".$dop.";".$photo.";".$size.";".$comment."\n";
   writeInCsv('leads.csv', $inputspace2, $delimiter = ';', $endOfRow = "\n");
}
header('Refresh: 3; URL=index.html');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="3; url=index.html">
<title>С вами свяжутся</title>
<meta name="generator">
<link src='css/style.css'>
<style type="text/css">
body
{
   background:      rgba(236, 163, 147,.9);;
}
</style>
<script type="text/javascript">
setTimeout('location.replace("index.html")', 3000);
/*Изменить текущий адрес страницы через 3 секунды (3000 миллисекунд)*/
</script> 
</head>
<body>
<p class='bebas' style='font-family: sans-serif; font-weight: bold;color: black; font-size: 45px; text-transform: uppercase; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center;'>
    Ваш заказ принят. Скоро вам станет тепло.
</p>
</body>
</html>