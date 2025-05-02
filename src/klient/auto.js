function regist() {
	const ajax = new XMLHttpRequest();
	ajax.onload = function() {
		var res = JSON.parse(this.responseText);

		if(res["code"] == 1) {
			console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
			document.getElementById("regstat").innerHTML = "Registrace proběhla úspěšně!<br>Zkontrolujte svůj E-mail pro více informací!";
			document.getElementById("regstat").style = "color: #009b77;";
		} else if(res["code"] == 0) {
			console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
		} else {
			document.getElementById("regstat").style = "color: #b80f0a;";
			switch(res["code"]) {
			case 21:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Zvolené uživatelské jméno nesplňuje požadavky!";
				break;
			case 22:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Zadaná E-mailová adresa není správného formátu!";
				break;
			case 23:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Pohlaví musí být zvoleno!";
				break;
			case 24:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Kraj nebyl správně zvolen!";
				break;
			case 25:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Z nějakého záhadného důvodu nemá parametr dobrovolného zasílání novinek správnou hodnotu...";
				document.getElementById("regstat").title = "Ty rošťáku jeden! :-)";
				break;
			case 26:
				console.log(res["msg"] + " | " + res["ip"] + ":" + res["port"]);
				document.getElementById("regstat").innerHTML = "Vaše bio musí obsahovat počet znaků v rozmezí <12; 256>";
				break;
			default:
				console.log("RETURN PARAMETER CODE IS INVALID");
				window.alert("CHYBA NA STRANĚ SERVERU! Prosíme kontaktujte administrátory na adrese admin@runergy.cz.");
			}
		}
	}
	ajax.open("POST", "register.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	if(document.getElementById("terms").checked) {
		if(document.getElementById("pwd").value === document.getElementById("ctpwd").value) {
			var sex = 2;

			if(document.getElementById("malerad").checked) {
				sex = 0;
			} else if(document.getElementById("femrad").checked) {
				sex = 1;
			}

			let kraj = document.getElementById("krajvyb").options[document.getElementById("krajvyb").selectedIndex].value;
			let news = document.getElementById("nwslttr").checked ? 1 : 0;

			ajax.send("user="+document.getElementById("usrnm").value+"&pass="+document.getElementById("pwd").value+"&email="+document.getElementById("mail").value+"&datnar="+document.getElementById("datnar").value+"&bio="+document.getElementById("bio").value+"&sex="+sex+"&kraj="+kraj+"&news="+news);
		} else {
			document.getElementById("regstat").innerHTML = "Hesla se neshodují!";
			document.getElementById("regstat").style = "color: #b80f0a;";
			window.alert("HESLA JSOU ROZDÍLNÁ!");
		}
	} else {
		document.getElementById("regstat").innerHTML = "Musíte souhlasit s podmínkami!";
		document.getElementById("regstat").style = "color: #b80f0a;";
		window.alert("PODMÍNKY NEBYLY ODSOUHLASENY!");
	}
}