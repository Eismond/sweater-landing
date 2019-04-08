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

if(isset($_POST["dop"])){
   $dop = $_POST["dop"];
}else{
   $dop = '-';
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
<p>Фото выбранной модели:</p><h2>".$photo."</h2>";


$mail->From = 'order@mediabc.ru';
$mail->FromName = 'Лендинг SMART-BALANCER.RU!';

//$mail->AddAddress('analytics@mediabc.ru', 'ANALYTICS');
//$mail->AddAddress('mux41@yandex.ru', 'SMART-BALANCER.RU');
$mail->AddAddress('client@smart-balancer.ru', 'SMART-BALANCER.RU');
//$mail->AddAddress('kevas777@mail.ru', 'SMART-BALANCER.RU');

$mail->Subject = 'Новая заявка с лендинга SMART-BALANCER.RU';
$mail->MsgHTML($email_body);

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
} else {
   echo '1';
   $datenow = date('Y-m-d');
   $timenow = date('H:i:s');
   $inputspace2 = $datenow.";".$timenow.";".$name.";".$phone.";".$dop.";".$photo."\n";
   writeInCsv('leads.csv', $inputspace2, $delimiter = ';', $endOfRow = "\n");
}