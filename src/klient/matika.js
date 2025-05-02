function parts() {
	var avog = 6.02214076 * Math.pow(10, 23);
	var weightm;
	var molarweight = parseFloat(document.getElementById("molarw").value);

	switch(document.getElementById("jednotky").options[document.getElementById("jednotky").selectedIndex].value) {
	case 0:
		weightm = parseFloat(document.getElementById("weightm").value);
		break;
	case 1:
		weightm = (parseFloat(document.getElementById("weightm").value) / 1000);
		break;
	case 2:
		weightm = (parseFloat(document.getElementById("weightm").value) / 1000000);
		break;
	case 3:
		weightm = (parseFloat(document.getElementById("weightm").value) / 1000000000);
		break;
	default:
		weightm = parseFloat(document.getElementById("weightm").value);
	}

	var mols = weightm / molarweight;

	document.getElementById("partsres").innerHTML = "Počet částic/molekul je " + (mols * avog) + "!";
}