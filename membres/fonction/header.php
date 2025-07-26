
<div class='header'>
	<div id="img_top">
		<img id="img_top_banniere" src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/image/fond.jpg">
		<h1>MCIDA</h1>
		
		<a href="javascript:window.history.go(-1)"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/backPage.png"></a>
		
	</div>
	<div id="bar_profil">
		<div>
			<?php
			if ($_SESSION['user_id'] == 1 OR $_SESSION['user_id'] == 2 OR $_SESSION['user_id'] == 3) {
			?>
				<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/admin/admin.php" style="width: 100%; height: 100%;"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/utilisateurs/<?php echo $_SESSION['user_email'].'/'.$_SESSION['user_email'].'_profil.jpg'; ?>"></a>
			<?php
			}else{
			?>
				<img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/utilisateurs/<?php echo $_SESSION['user_email'].'/'.$_SESSION['user_email'].'_profil.jpg'; ?>">
			<?php	
			}
			?>
			
		</div>
		<h4><?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></h4>
		<div id="notif_img">
			<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/notification.php"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/notification_b.png"><?php compte_notification($db, $_SESSION['user_id']); ?></a>
		</div>
		<div>
		<div class="navigation">
			<ul>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/index.php" id="index">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/agenda_b.png"></span>
						<span class="text">Prochains Sorties</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/ancien.php" id="ancien">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/photo_b.png"></span>
						<span class="text">Anciens Sorties</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/balade_propose.php" id="edit">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/edit_b.png"></span>
						<span class="text">Mes Sorties</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/membre.php" id="membre">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/membre_b.png"></span>
						<span class="text">Membres</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/parametre.php" id="parametre">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/parametre_b.png"></span>
						<span class="text">Paramètres</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/index.php" id="home">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/home_b.png"></span>
						<span class="text">Acceuil</span>
					</a>
				</li>
				<li class="list">
					<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/delete/deconnexion.php" id="deconnexion">
						<span class="icon"><img src="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/membres/image/deconnexion_b.png"></span>
						<span class="text">Déconnexion</span>
					</a>
				</li>
				<div class="indicatoract"></div>
			</ul>
    	</div>

	</div>
</div>
</div>

<div id="loading" class="back no">
	<div class="loading">
		<img id="compteur" src="../../image/inscription/compteur_kilometre.png">
		<div id="aiguille_div">
			<img id="aiguille" src="../../image/inscription/aiguille.png">
		</div>
	</div>
	<div class="wrapper">
		<div class="typing">Chargement en cours ...</div>
	</div>
</div>

<script>
    /* barre navigation */
    const list = document.querySelectorAll('.list');
    function activeLink(){
        list.forEach((item)=>
        item.classList.remove('active'));
        this.classList.add('active');
    }
    list.forEach((item) =>
    item.addEventListener('click', activeLink));
    /* Delay barre navigation */
    $(function() {
        $('#acceuil').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
    $(function() {
        $('#index').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
    $(function() {
        $('#ancien').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
    $(function() {
        $('#edit').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
    $(function() {
        $('#membre').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
	$(function() {
        $('#parametre').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
	$(function() {
        $('#home').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });
	$(function() {
        $('#deconnexion').on('click', function(e) {
            e.preventDefault();
            var self = this;
            setTimeout(function() {
                window.location.href = self.href;
            }, 600);
        });
    });

</script>
