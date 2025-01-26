<script>
	//Fonction pour rollover image "oeil"
	//---------------------------------------------------------------
	function ShowPass_MouseOn(icone){
		icone.style.width="34px"; icone.style.height="34px";
		icone.style.marginTop="61px";
	}

	//Fonction pour rollout image "oeil"
	//---------------------------------------------------------------
	function ShowPass_MouseOff(icone){
		icone.style.width="32px"; icone.style.height="32px";
		icone.style.marginTop="62px";
	}

	//Fonction pour montrer/cacher le mot de passe
	//---------------------------------------------------------------
    function TogglePass(icone){
		var field = document.getElementById("password");
		if (field.type == "password"){
			icone.src="./Images/password_show.png";
			field.type="text";
		}
		else {
			icone.src="./Images/password_hide.png";
			field.type="password";
		}
	}
</script>


<!-- Le Formulaire pour se connecter à son compte -->
<form action="./Login.php" method="post">

    <div class="formbutton">Connexion à mon site de démo</div>
    <div class="HideFormContainer">
		<img id="passHide" onmouseover="ShowPass_MouseOn(this)" onmouseout="ShowPass_MouseOff(this)" onclick="TogglePass(this)"src="./Images/password_hide.png" alt="Show/hide password" width=32 height=32>
	</div>
    <div>
        <label for="name">Login :</label>
        <input autofocus type="text" id="name" name="name">
    </div>
    <div>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password">
    </div>
    <div class="formbutton">
        <button type="submit">Se Connecter</button>
    </div>
</form>

<!-- Le bouton pour créer un nouveau compte -->
<form  action="./newAccount.php" method="post">
    <div class="formbutton">
		<button type="submit">Crée un nouveau compte</button>
	</div>
</form>	