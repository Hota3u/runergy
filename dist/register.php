<?php
	require_once("program/data/db_creds.php");
	require_once("program/Erza-min.php");

	$response = array(
					"code" => 0,
					"msg" => "EMPTY REQUEST!",
					"ip" => $_SERVER["REMOTE_ADDR"],
					"port" => $_SERVER["REMOTE_PORT"]
					);

	if(isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["email"]) && isset($_POST["datnar"]) && isset($_POST["bio"]) && isset($_POST["sex"]) && isset($_POST["kraj"]) && isset($_POST["news"])) {
		try {
			$mysql = new Erza(DB_SERVER, DB_NAME, DB_USER, DB_PASS, KLIC, $_SERVER["REMOTE_ADDR"]);
			$mysql->setSaltPass(SALT, KLIC);

			if($mysql->check_username($_POST["user"], KLIC)) {
				if($mysql->check_email($_POST["email"], KLIC)) {
					if($_POST["sex"] == 0 || $_POST["sex"] == 1) {
						if($_POST["kraj"] >= 0 && $_POST["kraj"] <= 13) {
							if($_POST["news"] == 0 || $_POST["news"] == 1) {
								if(strlen($_POST["bio"]) >= 12 && strlen($_POST["bio"]) <= 256) {
									$query = $mysql->prepare("SELECT * FROM `kartoteka` WHERE UPPER(`uzivatel`)=UPPER(:user)");
									$query->bindParam(":user", $_POST["user"]);
									$query->execute();
									$result = $query->fetch(PDO::FETCH_ASSOC);

									if(!$result) {
										$verifyCode = strtolower(Erza::RAND_STRING(14, true, false, $mysql->getIP(KLIC)));
										$hashVerCode = sha1($verifyCode);
										$hashPass = hash("sha256", $mysql->getSaltPass(KLIC) . $_POST["pass"]);

										$query = $mysql->prepare("INSERT INTO `kartoteka` (`uzivatel`, `heslo`, `email`, `bio`, `datum_nar`, `pohlavi_kod`, `kraj_index`, `novinky_kod`, `CREATE_DATIME`, `CREATE_IP`, `TOKEN`) VALUES (:user, :pwd, :mail, :bio, :dtnr, :sex, :region, :news, NOW(), :ip, :code)");
										$query->bindParam(":user", $_POST["user"]);
										$query->bindParam(":pwd", $hashPass);
										$query->bindParam(":mail", $_POST["email"]);
										$query->bindParam(":bio", $_POST["bio"]);
										$query->bindParam(":dtnr", $_POST["datnar"]);
										$query->bindParam(":sex", $_POST["sex"]);
										$query->bindParam(":region", $_POST["kraj"]);
										$query->bindParam(":news", $_POST["news"]);
										$query->bindParam(":ip", $mysql->getIP(KLIC));
										$query->bindParam(":code", $hashVerCode);
										$query->execute();


										$to = $_POST["email"];
										$subject = "NOVÁ REGISTRACE";
$txt = "Zdravíme " . $_POST["user"] . "!\n\nDěkujeme za Vaši registraci v naší aplikaci RUNADMIN.\nZde jsou tvé přihlašovací údaje:\nUživ. jméno: " . strtolower($_POST["user"]) . "\nHeslo: " . $mysql->censore_pass($_POST["pass"], KLIC) . "\n\nPro aktivaci musíte kliknout na odkaz níže:\nhttps://app.runergy.cz/verify.php?user=" . strtolower($_POST["user"]) . "&code=" . $verifyCode . "\n\n\nToto je automaticky vygenerovaný email. Neodpovídejte prosím na něj!";
										$headers = "From: noreply@runergy.cz";

										mail($to, $subject, $txt, $headers);

										$response = array(
											"code" => 1,
											"msg" => "Registration request has been successful",
											"ip" => $_SERVER["REMOTE_ADDR"],
											"port" => $_SERVER["REMOTE_PORT"]
										);
									}
								} else {
									$response = array(
										"code" => 26,
										"msg" => "Biography letter length is either shorter than 12 or longer than 256",
										"ip" => $_SERVER["REMOTE_ADDR"],
										"port" => $_SERVER["REMOTE_PORT"]
										);
								}
							} else {
								$response = array(
										"code" => 25,
										"msg" => "Newsletter checkbox value invalid",
										"ip" => $_SERVER["REMOTE_ADDR"],
										"port" => $_SERVER["REMOTE_PORT"]
										);
							}
						} else {
							$response = array(
										"code" => 24,
										"msg" => "Region invalid",
										"ip" => $_SERVER["REMOTE_ADDR"],
										"port" => $_SERVER["REMOTE_PORT"]
										);
						}
					} else {
						$response = array(
										"code" => 23,
										"msg" => "Gender invalid",
										"ip" => $_SERVER["REMOTE_ADDR"],
										"port" => $_SERVER["REMOTE_PORT"]
										);
					}
				} else {
					$response = array(
									"code" => 22,
									"msg" => "E-mail format error",
									"ip" => $_SERVER["REMOTE_ADDR"],
									"port" => $_SERVER["REMOTE_PORT"]
									);
				}
			} else {
				$response = array(
									"code" => 21,
									"msg" => "Username format error",
									"ip" => $_SERVER["REMOTE_ADDR"],
									"port" => $_SERVER["REMOTE_PORT"]
									);
			}
		} catch(PDOException $e) {
			$date = Erza::CURRENT_DATETIME('Europe/Prague');
			$datetext = $date->format('M jS Y :: h:i:s A');
			$file = fopen("logs/PDOErrors.log", "a") or die("Unable to open file!");
			fwrite($file, $datetext . " |\t" . $_SERVER["REMOTE_ADDR"] . " |\t" . $e->getTraceAsString());
			fclose($file);

			echo("<p class='excpinfo'>DOŠLO K VYHOZENÍ VÝJIMKY 'PDOException'<br>==============================<br><br>" . $e->getMessage());
		} catch(ErzaException $f) {
			$file = fopen("logs/ErzaErrors.log", "a") or die("Unable to open file!");
			fwrite($file, $f->getDate() . " |\t" . $f->getIP() . " |\t" . $f->getTraceAsString());
			fclose($file);

			echo("<p class='excpinfo'>DOŠLO K VYHOZENÍ VÝJIMKY 'ErzaException'<br>==============================<br><br>" . $f->getMessage());
		}
	}

	echo(json_encode($response));