<!-- Barre de naviguation -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Bouttons pour petit écran -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<a style="position:absolute;left:40px;bottom:0px;z-index:0px;" href="index.php"><img src="style/images/cocktail2.png"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="index.php">Accueil</a></li>
					<li><a href="aPropos.php">A Propos</a></li>
					<li><a href="nosRecettes.php">Nos Recettes</a></li>
					<li><a href="recherche.php">Rechercher une recette</a></li>
					</li>
					<li><a href="contact.php">Contact</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mon compte<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="espacePerso.php">Espace Personnel</a></li>
							<?php 
								if(isset($_SESSION['login'])){
									echo '<li><a href="deconnexion.php">Deconnexion</a></li>';
								}
							?>
						</ul>
					</li>
					<?php
						if(isset($_SESSION['login'])){
							echo '<li><a class="btn" href="favoris.php">Mes recettes préférés</a></li>';
						}
					?>
					<?php
						if(isset($_SESSION['login'])){
							echo '';
						}
						else{
							echo '<li><a class="btn" href="seConnecter.php">Se Connecter</a></li>';
						}
					?>
					
				</ul>
			</div>
		</div>
	</div>
	<!-- Fin de la barre de naviguation -->  