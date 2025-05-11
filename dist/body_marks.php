<?php
		include("html_header.php");
		require("program/data/db_creds.php");
		require("program/Erza-min.php");
		$celkZn = 0;
		$celkVaha = 0;
	?>
<table id='znamtab'><tr><th>Student</th><th>Datum narození</th><th>E-mail</th><th>Pohlaví</th><th>O Mně</th><th>Předmět</th><th>Známka</th><th>Váha</th></tr> <?php
		date_default_timezone_set("UTC");
		
		try {
			$mysql = new Erza(DB_SERVER, DB_NAME, DB_USER, DB_PASS, KLIC, $_SERVER["REMOTE_ADDR"]);
			$mysql->setSaltPass(SALT, KLIC);

			$query = $mysql->prepare("SELECT `Main_ID`, `uzivatel`,`pohlavi_kod`,`datum_nar`,`email`,`bio`,`predmet_nazev`,`znamka_kod`,`vaha` FROM `znamky_spoj`
										INNER JOIN `kartoteka` ON `Main_ID`=`osoba_index`
										INNER JOIN `predmety_list` ON `PredmetID`=`predmet_index`
										ORDER BY `uzivatel` DESC
									");
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($result as $key) {
				$sexTxt = $key["pohlavi_kod"] == 1 ? "&female; ŽENA" : "&male; MUŽ";
				$sexClass = $key["pohlavi_kod"] == 1 ? "femstyle" : "malestyle";
				$znamka = 0;
				$datum = date("j F  Y", strtotime($key["datum_nar"]));
				$znTxt = "";
				switch($key["znamka_kod"]) {
				case 1:
					$znamka = 5;
					$znTxt = "5 (nedostatečný)";
					break;
				case 2:
					$znamka = 4.5;
					$znTxt = "4- (dostatečný/nedostatečný)";
					break;
				case 3:
					$znamka = 4;
					$znTxt = "4 (dostatečný)";
					break;
				case 4:
					$znamka = 3.5;
					$znTxt = "3- (dobrý/dostatečný)";
					break;
				case 5:
					$znamka = 3;
					$znTxt = "3 (dobrý)";
					break;
				case 6:
					$znamka = 2.5;
					$znTxt = "2- (chvalitebný/dobrý)";
					break;
				case 7:
					$znamka = 2;
					$znTxt = "2 (chvalitebný)";
					break;
				case 8:
					$znamka = 1.5;
					$znTxt = "1- (výborný/chvalitebný)";
					break;
				case 9:
					$znamka = 1;
					$znTxt = "1 (výborný)";
					break;
				default:
					$znamka = 0;
				}
				$celkZn += ($znamka*$key["vaha"]);
				$celkVaha += $key["vaha"];
				echo("<tr>
							<td class='uzivjm'>".$key["uzivatel"]."</td>
							<td>".$datum."</td>
							<td><a href='mailto:".$key["email"]."'>".$key["email"]."</a></td>
							<td class='".$sexClass."'>".$sexTxt."</td>
							<td>".htmlspecialchars($key["bio"])."</td>
							<td>".$key["predmet_nazev"]."</td>
							<td id='znam".$key["Main_ID"]."'>".$znTxt."</td>
							<td id='vaha".$key["Main_ID"]."'>".$key["vaha"]."</td>
					</tr>");
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
		?> </table><?php
		echo("<p class='vazprum'>Celkový průměr: <span id='prumzn'>".($celkZn/$celkVaha)."</span></p>");
		include("html_footer.php");
	?>