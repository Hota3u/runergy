function resetcount() {
	document.getElementById("albcit").innerHTML = "1";
}

function albumback() {
	var poradi = parseInt(document.getElementById("albcit").innerHTML);
	var selectedBook = "";
	var maxstran = 0;
	var special = false;

	switch(parseInt(document.getElementById("books").options[document.getElementById("books").selectedIndex].value)) {
	case 0:
		selectedBook = "twisted_intent";
		maxstran = 9;
		break;
	case 1:
		selectedBook = "twisted_intent_2";
		maxstran = 16;
		break;
	case 2:
		selectedBook = "nina_greenhair";
		maxstran = 12;
		break;
	case 3:
		selectedBook = "han_song_yi";
		maxstran = 15;
		break;
	case 4:
		selectedBook = "edel_artkoikoi";
		maxstran = 10;
		break;
	case 5:
		selectedBook = "nino_nakano_artkoikoi";
		maxstran = 43;
		break;
	case 6:
		selectedBook = "emergence_henshin";
		maxstran = 246;
		special = true;
		break;
	default:
		let randAlb = Math.floor(Math.random() * 4);
		if(randAlb == 0) {
			selectedBook = "twisted_intent";
			maxstran = 9;
		} else if(randAlb == 1) {
			selectedBook = "twisted_intent_2";
			maxstran = 16;
		} else if(randAlb == 2) {
			selectedBook = "nina_greenhair";
			maxstran = 12;
		} else if(randAlb == 3) {
			selectedBook = "han_song_yi";
			maxstran = 15;
		} else if(randAlb == 4) {
			selectedBook = "edel_artkoikoi";
			maxstran = 10;
		} else {
			selectedBook = "nino_nakano_artkoikoi";
			maxstran = 43;
		}
	}

	if(special) {
		if(poradi <= 0) {
			document.getElementById("albcit").innerHTML = maxstran;
			document.getElementById("animealb").src = "obrazky/"+selectedBook+"/"+maxstran+".jpg";
			document.getElementById("animealb").title = "Stránka  "+maxstran+" | "+maxstran;
		} else {
			document.getElementById("albcit").innerHTML = (poradi - 1);
			document.getElementById("animealb").src = "obrazky/"+selectedBook+"/"+(poradi-1)+".jpg";
			//document.getElementById("animealb").title = "Stránka "+(poradi-1)+"!";
			document.getElementById("animealb").title = ((poradi-1) == 0) ? "ÚVODNÍ STRÁNKA!" : "Stránka "+(poradi-1)+" | "+maxstran;
		}
	} else if(poradi <= 0) {
		document.getElementById("albcit").innerHTML = maxstran;
		document.getElementById("animealb").src = "obrazky/"+selectedBook+"/page_"+maxstran+".jpg";
		document.getElementById("animealb").title = "Stránka "+maxstran+"!";
	} else {
		document.getElementById("albcit").innerHTML = (poradi - 1);
		document.getElementById("animealb").src = "obrazky/"+selectedBook+"/page_"+(poradi-1)+".jpg";
		//document.getElementById("animealb").title = "Stránka "+(poradi-1)+"!";
		document.getElementById("animealb").title = ((poradi-1) == 0) ? "ÚVODNÍ STRÁNKA!" : "Stránka "+(poradi-1)+"!";
	}
}

function albumnext() {
	var poradi = parseInt(document.getElementById("albcit").innerHTML);
	var selectedBook = "";
	var maxstran = 0;
	var special = false;

	switch(parseInt(document.getElementById("books").options[document.getElementById("books").selectedIndex].value)) {
	case 0:
		selectedBook = "twisted_intent";
		maxstran = 9;
		break;
	case 1:
		selectedBook = "twisted_intent_2";
		maxstran = 16;
		break;
	case 2:
		selectedBook = "nina_greenhair";
		maxstran = 12;
		break;
	case 3:
		selectedBook = "han_song_yi";
		maxstran = 15;
		break;
	case 4:
		selectedBook = "edel_artkoikoi";
		maxstran = 10;
		break;
	case 5:
		selectedBook = "nino_nakano_artkoikoi";
		maxstran = 43;
		break;
	case 6:
		selectedBook = "emergence_henshin";
		maxstran = 246;
		special = true;
		break;
	default:
		let randAlb = Math.floor(Math.random() * 4);
		if(randAlb == 0) {
			selectedBook = "twisted_intent";
			maxstran = 9;
		} else if(randAlb == 1) {
			selectedBook = "twisted_intent_2";
			maxstran = 16;
		} else if(randAlb == 2) {
			selectedBook = "nina_greenhair";
			maxstran = 12;
		} else if(randAlb == 3) {
			selectedBook = "han_song_yi";
			maxstran = 15;
		} else if(randAlb == 4) {
			selectedBook = "edel_artkoikoi";
			maxstran = 10;
		} else {
			selectedBook = "nino_nakano_artkoikoi";
			maxstran = 43;
		}
	}

	if(special) {
		if(poradi >= maxstran) {
			document.getElementById("albcit").innerHTML = "0";
			document.getElementById("animealb").src = "obrazky/"+selectedBook+"/0.jpg";
			document.getElementById("animealb").title = "ÚVODNÍ STRÁNKA!";
		} else {
			document.getElementById("albcit").innerHTML = (poradi + 1);
			document.getElementById("animealb").src = "obrazky/"+selectedBook+"/"+(poradi+1)+".jpg";
			//document.getElementById("animealb").title = "Stránka "+(poradi-1)+"!";
			document.getElementById("animealb").title = ((poradi+1) > maxstran) ? "ÚVODNÍ STRÁNKA!" : "Stránka "+(poradi+1)+" | "+maxstran;
		}
	} else if(poradi >= maxstran) {
		document.getElementById("albcit").innerHTML = "0";
		document.getElementById("animealb").src = "obrazky/"+selectedBook+"/page_0.jpg";
		document.getElementById("animealb").title = "ÚVODNÍ STRÁNKA!";
	} else {
		document.getElementById("albcit").innerHTML = (poradi + 1);
		document.getElementById("animealb").src = "obrazky/"+selectedBook+"/page_"+(poradi+1)+".jpg";
		//document.getElementById("animealb").title = "Stránka "+(poradi+1)+"!";
		document.getElementById("animealb").title = ((poradi+1) == 0) ? "ÚVODNÍ STRÁNKA!" : "Stránka "+(poradi+1)+"!";
	}
}

function filmek() {
	switch(parseInt(document.getElementById("filmzvol").options[document.getElementById("filmzvol").selectedIndex].value)) {
	case 0:
		document.getElementById("filmek").src = "videa/MOVIE_Fairy_Tail_Dragon_Cry_720p-hevc.mp4";
		break;
	case 1:
		document.getElementById("filmek").src = "videa/Roxy_Bells_Gangbang_720p-hevc.mp4";
		break;
	case 2:
		document.getElementById("filmek").src = "videa/soshite-watashi-wa-ojisan-ni-2-1080p-v1x-hevc.mp4";
		break;
	case 3:
		document.getElementById("filmek").src = "videa/soshite-watashi-wa-ojisan-ni-3-1080p-v1x-hevc.mp4";
		break;
	default:
		document.getElementById("filmek").src = "videa/MOVIE_Fairy_Tail_Dragon_Cry_720p-hevc.mp4";
	}
}