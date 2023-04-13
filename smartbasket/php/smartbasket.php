<? 
// mb_internal_encoding("UTF-8");
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
require_once($_SERVER['DOCUMENT_ROOT'] . '/smartbasket/php/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['name']) ) {
			if(empty($_POST['name'])) {
				echo 'notName';
			} else {
				$name = "<b>Имя: </b>" . strip_tags($_POST['name']) ;
			}
		}
		if (isset($_POST['phone']) ) {
			if(empty($_POST['phone'])) {
				echo 'notTel';
			} else {
				$tel = "<b>Телефон: </b>" . strip_tags($_POST['phone']) ;
			}
		}

		if (isset($_POST['email']) ) {
			if(empty($_POST['email'])) {
				echo 'notEmail';
			} else {
				$email = "<b>Email: </b>" . strip_tags($_POST['email']) ;
			}
		}

        if (isset($_POST['agreement']) ) {
            echo 'agreement';
            if(empty($_POST['agreement'])) {
                echo 'agreement';
            } else {
                $agreement = "<b>Соглашение: </b>" . strip_tags($_POST['agreement']) ;
            }
        }

        if (isset($_POST['finalPrice']) ) {
            $finalPrice = "<b>Общая стоимость: </b>" . strip_tags($_POST['finalPrice']) ;
        }

		$tgProductArr="";

		$productArr=[];
		$counter = 0;
		$body;
		$bodyHeader = '<table border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px; border-right:1px; border-color:#e2e2e2; border-style: solid; width:800px" width="800" align="center">
			<tr >
				<th colspan="3" style="width: 400px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;">' . $name . $tel . $finalPrice .'</th>
				<th colspan="4" style="width: 400px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;">' . $email . $agreement .'</th>
			</tr>';

		foreach ($_POST as $key =>  $value) {
			$body.= '<tr>';
			if (is_array($value) || $value instanceof Traversable) {
				foreach ($value as $k => $v) {
					$vv=str_replace (array("\r\n", "\n", "\r"), ' ', $v);
					
					if($k == 'productImg'){
						$productImg = '<img src="' . $v . '" width="100" height="100" alt="картинка товара">';
						$body.=
							'
											<td style="width: 100px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;">
											'
												. $productImg .
											'
											</div></td>';
					}
					if($k == 'productName'){

						$tgProductArr .="$vv"; 
						$body.=
							'<td style="width: 300px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;">
											'
							. $v .
							'
											</div></td>';
					}
					if($k == 'productSize'){
						$tgProductArr .=", $vv"; 
						if(!empty($v)){
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;"> Размер: 
											'
								. $v .
								'
											</div></td>';
						} else {
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
									<div style="padding: 5px;"> Размер отстутствует </div>
								</td>';
						}
					}
					if($k == 'productId'){
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> ID: 
												'
							. $v .
							'
												</div></td>';
					}
					if($k == 'productPrice'){
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Цена: 
												'
							. $v .
							'
												</div></td>';
					}
					if($k == 'productQuantity'){
						$tgProductArr .=", кол-во: $vv, "; 
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Кол-во: 
												'
							. $v .
							'
												</div></td>';
					}

					if($k == 'productPriceCommon'){
						$tgProductArr .="общая цена: $vv%0A"; 
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Общая цена:
												'
							. $v .
							'
												</div></td>';
					}
					
					

				}

				$body.= '</tr>';
			}

		};
		$bodybottom = '</table>';
	}



//мое

	
	$token = "6165503432:AAGQu0K_wt4LeFKs5urQ3fWYjP5yK2nsx2w";
	$chat_id = "-1001871227674";

	
	$tgHeader = "$name%0A$tel%0A$finalPrice%0A$email" ;
	$txt = "$tgHeader%0A$tgProductArr"; 
	

	$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

	if ($sendToTelegram) {
	header('Location: success.html');
	} else {
	echo "error telegram $txt";
	}

//мое закончила




// 	if(defined('HOST') && HOST != '') {
// 		$mail = new PHPMailer;
// 		$mail->isSMTP();
// 		$mail->Host = HOST;
// 		$mail->SMTPAuth = true;
// 		$mail->Username = LOGIN;
// 		$mail->Password = PASS;
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port = PORT;
// 		$mail->AddReplyTo(SENDER);
// 	} else {
// 		$mail = new PHPMailer;
// 	}

// 		$mail->setFrom(SENDER);
//     $mail->addAddress(CATCHER);
//     if(defined(CATCHER2)){
//         $mail->addAddress(CATCHER2);
//     }
//     $mail->CharSet = CHARSET;
//     $mail->isHTML(true);
// 		$mail->Subject = SUBJECT; // Заголовок письма
// 		$mail->Body = "$bodyHeader $body $bodybottom";
// 		if(!$mail->send()) {
//             echo 'attantion';
//         } else {
//             // echo '<p class="smartlid__respond-success">' . SUCCESSMSGS . '</p>';
//             echo 'successmsgs';
//         }
} else {
	header ("Location: /");
}