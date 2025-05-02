<table id='regtab'>
	<tr>
		<th>Uživatelské jméno:</th>
		<td>
			<input type='text' id='usrnm' class='regform'>
		</td>
	</tr>
	<tr>
		<th>Heslo:</th>
		<td>
			<input type='password' id='pwd' class='regform'>
		</td>
	</tr>
	<tr>
		<th>Heslo (znovu):</th>
		<td>
			<input type='password' id='ctpwd' class='regform'>
		</td>
	</tr>
	<tr>
		<th>E-mail:</th>
		<td>
			<input type='email' id='mail' value='@' class='regform'>
		</td>
	</tr>
	<tr>
		<th>Datum narození:</th>
		<td>
			<input type='date' id='datnar' class='regform'>
		</td>
	</tr>
	<tr>
		<th>Kraj:</th>
		<td>
			<select id='krajvyb'>
				<?php
					require_once("program/data/db_creds.php");
					require_once("program/Erza-min.php");

					try {
						$mysql = new Erza(DB_SERVER, DB_NAME, DB_USER, DB_PASS, KLIC, $_SERVER["REMOTE_ADDR"]);
						$mysql->setSaltPass(SALT, KLIC);

						$query = $mysql->prepare("SELECT `KrajID`,`kraj_nazev` FROM `kraje_list`");
						$query->execute();
						$result = $query->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $key) {
							echo("
									<option value='".$key["KrajID"]."'>".$key["kraj_nazev"]."</option>
								");
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
					?>
			</select>
		</td>
	</tr>
	<tr>
		<th>O Mně:</th>
		<td>
			<textarea id='bio'>Zde zadejte něco o Vás...</textarea>
		</td>
	</tr>
	<tr>
		<th><input type='radio' id='malerad' name='gender' value='0' class='radiobutt'></th>
		<td>
			<label for='malerad' class='malelabel'>&male; MUŽ</label>
		</td>
	</tr>
	<tr>
		<th><input type='radio' id='femrad' name='gender' value='1' class='radiobutt'></th>
		<td>
			<label for='femrad' class='femlabel'>&female; ŽENA</label>
		</td>
	</tr>
	<tr>
		<th>
			<input type='checkbox' id='nwslttr' checked>
		</th>
		<td>
			Chci zasílat pravidelné novinky na svůj E-mail.
		</td>
	</tr>
	<tr>
		<th>
			<input type='checkbox' id='terms'>
		</th>
		<td id='termstxt'>
			Přečetl(a) jsem & souhlasím s <a href='terms.php'>podmínkami</a> registrace!
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<button type='button' onclick='regist()'>Registrovat</button>
		</td>
	</tr>
</table>
<p id='regstat'></p>