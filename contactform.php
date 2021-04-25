<?php

if (isset($_POST['submit'])) {
 $name = $_POST["name"];
 $mailFrom = $_POST["mail"];
 $number = $_POST["number"];
 $file = $_POST["file"];

 $mailTo = "mai_m1988@yahoo.co.jp";
 $headers = "From: ".$mailFrom;
 $txt = "ホームページのコンタクトフォームから送信されました。送信者:　".$name."　電話番号： ".$number;

 mail($mailTo, $txt, $headers, $file);
 header("Location: index.php?mailsend");
}
