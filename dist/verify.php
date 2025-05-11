<!DOCTYPE html><html lang='cs' dir='ltr'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><meta name='description' content='Interní aplikaci pro správu firmy Runergy s.r.o.'><meta name='keywords' content='runergy, runergy s.r.o., administrace, sprava, matiaska'><meta name='author' content='Filip Matiaska, filmat@post.cz'><meta name='robots' content='noindex, nofollow'><link rel='icon' type='image/png' href='nastaveni/favicon-96x96.png' sizes='96x96'><link rel='icon' type='image/svg+xml' href='nastaveni/favicon.svg'><link rel='shortcut icon' href='nastaveni/favicon.ico'><link rel='apple-touch-icon' sizes='180x180' href='nastaveni/apple-touch-icon.png'><meta name='apple-mobile-web-app-title' content='RUNERGY'><link rel='manifest' href='nastaveni/site.webmanifest'><link rel='stylesheet' href='styly/makeup.css'><link rel='stylesheet' href='styly/doplnky.css'><title>RUNADMIN | Administrace</title></head><body><header><h1>Žluťoučký kůň úpěl ďábelské ódy!</h1></header><main>
<?php
	require_once("program/data/db_creds.php");
	require("program/Erza-min.php");

	if(isset($_GET["user"]) && isset($_GET["code"])) {
		try {
			$mysql = new Erza(DB_SERVER, DB_NAME, DB_USER, DB_PASS, KLIC, $_SERVER["REMOTE_ADDR"]);
			$mysql->setSaltPass(SALT, KLIC);

			$query = $mysql->prepare("SELECT `ID`,`STATUS`,`TOKEN` FROM `kartoteka` WHERE UPPER(`uzivatel`)=UPPER(:user)");
			$query->bindParam(":user", $_GET["user"]);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_ASSOC);

			if($result) {
				if($result["STATUS"] == 0) {
					if(strcmp(sha1($_GET["code"]), $result["TOKEN"]) == 0) {
						$query = $mysql->prepare("UPDATE `kartoteka` SET `STATUS`=1 WHERE `ID`=:id");
						$query->bindParam(":id", $result["ID"]);
						$query->execute();

						echo("<p class='validlink'>Účet byl úspěšně aktivován!</p>");
					} else {
						echo("<p class='wronglink'>Neplatný verifikační link!</p>");
					}
				} else {
					echo("<p class='wronglink'>Neplatný verifikační link!</p>");
				}
			} else {
				echo("<p class='wronglink'>Neplatný verifikační link!</p>");
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
	} else {
		echo("<p class='wronglink'>Neplatný verifikační link!</p>");
	}
	?>
</main><footer><article><h4>Výpočet množství částic</h4><table><tr><th>Hmotnost:</th><td><input type='text' id='weightm'></td><td><select id='jednotky'><option value='0'>g</option><option value='1'>mg</option><option value='2'>&micro;g</option><option value='3'>ng</option></select></td></tr><tr><th>Molární hmotnost:</th><td><input type='text' id='molarw'></td><td><sup>g</sup>/<sub>mol</sub></td></tr><tr><th></th><td><button type='button' onclick='parts()'>Vypočítej</button></td><td></td></tr></table><p id='partsres'></p></article><aside><h3>Album obrázků</h3><select id='books' onchange='resetcount()'><option value='0'>Twisted Intent</option><option value='1'>Twisted Intent 2</option><option value='2'>NINA Greenhair</option><option value='3'>Han Song-Yi</option><option value='4'>Edel Frieren [artkoikoi]</option><option value='5'>Nino Nakano [artkoikoi]</option></select> <button type='button' onclick='albumback()' id='albumback'>PŘEDCHOZÍ</button> <button type='button' onclick='albumnext()' id='albumnext'>DALŠÍ</button> <img src='obrazky/intro/<?php echo("image_" . Erza::SUPER_RAND(0, 9, $_SERVER["REMOTE_ADDR"]) . ".png");?>' alt='FOTOALBUM' title='UVÍTACÍ OBRÁZEK!' id='animealb'></aside><p id='copyright'>Copyright &copy; 2025 Runergy s.r.o.<br>Všechna práva vyhrazena.</p></footer><span id='albcit'>1</span><script src='klient/auto.js'></script><script src='klient/album.js'></script><script src='klient/matika.js'></script></body></html>