<?php
    session_start();
    $mode = 'input';
    $errmessage = array();
    if(isset($_POST['back']) && $_POST['back']){

    } else if(isset($_POST['confirm']) && $_POST['confirm']){
        if(!$_POST['name']){
            $errmessage[] = "名前を入力してください";
        } else if (mb_strlen($_POST['name']) > 30){
            $errmessage[] = "※名前は30文字以内で入力してください";
        }
        $_SESSION['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
        
        if(!$_POST['email']){
            $errmessage[] = "メールアドレスを入力してください";
        } else if (mb_strlen($_POST['email']) > 50){
            $errmessage[] = "※メールアドレスは50文字以内で入力してください";
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errmessage[] = "正しいメールアドレスを入力してください";   
        }
        $_SESSION['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES);

        if(!$_POST['phonenumber']){
            $errmessage[] = "電話番号を入力してください";
        } else if (mb_strlen($_POST['phonenumber']) > 11){
            $errmessage[] = "※電話番号は11文字以内で入力してください";
        } else if (!preg_match('/^[0-9]+$/i', $_POST['phonenumber'])){
            $errmessage[] = "不正な電話番号です";   
        }
        $_SESSION['phonenumber'] = htmlspecialchars($_POST['phonenumber'], ENT_QUOTES);

        if(!$_POST['message']){
            $errmessage[] = "お問い合わせ内容を入力してください";
        } else if (mb_strlen($_POST['message']) > 500){
            $errmessage[] = "※お問い合わせ内容は500文字以内で入力してください";
        } 
        $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
        
        if($errmessage){
            $mode = 'input';
        } else {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            $mode = 'confirm';
        }
    } else if (isset($_POST['send']) && $_POST['send']){
        if(!$_POST['token'] || !$_SESSION['token'] || !$_SESSION['email']){
            $errmessage[] = '不正な処理が行われました';
            $_SESSION = array();
            $mode = 'input';  
        } else if($_POST['token'] != $_SESSION['token']){
            $errmessage[] = '不正な処理が行われました';
            $_SESSION = array();
            $mode = 'input';
        } else {
            $message = "お問い合わせありがとうございます。\r\n"
		 . "下記の通り受け付けました。\r\n"
		 . " \r\n"
                 . "【お名前】 " . $_SESSION['name'] . "\r\n"
                 . "【歯科医院名】" . $_SESSION['clinic_name'] . "\r\n"
                 . "【メールアドレス】 " . $_SESSION['email'] . "\r\n"
                 . "【電話番号】 " . $_SESSION['phonenumber'] . "\r\n"
                 . "【お問い合わせ内容】 \r\n"
                 . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']) . "\r\n"
		 . " \r\n"
		 . "株式会社Brains \r\n"
                 . "TEL: 0545-32-8272 \r\n"
                 . "email: brains1171@gmail.com \r\n"
                 . "URL: https://www. \r\n";
	    $message2 = "ホームページよりお問い合わせを下記の通り受け付けました。\r\n"
                 . " \r\n"
                 . "【お名前】 " . $_SESSION['name'] . "\r\n"
                 . "【歯科医院名】" . $_SESSION['clinic_name'] . "\r\n"
                 . "【メールアドレス】 " . $_SESSION['email'] . "\r\n"
                 . "【電話番号】 " . $_SESSION['phonenumber'] . "\r\n"
                 . "【お問い合わせ内容】 \r\n"
                 . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
            $headers = 'From: brains1171@gmail.com' . "\r\n";
            mail($_SESSION['email'], '【High Five Works】お問い合わせありがとうございます。', $message, $headers);
            mail('mai_m1988@yahoo.co.jp', 'ホームページよりお問い合わせがありました。', $message2, $headers);
        $_SESSION = array();
        $mode ='send';
        }
    } else {
        $_SESSION['name'] = "";
        $_SESSION['clinic_name'] = "";
        $_SESSION['email'] = "";
        $_SESSION['phonenumber'] = "";
        $_SESSION['message'] = "";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="../css/contact-responsive.css">

    <script src="https://kit.fontawesome.com/b0f34d3d4a.js" crossorigin="anonymous"></script>
    <!-- ↓ADOBE FONT↓ -->
    <script>
        (function(d) {
          var config = {
            kitId: 'rxd4xcw',
            scriptTimeout: 3000,
            async: true
          },
          h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);
    </script>

    <title>Document</title>
</head>

<body>
    <header>
        <div id="header_container">
            <div id="logo"><a href="../html/index.html"><img src="../photos&videos/top/brains logo.png" alt="BrainsLogo"></a></div>
            <nav>
                <ul>
                    <li><a href="../html/about.html" class="link_hover nl_box">私たちについて</a></li>
                    <li id="wu_nl">
                        <div class="nl_box nav_dot">
                            <p class="link_hover">特徴</p>
                        </div>
                        <div class="nav_dropdown wu_nd">
                            <ul>
                                <li><a href="../html/cadcam.html" class="dd_hover">CADCAM</a></li>
                                <li><a href="../html/printer.html" class="dd_hover">3D<span class="mrg_left">Printer</span></a></li>
                                <li><a href="../html/ios.html" class="dd_hover">IOS</a></li>
                                <li><a href="../html/shadetaking.html" class=
                                    "dd_hover">Shade<span class="mrg_left">Taking</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li id="ini_nl">
                        <div class="nl_box nav_dot">
                            <p class="link_hover">取り組み</p>
                        </div>
                        <div class="nav_dropdown ini_nd">
                            <ul>
                                <li><a href="../html/workexperience.html" class="dd_hover"><p>職場体験</p></a></li>
                                <li class="nv_lecture">職業講話</li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="../html/partnerships.html" class="link_hover nl_box">提携ラボ募集</a></li>
                    <li><a href="../html/recruit.html" class="link_hover nl_box">採用情報</a></li>
                    <li><a href="../contact.php" class="link_hover nl_box">お問い合わせ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="hamburger_menu">
        <input type="checkbox" id="menu_btn_check">
        <label for="menu_btn_check" id="menu_btn"><span></span></label>
        <div id="menu_content">
            <div id="menu_content_container">
                <ul>
                    <li class="hamburger_links"><a href="../html/about.html" class="link_hover">私たちについて</a></li>
                    <li class="hamburger_links">
                        <div>
                            <p>特徴</p>
                            <ul class="hamburger_wulinks">
                                <li><a href="../html/cadcam.html" class=" btn_dot dd_hover link_hover">CADCAM</a></li>
                                <li><a href="../html/printer.html" class="btn_dot dd_hover link_hover">3D<span class="mrg_left">Printer</span></a></li>
                                <li><a href="../html/ios.html" class="btn_dot dd_hover link_hover">IOS</a></li>
                                <li><a href="../html/shadetaking.html" class="btn_dot dd_hover link_hover">Shade<span class="mrg_left">Taking</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="hamburger_links">
                        <div>
                            <p>取り組み</p>
                            <ul class="hamburger_wulinks">
                                <li><a href="../html/workexperience.html" class="btn_dot dd_hover link_hover">職場体験</a></li>
                                <li class="nv_lecture">職業講話</li>
                            </ul>
                        </div>
                    </li>
                    <li class="hamburger_links"><a href="../html/partnerships.html" class="link_hover">提携ラボ募集</a></li>
                    <li class="hamburger_links"><a href="../html/recruit.html" class="link_hover">採用情報</a></li>
                    <li class="hamburger_links"><a href="../contact.php" class="link_hover">お問い合わせ</a></li>
                </ul>
                <div class="hamburger_sns sns_icons"">
                    <ul>
                        <li><a href="https://www.youtube.com/@kounosuke" target=”_blank”><i class="fa-brands fa-youtube fa-xl yt_icon"></i></a></li>
                        <li><a href="https://www.instagram.com/brains1171" target=”_blank”><i class="fa-brands fa-instagram fa-xl insta_icon"></i></a></li>
                        <li><a href="https://www.facebook.com/profile.php?id=100069862238175" target=”_blank”><i class="fa-brands fa-square-facebook fa-xl fb_icon"></i></a></li>
                    </ul>
                    <p>&copy; 2022 Brains Co., Ltd.</p>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="container">

        <?php if($mode == 'input'){ ?>
                <?php
                    if($errmessage){
                        echo '<div style="color:red;">';
                        echo implode('<br>', $errmessage);
                        echo '</div>';
                    }
                ?>
            <div class="contact_title">
                <h1 class="jpns_title">お問い合わせ</h1>
                <h2 class="eng_title">Contact</h2>
            </div>
            <div class="contact_main">
                <div class="sticky_box">
                    <div class="contact_texts">
                        <p>各種ご相談、ご連絡、ご質問につきましては、お問い合わせフォームもしくはお電話にてお気軽にお問い合わせ下さい。なお、以下指示書等のご送付をご希望の方は、お手数をお掛け致しますが、下記のメールアドレスまで直接メールにてお送り下さい。<br>email : brains1171@gmail.com</p>
                        <div class="download_files">
                            <ul>
                                <li><a href="../download/brains direction.xlsx" download="指示書" class="link_hover">指示書をダウンロード</a></li>
                                <li><a href="../download/dentalfont.zip" download="歯式フォント" class="link_hover">歯式フォントをダウンロード（説明書付）</a></li>
                            </ul>
                        </div>
                        <p>指示書の中に「部位」という欄がございますので、手打ちでご入力いただくか、下より歯式フォントをダウンロードしていただき、歯式を入力して下さい。<br>※ 入力されたExcelは、削除せずお手元の端末に保管ください。</p>
                    </div>
                </div>
                <form action="contactform" method="post">
                    <ul>
                        <li>
                            <p>歯科医院名</p>
                            <input class="input_section" type="text" name="name" value="<?php echo $_SESSION['clinic_name'] ?>">
                        </li>
                        <li>
                            <p>名前 <span>※</span></p>
                            <input class="input_section" type="text" name="name"  required="required" value="<?php echo $_SESSION['name'] ?>">
                        </li>
                        <li>
                            <p>メールアドレス <span>※</span></p>
                            <input class="input_section" type="email" name="email" required="required" value="<?php echo $_SESSION['email'] ?>">
                        </li>
                        <li>
                            <p>電話番号（ハイフンなし） <span>※</span></p>
                            <input class="input_section" type="text" name="phonenumber" required="required" value="<?php echo $_SESSION['phonenumber'] ?>">
                        </li>
                        <li>
                            <p>お問い合わせ内容（500文字以内） <span>※</span></p>
                            <textarea class="input_section"
                            name="message" required="required"
                            cols="30"
                            rows="10"
                            ><?php echo $_SESSION['message'] ?></textarea>
                        </li>
                        <li>
                            <p class="contact_note">※ご記入いただいた個人情報は、お問い合わせの回答や情報提供のためにのみ使用いたします。</p>
                        </li>
                        <li class="contactbtn_box">
                            <input class="submit_btn link_hover" type="submit" name="confirm" value="送信内容を確認する">
                        </li>
                    </ul>
                </form>
            </div>

            <!----------      reconfitm page      ---------->
        <?php } else  if( $mode == 'confirm' ){ ?>
            <div class="contact_title">
                <h1 class="jpns_title">送信内容確認</h1>
                <h2 class="eng_title">Contact</h2>
            </div>
            <div class="contact_main">
                <div class="sticky_box">
                    <div class="contact_texts">
                        <p>各種ご相談、ご連絡、ご質問につきましては、お問い合わせフォームもしくはお電話にてお気軽にお問い合わせ下さい。なお、以下指示書のご送付をご希望の方は、お手数をお掛け致しますが、下記のメールアドレスまで直接メールにてお送り下さい。<br>email : brains1171@gmail.com</p>
                        <div class="download_files">
                            <ul>
                                <li><a href="../download/brains direction.xlsx" download="指示書" class="link_hover">指示書をダウンロード</a></li>
                                <li><a href="../download/dentalfont.zip" download="歯式フォント" class="link_hover">歯式フォントをダウンロード（説明書付）</a></li>
                            </ul>
                        </div>
                        <p>指示書の中に「部位」という欄がございますので、手打ちでご入力いただくか、下より歯式フォントをダウンロードしていただき、歯式を入力して下さい。<br>※ 入力されたExcelは、削除せずお手元の端末に保管ください。</p>
                    </div>
                </div>
                <form action="contactform" method="post">
                    <ul>
                        <li>
                            <div type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        </li>
                        <li>
                            <p>歯科医院名</p>
                            <div class="input_section no_border"><?php echo $_SESSION['clinic_name'] ?></div>
                        </li>
                        <li>
                            <p>名前 <span>※<span></p>
                            <div class="input_section no_border"><?php echo $_SESSION['name'] ?></div>
                        </li>
                        <li>
                            <p>メールアドレス <span>※<span></p>
                            <div class="input_section no_border"><?php echo $_SESSION['email'] ?></div>
                        </li>
                        <li>
                            <p>電話番号（ハイフンなし） <span>※<span></p>
                            <div class="input_section no_border"><?php echo $_SESSION['phonenumber'] ?></div>
                        </li>
                        <li>
                            <p>お問い合わせ内容（500文字以内） <span>※<span></p>
                            <div class="input_section no_border"><?php echo $_SESSION['message'] ?></div>
                        </li>
                        <li>
                            <p class="contact_note">※ ご記入いただいた個人情報は、お問い合わせの回答や情報提供のためにのみ使用いたします。</p>
                        </li>
                        <li  class="contactbtn_box">
                            <input class="submit_btn margin_right link_hover" type="submit" name="back" value="訂正する" />
                            <input class="submit_btn margin_left link_hover" type="submit" name="send" value="送信する" />
                        </li>
                    </ul>
                </form>
            </div>

        <!----------      sent page      ---------->
        <?php } else { ?>
            <div class="contact_title sent_title">
                <h1 class="jpns_title">送信完了</h1>
                <h2 class="eng_title">Sent</h2>
            </div>
            <div id="sent_texts">
                <p>お問い合わせありがとうございます。<br id="sent_br1">お問い合わせ内容を確認次第、ご連絡いたします。<br>数日経っても返信がない場合は、<br id="sent_br2">大変恐れ入りますが<br id="sent_br3">再度ご連絡いただけると幸いです。</p>
                <div class="btn to_top">
                    <a href="../html/index.html" class="link_hover btn_dot">Back to Top</a>
                </div>
            </div>
        <?php } ?>

        </div>
    </main>

     <footer>
        <div class="container footer_container">
            <div id="footer_info">
                <ul>
                    <li id="brains"><p>株式会社Brains</p></li>
                    <li><p>静岡県富士市大渕2861-20 2F</p></li>
                    <li><p>TEL / FAX : 0545-32-8272</p></li>
                    <li><p>brains1171@gmail.com</p></li>
                </ul>
            </div>
            <div class="sns_icons">
                <ul>
                    <li><a href="https://www.youtube.com/@kounosuke" target=”_blank”><i class="fa-brands fa-youtube fa-xl yt_icon"></i></a></li>
                    <li><a href="https://www.instagram.com/brains1171" target=”_blank”><i class="fa-brands fa-instagram fa-xl insta_icon"></i></a></li>
                    <li><a href="https://www.facebook.com/profile.php?id=100069862238175" target=”_blank”><i class="fa-brands fa-square-facebook fa-xl fb_icon"></i></a></li>
                </ul>
                <p>&copy; 2022 Brains Co., Ltd.</p>
            </div>
        </div>
    </footer>

    <script>
        const　body = document.body;
        const menuBtn = document.getElementById('menu_btn_check');
        menuBtn.addEventListener('click', function() {
            body.classList.toggle('scroll_off');
        });
    </script>
    
</body>
</html>