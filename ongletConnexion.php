     <!-- Texte de redirection -->
	<div class="container">
		<ol class="breadcrumb" style="padding-left:1.5em;">
			<li><a href="index.php">Accueil</a></li>
			<li class="active">Se Connecter</li>
		</ol>

		<article class="col-sm-9 maincontent">
			<header class="page-header">
				<h1 class="page-title" style=" margin-left: 1px;" >Connexion</h1>
			</header>
		</article>
		<!-- FIN Du texte de redirection -->

		<!-- Onglet se connecter -->
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 align="center">Connexion à votre compte</h3>
						<p class="text-center text-muted">Veuillez vous connecter pour accèder au contenu du site ! </p>
						<hr>

						<form method=post>
							<div class="top-margin">
								<label>Login <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="login_contact">
							</div>
							<div class="top-margin">
								<label>Mot de passe <span class="text-danger">*</span></label>
								<input type="password" class="form-control" name="mdp_contact">
							</div>
							<div class="top-margin">
                    				<?php echo "<p class='text-danger'>$result</p>";?>  
                			</div>

							<hr>

							<div class="row">
								<div class="col-lg-12 text-center">
									<button class="btn btn-action" type="submit" name="submit" >Se connecter</button>
								</div> 
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- FIN onglet de connexion --> 


			<!-- Onglet s'enregistrer -->
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3 align="center">Pas encore enregistré ?</h3>
						<p class="text-center text-muted">Authentifier vous découvrir notre gamme de cocktail !</p>
						<hr>
							<div class="row">
								<div class="col-lg-12 text-center">
									<a href="authentification.php" class="btn btn-action">S'enregistrer</a>
								</div> 
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Fin onglet s'enregistrer -->
	</div>'