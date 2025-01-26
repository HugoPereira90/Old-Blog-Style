<script>

//Variable globale
previousText2 = "";
timer2 = 0;

//Timer qui boucle toutes les secondes pour changer la variable globale
function TimerIncrease_fetch() {
  timer2+=1000;
  setTimeout('TimerIncrease_fetch()',1000);
}
TimerIncrease_fetch();

//Pour utiliser fetch, la fonction doit être "asynchrone"
async function suggestNamesFromInput(currentText) {
  //Test si le texte à rechercher est différent de l'ancien 
  if (currentText != previousText2 && timer2 >= 1000 ){

	  var AJAXresult = await fetch("./BoutPage/Suggestion.php?var=" + currentText);
	  document.getElementById("suggestions").innerHTML = await AJAXresult.text();

    previousText2 = currentText;
    timer2 = 0;
  }
}
// Propose un nom qui correspond au texte entré dans la barre de recherche
function autoFillName_fetch(nametext){
  document.getElementById("suggestField").value = nametext;
}

</script>
<!-- Propose le/les noms qui correspondent aux texte entré dans la barre de recherche -->
<input id="suggestField" type="text" onkeyup="suggestNamesFromInput(this.value)">
<p id="suggestions">Suggestions : <i>(chercher d'autres utilisateur)</i></p>