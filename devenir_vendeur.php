<?php 
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include ("database/db_connect.php");

	//Redirection vers index si l'utilisateur est deja vendeur
	if (isset($_SESSION['user_Role'])) 
	{
	    if ($_SESSION['user_Role'] == 1 || $_SESSION['user_Role'] == 3)
	    	header("Location: index.php");
	}
 
	if (isset($_POST["devenir"])) 
	{
		$id = $_SESSION['user_ID'];
		$sql = "SELECT Role FROM utilisateur WHERE ID = $id";
		$result = mysqli_query($db_handle, $sql);
		if ($result != NULL) {	
			while ($data = mysqli_fetch_assoc($result))
			{
				$sql_changement= "UPDATE utilisateur SET Role = 3 WHERE ID = $id";
				$result_changement = mysqli_query($db_handle, $sql_changement);
				$_SESSION['user_Role'] = 3;
				header("Location: vente.php");
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<title>Devenir vendeur</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22> <text y=".9em" font-size="90">💩</text></svg>'>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bs.css">
	<script type="text/javascript">
		
	</script>
</head>

<body>

	<!-- Navbar -->
	<?php include("nav.php") ?>


	<!-- Header -->
	<header>
		
	</header>
	<!-- Conteneur -->
	<div class="container-fluid">
		<div class="container" id="accueil">
			<h3 style="text-align: center;"> <br>Devenir Vendeur </h3>
			<h5 class="container" style="text-align: center;" > Etape 1 Pour mettre un objet en vente, c'est très simple appuyez sur l'onglet "VENTE" dans la nav bar, puis : </h5>
			<div class="row col-md-8" style="margin: 0 auto;  	margin-top: 10px; padding: 10px; border: 2px solid; border-radius: 5px;">
				<div class="col-md-4" > <H3>Vous arrivez sur une page comme celle-ci</H3></div>
				<div class="col-md-8"><img src="img/devenir_vendeur1" style="height: 300px; width: 450px;"></div>
			</div>
			<div class="row col-md-8" style="margin: 0 auto; margin-top: 10px; margin-bottom: 10px; padding: 10px; border: 2px solid; border-radius: 5px;">
				<div class="col-md-8"><img src="img/devenir_vendeur2" style="height: 300px; width: 450px;"></div>
				<div class="col-md-4" > <H3> Remplissez les champs demandés et mettez en vente vos antiquités</H3></div>
			</div>
			<h4 style="text-align: center;margin: 30px;"> Interéssé(e) : Accepte les conditions d'utilisation et lance-toi ! </h4>
			<div style="overflow-y:scroll; max-height: 400px; border:#000000 1px solid;">

				ONDITIONS D'UTILISATION ET GENERALES DE VENTE
				<br><br>
				Dernière mise à jour le 27 juin 2019. Pour consulter la version précédente, rendez-vous ici.
				<br><br>
				Bienvenue sur ECE EBAY.

				Amazon Europe Core SARL, Amazon EU SARL et/ou leurs sociétés affiliées (« Amazon ») vous fournissent des fonctionnalités de site internet et d'autres produits et services quand vous visitez le site internet Amazon.fr (le « site internet »), effectuer des achats sur le site Internet, utiliser des appareils, produits et services d'Amazon, utiliser des applications Amazon pour mobile, utiliser des logiciels fournis par Amazon dans le cadre de tout ce qui précède (ensemble ci-après, les « Services Amazon »). Veuillez consulter notre Notice Protection de vos Informations Personnelles, notre Notice Cookies et notre Notice Annonces publicitaires basées sur vos centres d'intérêt pour comprendre comment nous collectons et traitons vos informations personnelles dans le cadre des Services Amazon. Amazon fournit les Services Amazon et vend des produits selon les conditions définies sur cette page. Amazon.fr est le nom commercial utilisé par Amazon.

				Conditions d'utilisation
				<br><br>
				Conditions Générales de Vente
				CONDITIONS D'UTILISATION

				Merci de lire ces conditions attentivement avant d'utiliser les Services Amazon. En utilisant les Services Amazon, vous acceptez d'être soumis aux présentes conditions. Nous offrons un large panel de Services Amazon et il se peut que des conditions additionnelles s'appliquent. Quand vous utilisez un Service Amazon (par exemple, Votre Profil, les Chèques-Cadeaux ou les Applications Amazon pour mobile), vous êtes aussi soumis aux termes, lignes directrices et conditions applicables à ce Service Amazon (« Conditions du Service »). Si ces Conditions d'Utilisation entrent en contradiction avec ces Conditions du Service, les Conditions du Service prévaudront.

				Procédure et formulaire de notification de violation de droits.

				Procédure et Formulaire de notification en vue de notifier un contenu injurieux ou diffamatoire.
				<br><br>
				1. COMMUNICATIONS ELECTRONIQUES

				Quand vous utilisez un quelconque Service Amazon ou que vous nous envoyez des courriers électroniques, SMS ou autres communications depuis vos équipements fixes ou mobiles, vous communiquez avec nous électroniquement. Nous communiquerons avec vous électroniquement par divers moyens, tels que par courrier électronique, SMS, messages de notification dans l'application ou en postant des courriers électroniques ou des communications sur le site internet ou à travers les autres Services Amazon, tels que notre Gestionnaire de communication. A des fins contractuelles, vous acceptez que tous les accords, informations, divulgations et autres communications que nous vous enverrons électroniquement remplissent toutes les obligations légales des communiquer par écrit, à moins qu'une loi impérative spécifique impose un autre mode de communication.
				<br><br>
				2. RECOMMANDATIONS ET PERSONNALISATION

				Dans le cadre des Services Amazon, nous vous recommanderons des fonctionnalités, des produits et des services, comprenant des publicités de tiers, qui sont susceptibles de vous intéresser, nous identifierons vos préférences et nous personnaliserons votre expérience.
				<br><br>3. PROPRIETE INTELLECTUELLE, DROIT D'AUTEUR, ET PROTECTION DES BASES DE DONNEES

				Tout le contenu présent ou rendu disponible à travers les Services Amazon, tels que les textes, les graphiques, les logos, les boutons, les images, les morceaux de musique, les téléchargements numériques, et les compilations de données, est la propriété d'Amazon, de ses sociétés affiliées ou de ses fournisseurs de contenu et est protégé par le droit luxembourgeois et international de la propriété intellectuelle, d'auteur et de protection des bases de données. La compilation de tout le contenu présent ou rendu disponible à travers les Services Amazon est la propriété exclusive d'Amazon et est protégé par le droit luxembourgeois et international de la propriété intellectuelle et de protection des bases de données.

				Vous ne devez pas extraire et/ou réutiliser de façon systématique des parties du contenu de tout Service Amazon sans notre autorisation expresse et écrite. En particulier, vous ne devez pas utiliser de robot d'aspiration de données, ou tout autre outil similaire de collecte ou d'extraction de données pour extraire (en une ou plusieurs fois), pour réutiliser une partie substantielle d'un quelconque Service Amazon, sans notre accord express et écrit. Vous ne devez pas non plus créer et/ou publier vos propres bases de données qui comporteraient des parties substantielles (ex : nos prix et nos listes de produits) d'un Service Amazon sans notre accord express et écrit.
				<br><br>
				4. MARQUES DEPOSEES

				Cliquer ici pour voir une liste non exhaustive des marques déposées par Amazon. Par ailleurs, les graphiques, logos, en-têtes de page, boutons, scripts et noms de services inclus ou rendus disponibles à travers un Service Amazon sont des marques ou visuels d'Amazon. Les marques et visuels d'Amazon ne peuvent pas être utilisés pour des produits ou services qui n'appartiennent pas à Amazon, ou d'une quelconque manière qui pourrait provoquer une confusion parmi les clients, ou d'une quelconque manière qui dénigre ou discrédite Amazon. Toutes les autres marques qui n'appartiennent pas à Amazon et qui apparaissent sur un quelconque Service Amazon sont la propriété de leurs propriétaires respectifs, qui peuvent, ou non, être affiliés, liés ou parrainés par Amazon.
				<br><br>
				5. BREVETS

				Un ou plusieurs brevets détenus par Amazon s'appliquent aux Services Amazon, à ce site internet et aux fonctionnalités et services accessibles via le site internet et les Services Amazon. Des parties de ce site internet fonctionnent sous licences d'un ou plusieurs brevets. Cliquer ici pour voir une liste non exhaustive des brevets détenus par Amazon et des licences de brevets applicables.
				<br><br>
				6. LICENCE ET ACCES

				Sous réserve du respect des présentes Conditions d'Utilisation et des Conditions des Services et du paiement de tous les sommes applicables, Amazon ou ses fournisseurs de contenu vous accorde une licence limitée, non exclusive, non transférable, non sous licenciable pour l'accès et à l'utilisation personnelle et non commerciale des Services Amazon. Cette licence n'inclut aucun droit d'utilisation d'un Service Amazon ou de son contenu pour la vente ou tout autre utilisation commerciale ; de collecte et d'utilisation d'un listing produit, descriptions, ou prix de produits; de toute utilisation dérivée d'un Service Amazon ou de son contenu ; de tout téléchargement ou copie des informations d'un compte pour un autre commerçant ; ou de toute utilisation de robot d'aspiration de données, ou autre outil similaire de collecte ou d'extraction de données.

				Tous les droits qui ne vous ont pas été expressément accordés dans ces Conditions d'Utilisation ou dans les Conditions d'un Service sont réservés et restent à Amazon ou à ses licenciés, fournisseurs, éditeurs, titulaires de droits, ou tout autre fournisseur de contenu. Aucun Service Amazon ou tout ou partie de celui-ci ne doit être reproduit, copié, vendu, revendu, visité ou exploité pour des raisons commerciales sans notre autorisation expresse et écrite.

				Vous ne devez pas cadrer ou utiliser des techniques de cadrage (framing) pour insérer toute marque, logo ou autre information commerciale (y compris des images, textes, mises en pages ou formes) d'Amazon sans notre autorisation expresse et écrite. Vous ne devez pas utiliser de méta tags ou tout autre « texte caché » utilisant le nom ou les marques déposées d'Amazon sans notre autorisation expresse et écrite.

				Vous ne devez pas faire un mauvais usage d'un Service Amazon. Vous devez utiliser les Services Amazon comme autorisé par la loi. Les licences accordées par Amazon prendront fin si vous ne respectez pas ces Conditions d'Utilisation ou les Conditions des Services.
				<br><br>
				7. VOTRE COMPTE

				Vous pouvez avoir besoin d'un compte personnel Amazon pour utiliser certain Services Amazon, et il peut vous être demandé de vous connecter au compte et d'avoir une méthode de paiement valide associée à celui-ci. En cas de problème pour utiliser la méthode de paiement que vous avez sélectionnée, nous pourrons utiliser toute autre méthode de paiement valide associée à votre compte. Cliquez ici pour gérer vos options de paiement.

				Si vous utilisez un quelconque Service Amazon, vous êtes responsable du maintien de la confidentialité de votre compte et mot de passe, des restrictions d'accès à votre ordinateur et autres équipements, et dans la limite de ce qui est autorisé par la loi applicable, vous acceptez d'être responsable de toutes les activités qui ont été menées depuis de votre compte ou avec votre mot de passe. Vous devez prendre toutes les mesures nécessaires pour vous assurer que votre mot de passe reste confidentiel et sécurisé, et devez nous informer immédiatement si vous avez des raisons de croire que votre mot de passe est connu de quelqu'un d'autre, ou si le mot de passe est utilisé ou susceptible d'être utilisé de manière non autorisée. Vous êtes responsable de la validité et du caractère complets des informations que vous nous avez fournies, et devez nous informer de tout changement concernant ces informations. Vous pouvez accéder à vos informations dans la section Votre compte du site internet. Veuillez consulter nos pages d'aide relatives à la Protection de vos informations personnelles pour accéder à vos informations personnelles.

				Vous ne devez pas utiliser un quelconque Service Amazon : (i) d'une façon qui causerait, ou serait susceptible de causer une interruption, un dommage, ou une altération d'un Service Amazon, or (ii) dans un but frauduleux, ou en relation avec un crime ou une activité illégale, ou (iii) dans le but provoquer des troubles, nuisances ou causes d'anxiétés.

				Nous nous réservons le droit de refuser l'accès, de fermer un compte, de retirer ou de modifier du contenu si vous êtes en violation des lois applicables, de ces Conditions d'utilisation ou tous autres termes, conditions, lignes directrices ou politique d'Amazon.
				<br><br>
				8. COMMENTAIRES, CRITIQUES, COMMUNICATIONS ET AUTRE CONTENU

				Les visiteurs peuvent mettre en ligne des revues, des commentaires ou tout autre contenu ; envoyer des cartes électroniques ou autres communications, et soumettre des suggestions, des idées, des questions ou toute autre information tant que ce contenu n'est pas illégal, obscène, abusif, menaçant, diffamatoire, calomnieux, contrevenant aux droits de propriété intellectuelle, ou préjudiciable à des tiers ou répréhensible et ne consiste pas ou ne contient pas de virus informatiques, de militantisme politique, de sollicitations commerciales, de chaînes de courriers électroniques, de mailing de masse ou toute autre forme de « spam ». Vous ne devez pas utiliser une fausse adresse e-mail, usurper l'identité d'une personne ou d'une entité, ni mentir sur l'origine d'une carte de crédit ou d'un contenu. Nous nous réservons le droit (sans aucune obligation en l'absence d'un Formulaire de Notification valide), de retirer ou de modifier tout contenu. Si vous pensez qu'un contenu ou une annonce de vente sur un quelconque Service Amazon contient un message diffamatoire, ou que vos droits de propriété intellectuelle ont été enfreints par un article ou une information sur le site internet, merci de nous le notifier en complétant le Formulaire de Notification adéquat, et nous y répondrons.

				Si vous publiez des commentaires clients, , des questions / réponses ou tout autre contenu généré par vous pour être publié sur le site internet (incluant toute image, vidéo ou enregistrement audio, ensemble le « contenu ») , vous accordez à Amazon, (i) une licence non-exclusive et gratuite pour utiliser, reproduire, , publier, rendre disponible, traduire et modifier ce contenu dans le monde entier(incluant le droit de sous-licencier ces droits à des tiers); et (b) le droit d'utiliser le nom que vous avez utilisé en lien avec ce contenu. Aucuns droits moraux ne sont transférés par l'effet de cette clause.

				Vous pouvez supprimer votre contenu de la vue du public ou, lorsque cette fonctionnalité est offerte, modifier les paramètres pour qu'il ne soit visible que par les personnes auxquelles vous en avez donné l'accès. Vous déclarez et garantissez être propriétaire ou avoir les droits nécessaires sur le contenu que vous publiez ; que, à la date de publication du contenu ou du matériel : (i) le contenu et le matériel est exact, (ii) l'utilisation du contenu et du matériel que vous avez fourni ne contrevient pas à l'une des procédures ou lignes directrices d'Amazon et ne portera pas atteinte à toute personne physique ou morale (notamment que le contenu ou le matériel ne sont pas diffamatoires). Vous acceptez d'indemniser Amazon en cas d'action d'un tiers contre Amazon en lien avec le contenu ou le matériel que vous avez fourni, sauf dans le cas où l'éventuelle responsabilité d'Amazon pourrait être recherchée pour ne pas avoir retiré un contenu dont le caractère illicite lui aurait été notifié (Formulaire de Notification), dès lors que cette action aurait pour cause, fondement ou origine le contenu que vous nous avez communiqué.
				<br><br>
				9. REVENDICATIONS DE PROPRIETE INTELLECTUELLE

				Amazon respecte la propriété intellectuelle d'autrui. Si vous pensez qu'un de vos droits de propriété intellectuelle a été utilisé d'une manière qui puisse faire naitre une crainte de violation desdits droits, merci de suivre notre Procédure et formulaire de notification de violation de droits.
				<br><br>
				10. CONDITIONS LOGICIEL AMAZON

				S'ajoute à ces Conditions d'Utilisation, les conditions suivantes qui s'appliquent à tous les logiciels (en ce compris les mises à jour ou les évolutions du logiciel et de toute la documentation liée) que nous vous rendons disponibles pour votre utilisation des Services Amazon (ci-après « Logiciels Amazon »).
				<br><br>
				11. AUTRES ENTREPRISES

				Des tiers autres qu'Amazon gèrent des boutiques, proposent des services et vendent des lignes de produits sur ce site internet. De surcroit, nous fournissons des liens vers des sites internet de société affiliées et d'un certain nombre d'entreprises. Nous ne sommes pas responsables de l'examen ou de l'évaluation, et nous ne garantissons pas les offres de ces entreprises ou de ces particuliers, ou le contenu de leurs sites internet. Amazon n'assume aucune responsabilité ou obligation pour les actes, produits ou contenu de ces entreprises ou de ces particuliers ou d'autres tiers. Vous êtes informés quand un tiers est impliqué dans votre transaction, et nous pouvons partager vos informations en lien avec cette transaction avec ce tiers. Vous devez examiner leurs politiques de confidentialité et autres conditions d'utilisation avec attention.
				<br><br>
				12. ROLE D'AMAZON

				Amazon permet à des vendeurs tiers de lister et de vendre leurs produits sur Amazon.fr. Dans chacun de ces cas, ceci est indiqué sur la page respective de détail du produit. Bien qu'Amazon, en tant qu'hébergeur, facilite les transactions réalisées sur la place de marché (ou Marketplace) d'Amazon, Amazon n'est ni l'acheteur ni le vendeur des produits des vendeurs tiers. Amazon fournit un lieu de rencontre dans lequel les acheteurs et vendeurs complètent et finalisent leurs transactions. En conséquence, pour la vente de ces produits de vendeurs tiers, un contrat de vente est formé uniquement entre l'acheteur et le vendeur tiers. Amazon n'est pas partie à un tel contrat et n'assume aucune responsabilité ayant pour origine un tel contrat ou découlant de ce contrat de vente. Amazon n'est ni l'agent ni le mandataire des vendeurs tiers. Le vendeur tiers est responsable des ventes de produits et des réclamations ou tout autre problème survenant ou lié au contrat de vente entre lui et l'acheteur. Parce qu'Amazon souhaite que l'acheteur bénéficie d'une expérience d'achat la plus sûre, Amazon offre la Garantie A à Z en plus de tout droit contractuel ou autre.
				<br><br>
				13. NOTRE RESPONSABILITE

				Nous ferons de notre mieux pour assurer la disponibilité des Services Amazon et que les transmissions se feront sans erreurs. Toutefois, du fait de la nature d'internet, ceci ne peut être garanti. De plus, votre accès aux Services Amazon peut occasionnellement être suspendu ou limité pour permettre des réparations, la maintenance, ou ajouter une nouvelle fonctionnalité ou un nouveau service. Nous nous efforcerons de limiter la fréquence et la durée de ces suspensions ou limitations.

				Nous ferons de notre mieux pour assurer la disponibilité des Services Amazon et que les transmissions se feront sans erreurs. Toutefois, du fait de la nature d'internet, ceci ne peut être garanti. De plus, votre accès aux Services Amazon peut occasionnellement être suspendu ou limité pour permettre des réparations, la maintenance, ou ajouter une nouvelle fonctionnalité ou un nouveau service. Nous nous efforcerons de limiter la fréquence et la durée de ces suspensions ou limitations.

				Dans le cadre de ses relations avec des professionnels, Amazon n'est pas responsable (i) des pertes qui n'ont pas été causées par une faute notre part, ou (ii) des pertes commerciales (y compris les pertes de profit, bénéfice, contrats, économies espérées, données, clientèle ou dépenses superflues), ou (iii) toute perte indirecte ou consécutive qui n'étaient pas prévisibles par vous et nous quand vous avez commencé à utiliser le Service Amazon.

				Nous ne serons pas tenus pour responsables des délais ou de votre impossibilité à respecter vos obligations en application de ces conditions si le délai ou l'impossibilité résulte d'une cause en dehors de notre contrôle raisonnable. Cette condition n'affecte pas votre droit légal de voir les produits envoyés et les services fournis dans un temps raisonnable ou de recevoir un remboursement si les produits ou les services commandés ne peuvent être délivrés dans un délai raisonnable en raison d'une cause hors de notre contrôle raisonnable.

				Les lois de certains pays ne permettent pas certaines des limitations énumérées ci-dessus. Si ces lois vous sont applicables, tout ou partie de ces limitations ne vous sont pas applicables, et vous pouvez disposer de droits supplémentaires.

				Rien dans ces conditions ne vise à limiter ou n'exclure notre responsabilité en cas de dol, ou en cas de décès ou de préjudice corporel causé(e) par notre négligence ou une faute lourde.

				Dans le cadre de ses relations avec des professionnels, Amazon n'est pas responsable (i) des pertes qui n'ont pas été causées par une faute notre part, ou (ii) des pertes commerciales (y compris les pertes de profit, bénéfice, contrats, économies espérées, données, clientèle ou dépenses superflues), ou (iii) toute perte indirecte ou consécutive qui n'étaient pas prévisibles par vous et nous quand vous avez commencé à utiliser le Service Amazon.

				Nous ne serons pas tenus pour responsables des délais ou de votre impossibilité à respecter vos obligations en application de ces conditions si le délai ou l'impossibilité résulte d'une cause en dehors de notre contrôle raisonnable. Cette condition n'affecte pas votre droit légal de voir les produits envoyés et les services fournis dans un temps raisonnable ou de recevoir un remboursement si les produits ou les services commandés ne peuvent être délivrés dans un délai raisonnable en raison d'une cause hors de notre contrôle raisonnable.

				Les lois de certains pays ne permettent pas certaines des limitations énumérées ci-dessus. Si ces lois vous sont applicables, tout ou partie de ces limitations ne vous sont pas applicables, et vous pouvez disposer de droits supplémentaires.

				Rien dans ces conditions ne vise à limiter ou n'exclure notre responsabilité en cas de dol, ou en cas de décès ou de préjudice corporel causé(e) par notre négligence ou une faute lourde.
				<br>
				14. DROIT APPLICABLE
				Les présentes Conditions d'utilisation sont soumises au droit luxembourgeois (à l'exception de ses dispositions concernant les conflits de loi), et l'application de la Convention de Vienne sur les contrats de vente internationale de marchandises est expressément exclue. Si vous êtes un consommateur et que votre résidence habituelle est située dans un pays de l'Union Européenne, vous bénéficiez également de droits vous protégeant en vertu des dispositions obligatoires de la loi applicable dans votre pays de résidence. Vous, comme nous, acceptons de soumettre tous les litiges occasionnés par la relation commerciale existant entre vous et nous à la compétence non exclusive des juridictions de la ville de Luxembourg, ce qui signifie que pour l'application des présentes Conditions d'utilisation, vous pouvez intenter une action pour faire valoir vos droits de consommateur, au Luxembourg ou dans le pays de l'Union Européenne dans lequel vous résidez. La Commission Européenne met à disposition une plateforme en ligne de résolution des différends à laquelle vous pouvez accéder ici: https://ec.europa.eu/consumers/odr/. Si vous souhaitez attirer notre attention sur un sujet, merci de nous contacter.
				<br>
				15. MODIFICATION DU SERVICE OU DES CONDITIONS D'UTILISATION

				Nous nous réservons le droit de faire des modifications sur tout Service Amazon, à nos procédures, à nos termes et conditions, y compris les présentes Conditions d'utilisation à tout moment. Vous êtes soumis aux termes et conditions, procédures et Conditions d'utilisation en vigueur au moment où vous utilisez le Service Amazon. Si une stipulation de ces Conditions d'utilisation est réputée non valide, nulle, ou inapplicable, quelle qu'en soit la raison, cette stipulation sera réputée divisible et n'affectera pas la validité et l'opposabilité des stipulations restantes.
				<br>
				16. RENONCIATION

				Si vous enfreignez ces Conditions d'utilisation et que nous ne prenons aucune action, nous serions toujours en droit d'utiliser nos droits et voies de recours dans toutes les autres situations où vous violeriez ces Conditions d'utilisation.
				<br>
				17. MINEURS

				Nous ne vendons pas de produits aux mineurs. Nous vendons des produits pour enfants pour des achats par des adultes. Si vous avez moins de 18 ans, vous ne pouvez utiliser un Service Amazon que sous la surveillance d'un parent ou d'un tuteur. Les offres de produits contenant de l'alcool sont destinées à des personnes majeures. Vous devez avoir au moins 18 ans pour acheter de l'alcool ou utiliser toute fonctionnalité du site concernant de l'alcool.
				<br>
				18. NOS COORDONNEES

				Le site internet Amazon.fr appartient à, et sa maintenance est effectuée par, Amazon Europe Core SARL. Des conditions spécifiques d'utilisation et de vente pour d'autres Services Amazon, par exemple le service Musique MP3 géré par Amazon Media EU SARL, peuvent être trouvées sur le site internet.

				Pour Amazon Europe Core SARL :
				<br>
				Amazon Europe Core SARL, Société à responsabilité limitée, 5 rue Plaetis, L-2338 Luxembourg
				Capital social : 37 500 €
				Enregistrée au Luxembourg
				RCS Luxembourg N° : B-101818
				Numéro de licence : 10040783
				Numéro de TVA intracommunautaire : LU 26375245

				Autres coordonnées :
				<br>
				Pour Amazon EU SARL :
				Amazon EU SARL, Société à responsabilité limitée, 5 rue Plaetis, L-2338 Luxembourg
				Capital social : 37 500 €
				Enregistrée au Luxembourg
				RCS Luxembourg N° : B-101818
				Numéro de licence : 104408
				Numéro de TVA intracommunautaire : LU 20260743
				<br>
				Succursale en France :
				Amazon EU SARL, succursale française, 67 Boulevard du General Leclerc, Clichy 92110, France
				Enregistrée en France
				Immatriculation au RCS, numéro : 487773327 R.C.S. Nanterre
				Numéro de TVA intracommunautaire : FR 12487773327
				<br>
				Pour Amazon Services Europe SARL :
				Amazon Services Europe SARL, Société à responsabilité limitée, 5 rue Plaetis, L-2338 Luxembourg
				Capital social : 37 500 €
				Enregistrée au Luxembourg
				RCS Luxembourg N°: B-93815
				Numéro de licence : 132595
				Numéro de TVA intracommunautaire : LU 19647148
				<br>
				Pour Amazon Media EU SARL :
				Amazon Media EU SARL, Société à responsabilité limitée, 5 rue Plaetis, L-2338 Luxembourg
				Capital social : 37 500 €
				Enregistrée au Luxembourg
				RCS Luxembourg N°: B-112767
				Numéro de licence : 136312
				Numéro de TVA intracommunautaire : LU 20944528
				<br><br>
				19. PROCEDURE ET FORMULAIRE DE NOTIFICATION DE VIOLATION DE DROITS

				Si vous pensez que vos droits ont été violés et que vous êtes éligible aux Registre des Marques, veuillez vous inscrire au service et soumettre votre plainte via le Registre des Marques. Sinon, merci d'utiliser notre Formulaire de Notification. Ce formulaire peut être utilisé pour nous soumettre toute sorte de plainte de propriété intellectuelle y compris, sans toutefois s'y limiter, les plaintes liées aux droits d'auteur, de marques, de dessins et modèles et de brevets. Dès réception d'un Formulaire de Notification, nous pouvons prendre certaines mesures, notamment la suppression d'informations ou d'un article et mettre fin aux infractions répétées dans des circonstances appropriées. Ces mesures seront toutefois prises sous toutes réserves, sans reconnaissance de notre part d'une responsabilité quelconque et sans préjudice de l'exercice de nos droits, actions et moyens de défense. Ceci comprend également le transfert de ce formulaire aux parties concernées par l'infraction alléguée. Vous acceptez d'indemniser Amazon contre toute réclamation de tiers contre Amazon, découlant de, ou dans le cadre de cette notification.

				Note concernant les offres des vendeurs tiers : merci de garder à l'esprit que les offres des vendeurs tiers sont seulement hébergées sur Amazon.fr et sont publiées uniquement sous la direction des vendeurs tiers qui peuvent être contactés par leur page « Informations sur le vendeur », accessible depuis toutes leurs offres.

				Définition d'ASIN et de ISBN-10 : « ASIN » signifie Amazon Standard Item (or Identification) Number (Numéro d'identification ou d'article standard d'Amazon) et est un identifiant composé de dix (10) caractères. Ce numéro figure dans toute fiche descriptive d'un produit sous le titre « Détails sur le produit ». « ISBN-10 » signifie International Standard Book Number (Numéro de livre standard international) et est un identifiant composé de dix (10) chiffres figurant sur certaines fiches descriptives de livres dans la catégorie « Détails sur le produit ».

				Avertissement important : fournir des informations inexactes, trompeuses ou fausses dans un Formulaire de Notification adressé à Amazon engage sa responsabilité civile et/ou pénale. En cas de doute, veuillez contacter un conseiller juridique..

				Formulaire de notification : Si vous souhaitez nous notifier la violation de vos droits en relation avec une offre de produit disponible sur le site www.amazon.fr, nous vous invitons à remplir le Formulaire de notification disponible en cliquant sur le lien ci-dessous :

				https://www.amazon.fr/gp/help/reports/infringement
				<br><br>
				20. PROCEDURE ET FORMULAIRE DE NOTIFICATION EN VUE DE NOTIFIER UN CONTENU INJURIEUX OU DIFFAMATOIRE

				Parce que des millions de produits sont listés et que des milliers de commentaires sont hébergés sur Amazon.fr, il ne nous est pas possible de connaître le contenu de tous les produits offerts à la vente, ou de tous les commentaires ou critiques qui sont affichés. En conséquence, nous opérons sous un système de « notice and action » soit « notifier et action ». Si vous pensez qu'un contenu ou une annonce de vente sur le site internet contient un message diffamatoire, merci de nous le notifier immédiatement en complétant la Procédure et Formulaire de notification en vue de notifier un contenu injurieux ou diffamatoire. Suivez les instructions dans la Notification.

				Avertissement important : fournir des informations inexactes, trompeuses ou fausses dans la Notification adressée à Amazon peut engager votre responsabilité civile et/ou pénale.

				La procédure de notification : Merci de nous envoyer le formulaire ci-dessous, dûment rempli et signé, à l'adresse suivante : Département juridique, NTD, Amazon EU S.à r.l., 5 rue Plaetis, L- 2338 Luxembourg, Grand Duché du Luxembourg.

				Formulaire de notification :
				<br><br>
				D E C L A R A T I O N

				Je soussigné,
				Nom et prénom : ____________________________________________________________________________
				Nom Société : ______________________________________________________________________________
				Adresse et Adresse e-mail : ___________________________________________________________________
				Numéro de téléphone (SUR LEQUEL VOUS POUVEZ ETRE JOINT DURANT LA JOURNEE) : ___________________________

				Déclare sur l'honneur ce qui suit :
				1. Je fais référence au site www.amazon.fr. Ce dernier affiche ou contribue à l'affichage de commentaires injurieux ou diffamatoires à mon sujet.

				2. Les propos injurieux ou diffamatoires (RAYEZ LE PARAGRAPHE INUTILE) :
				(a) apparaissent dans un livre vendu sur le site www.amazon.fr :
				<br><br>
				Titre du livre et auteur :______________________________________________________________
				Numéro ASIN (1) ou ISBN-13 (2) du livre : ____________________________________________________
				Numéro(s) de la (des) page(s) qui comporterai(en)t des propos diffamatoires : __________________________________________________________________________________

				(b) apparaissent sur le site www.amazon.fr à l'adresse suivante: _______________________ (ADRESSE EXACTE DE LA PAGE WEB)
				(b.1.) Les propos que je considère comme INJURIEUX sont les suivants (VEUILLEZ REPRODUIRE LES PROPOS EXACTS DONT VOUS VOUS PLAIGNEZ) :
				_________________________________________________________________________________________
				(b.2.) Ces propos sont injurieux car (VEUILLEZ EXPLIQUER LA RAISON POUR LAQUELLE VOUS CONSIDEREZ CES PROPOS COMME INJURIEUX) :
				_________________________________________________________________________________________
				(b.3.) Les propos que je considère commeDIFFAMATOIRES sont les suivants (VEUILLEZ REPRODUIRE LES PROPOS EXACTS DONT VOUS VOUS PLAIGNEZ) :
				_____________________________________________________________________________________
				(b.4.) Ces propos sont diffamatoires car (VEUILLEZ EXPLIQUER LA RAISON POUR LAQUELLE VOUS CONSIDEREZ CES PROPOS COMME DIFFAMATOIRES) :
				_____________________________________________________________________________________

				3. Je reconnais que la présente déclaration peut être produite au cours de toute procédure judiciaire découlant des, ou dans le cadre des, propos injurieux et diffamatoires contre lesquels je porte plainte.

				Déclaration de vérité
				Je déclare que les faits déclarés ci-dessus sont exacts.
				<br><br>
				Signature, Lieu, Date: _____________________________ __________________________________

				(1) « ASIN » signifie « Amazon Standard Item (or Identification) Number » (Numéro d'identification ou d'article standard d'Amazon) et représente un identifiant propre à Amazon.fr composé de dix (10) caractères. Ce numéro figure dans toute fiche descriptive d'un produit sous le titre « Détails sur le produit ».

				(2) « ISBN-10 » signifie « International Standard Book Number » (Numéro de livre standard international) et est un identifiant composé de dix (10) chiffres figurant sur certaines fiches descriptives de livres dans la catégorie « Détails sur le produit ».

				CONDITIONS ADDITIONNELLES DES LOGICIELS AMAZON
				<br><br>
				1. Utilisation des Logiciels Amazon.

				Vous pouvez utiliser les Logiciels Amazon aux seules fins de vous permettre d'utiliser et de profiter des Services Amazon tels que fournis par Amazon, et tels qu'autorisé par les Conditions d'utilisation, des présentes Conditions Logiciel Amazon, et des Conditions des Services. Il est interdit d'intégrer tout ou partie d'un Logiciel Amazon dans vos propres programmes, de compiler tout ou partie d'un Logiciel Amazon avec vos propres programmes, de transférer tout ou partie d'un Logiciel Amazon pour l'utiliser avec un autre service ou de vendre, louer, prêter, distribuer ou sous-licencier tout ou partie d'un Logiciel Amazon ou transférer un quelconque droit sur tout ou partie de ce Logiciel Amazon. Vous ne pouvez utiliser les Logiciels Amazon à des fins illégales. Nous nous réservons le droit de mettre fin à toute utilisation d'un Logiciel Amazon et de vous retirer les droits d'utilisation d'un Logiciel Amazon à tout moment. Si vous ne respectez pas les présentes Conditions Logiciel Amazon, les Conditions d'utilisation et toutes Conditions des Services Amazon, les droits d'utilisation d'un Logiciel Amazon qui vous sont accordés vous seront automatiquement retirés sans notification préalable. Des conditions supplémentaires définies par des tiers et contenues ou distribuées avec certains Logiciels Amazon et spécifiquement identifiées dans la documentation connexe peuvent être applicables à ces Logiciels Amazon (ou logiciels intégrés dans un Logiciel Amazon) et prévaudront en cas de conflit avec les présentes Conditions d'utilisation. Tout logiciel utilisé dans un quelconque Service Amazon est la propriété d'Amazon ou de ses fournisseurs de logiciels et est protégé par les lois luxembourgeoises et internationales sur la protection des programmes d'ordinateur et du copyright.
				<br><br>
				2. Utilisation de services tiers.

				Lorsque vous utilisez un Logiciel Amazon, vous pouvez également être amené à utiliser les services d'un ou plusieurs tiers, tels que ceux d'un opérateur mobile ou d'un fournisseur de plateforme mobile. L'utilisation de ces services tiers peut être soumise aux politiques, conditions d'utilisation et à des frais de ces tiers.
				<br><br>
				3. Interdiction d'ingénierie inverse.

				Vous ne pouvez et vous n'encouragerez pas, ni n'assisterez ou n'autoriserez qui que ce soit à (i) copier, modifier, altérer d'une autre façon un Logiciel Amazon en tout ou partie, créer des œuvres dérivées à partir ou du Logiciel Amazon ou (ii) effectuer de l'ingénierie inverse, décompiler ou désassembler un Logiciel Amazon en tout ou partie, sauf dans les limites autorisées par le loi.
				<br><br>
				4. Mises à jour.

				Afin de garder les Logiciels Amazon à jour, nous pouvons offrir des mises à jour automatiques ou manuelles à tout moment et sans notification préalable.
				CONDITIONS GENERALES DE VENTE
				<br><br>
				Bienvenue sur le site Amazon.fr.

				Amazon EU SARL et/ou ses sociétés affiliées (« Amazon ») vous fournissent des fonctionnalités de site internet et d'autres produits et services quand vous visitez ou achetez sur le site internet Amazon.fr (le « Site Internet »), utilisez des produits et services d'Amazon, utiliser des applications Amazon pour mobile, ou utiliser des logiciels fournis par Amazon dans le cadre de tout ce qui précède (ensemble ci-après, les « Services Amazon »). Amazon fournit les Services Amazon selon les conditions définies dans cette page.

				Ces Conditions Générales de Vente régissent la vente de produits entre Amazon EU SARL et vous. Pour les conditions relatives à la vente entre vous et des vendeurs tiers sur le Site Internet Amazon.fr, veuillez prendre connaissance du Contrat de Participation. Nous offrons un large panel de Services Amazon et il se peut que des conditions additionnelles s'appliquent. Par ailleurs, lorsque vous utilisez un Service Amazon (par exemple votre Profil, les Chèques-Cadeaux, les applications pour mobile ou le Gestionnaire de communication), vous êtes également soumis aux termes, lignes directrices et conditions applicables à ce Service Amazon (les « Conditions du Service »). Si ces Conditions Générales de Ventes entrent en contradiction avec les Conditions du Service, les Conditions du Service prévaudront.

				Merci de lire ces conditions attentivement avant d'effectuer une commande avec Amazon EU SARL. En commandant avec Amazon EU SARL, vous nous notifiez votre accord d'être soumis aux présentes conditions.
				<br><br>
				1. COMMENT COMMANDER

				Si vous souhaitez acheter un ou plusieurs produit(s) figurant sur le Site Internet, vous devez sélectionner chaque produit que vous souhaitez acheter et l'ajouter à votre panier. Lorsque vous avez sélectionné tous les produits que vous voulez acheter, vous pouvez confirmer le contenu de votre panier et passer la commande.

				A ce stade, vous serez redirigé vers une page récapitulant les détails des produits que vous avez sélectionnés, leur prix et les options de livraisons (avec les frais de livraison concernés). Vous devrez alors choisir les options de livraison ainsi que les méthodes d'envoi et de paiement qui vous conviennent le mieux.

				En haut de cette page, se situe le bouton d'achat. Vous devez cliquer sur ce bouton pour confirmer et passer votre commande.

				Après avoir passé votre commande, nous vous adressons un message de confirmation. Si vous utilisez certains Services Amazon (tels que les Applications Amazon pour mobile), le message de confirmation pourra être envoyé via le Gestionnaire de communication sur le site. Nous vous informons de l'envoi de vos articles. Vous avez néanmoins la possibilité de modifier votre commande jusqu'à la date d'envoi de vos articles.

				Veuillez noter que nous vendons des produits seulement en quantités correspondant aux besoins moyens habituels d'un foyer. Ceci s'applique aussi bien au nombre de produits commandés dans une seule commande qu'au nombre de commandes individuelles respectant la quantité habituelle d'un foyer normal passées pour le même produit. Amazon ne vend pas aux bibliothèques de prêt.

				Vous acceptez d'obtenir les factures de vos achats par voie électronique. Les factures électroniques seront mises à votre disposition au format .pdf dans l'espace Votre compte sur notre Site Internet. Pour chaque livraison, nous vous indiquerons dans le message de confirmation d'envoi si une facture électronique est disponible. Pour plus d'informations sur les factures électroniques et pour savoir comment recevoir une copie papier, merci de consulter nos pages d'Aide.

				2. DROIT DE RETENTION

				Les produits livrés restent la propriété d'Amazon jusqu'à leur remise au transporteur.
				<br><br>
				3. DROIT DE RETRACTATION DE 14 JOURS, EXCEPTIONS AU DROIT DE RETRACTATION, NOTRE POLITIQUE DE RETOURS SOUS 30 JOURS

				DROIT LEGAL DE RETRACTATION

				A moins que l'une des exceptions listées ci-dessous ne soit applicable, vous pouvez vous rétracter de votre commande sans donner de motif dans un délai de 14 jours courant à compter de la date à laquelle vous-même, ou un tiers désigné par vous (autre que le transporteur), a pris physiquement possession des biens achetés (ou du dernier bien, lot ou pièce si le contrat porte sur la livraison de plusieurs biens ou plusieurs lots ou pièces livrés séparément) ou de la date à laquelle vous avez conclu le contrat pour les prestations de services.

				Vous devez nous notifier (Amazon EU Sarl, 5 rue Plaetis, L.-2338 Luxembourg) votre décision de vous rétracter de votre commande. Vous pouvez soumettre votre demande en ligne conformément aux instructions et formulaires disponibles auprès de notre centre de retours en ligne, en utilisant ce formulaire, ou par courrier. Dans le cas où vous utiliseriez le Centre de retours en ligne, nous vous enverrons un accusé de réception.

				Pour respecter la date limite de rétractation, il vous suffit d'envoyer votre demande de rétractation avant que le délai de 14 jours n'expire et de renvoyer votre produit par le biais de notre centre de retours en ligne.

				Pour toute information complémentaire sur l'étendue, le contenu et les instructions quant à l'exercice de votre droit de rétractation, merci de contacter notre Service Client.

				EFFETS DE LA RETRACTATION

				Nous vous rembourserons tous les paiements que nous avons reçus de votre part, y compris les frais de livraison standards (c'est-à-dire correspondant à la livraison la moins onéreuse que nous proposons) au plus tard 14 jours à compter de la réception de votre demande de rétractation. Nous utiliserons le même moyen de paiement que celui que vous avez utilisé lors de votre commande initiale, sauf si vous convenez expressément d'un moyen différent. En tout état de cause, ce remboursement n'occasionnera pas de frais supplémentaires pour vous. Nous pouvons différer le remboursement jusqu'à ce que nous ayons reçu le(s) produit(s) ou jusqu'à ce que vous ayez fourni une preuve d'expédition du (des) produit(s), la date retenue étant celle du premier de ces faits. Si le remboursement intervient après la date limite mentionnée ci-dessus, le montant qui vous est dû sera augmenté de plein droit.

				Veuillez noter que vous devez renvoyer le(s) produit(s) en suivant les instructions disponibles sur notre centre de retours en ligne au plus tard 14 jours à compter de la date à laquelle vous nous avez notifié votre décision de rétractation.

				Vous devez prendre à votre charge les frais directs de renvoi du (des) produit(s). Vous serez responsable de la dépréciation de la valeur du(s) produit(s) résultant de manipulations (autres que celles nécessaires pour établir la nature, les caractéristiques et le bon fonctionnement de ce(s) produit(s))
				<br><br>
				EXCEPTIONS AU DROIT DE RETRACTATION

				Le droit de rétractation ne s'applique pas à :
				la livraison de produits qui ne peuvent pas être retournés pour des raisons d'hygiène ou de protection de la santé, si vous les avez descellés ou bien, qui ont, après avoir été livrés, été mélangés de manière indissociables avec d'autres articles ;
				la livraison d'enregistrements audio ou vidéos ou de logiciels informatiques lorsque vous les avez descellés après la livraison ;
				la livraison de produits qui ont été confectionnés selon vos spécifications ou nettement personnalisés ;
				la fourniture de produits susceptibles de se détériorer ou de se périmer rapidement ;
				la fourniture de services pleinement exécutés par Amazon pour lesquels vous avez accepté au moment de la passation de votre commande que nous commencions leur exécution, et renoncé à votre droit de rétractation ;
				la fourniture de journaux, périodiques ou magazines à l'exception des contrats d'abonnement à ces publications ; et
				la fourniture de boissons alcoolisées dont la valeur convenue à la conclusion du contrat dépend de fluctuation sur le marché échappant à notre contrôle.

				NOTRE POLITIQUE DE RETOURS SOUS 30 JOURS

				Sans préjudice des droits qui vous sont reconnus par la loi, Amazon vous propose la politique de retours suivante :

				Tous les produits en provenance des sites d'Amazon peuvent être retournés dans les 30 jours suivant la réception des produits si les produits sont complets et dans un état neuf et intact. S'agissant des supports de données emballés sous plastique ou scellés (par exemple, les CDs, cassettes audio, vidéos VHS, DVD, jeux PC, jeux vidéo et logiciels, articles de la boutique Hygiène, Beauté et Santé Animale), nous ne les reprendrons que s'ils sont toujours dans leur emballage plastique ou qu'ils n'ont pas été descellés. Les produits doivent être retournés par le biais de notre Centre de retours en ligne. Cette politique de retours n'est pas applicable aux contenus numériques ou logiciels informatiques qui ne sont pas fournis sur un support matériel (ex : sur un CD ou un DVD).

				Si vous renvoyez un (des) produit(s) conformément à notre politique de retour, nous vous rembourserons le prix que vous avez payé mais pas les frais de livraison de votre achat initial. De même, les risques liés au transport et les frais de livraison de retour seront à votre charge. Les frais de livraison et de retour ne sont remboursés que pour les vêtements et les chaussures achetés sur l'un de nos sites. Cette politique de retours n'affecte pas vos droits reconnus par la loi, y compris votre droit légal de rétractation décrit ci-dessus.

				Plus de détails sur notre politique de retours sont disponibles ici.

				Vous bénéficiez par ailleurs des garanties légales de conformité et des vices cachés mentionnées à l'article 7 des présentes Conditions Générales de Vente (« Notre responsabilité Garanties »).
				<br><br>
				4. PRIX ET DISPONIBILITE

				Tous les prix sont toutes taxes françaises comprises (TVA française et autres taxes applicables) sauf indication contraire.

				Tous les prix sont toutes taxes françaises comprises (TVA française et autres taxes applicables) sauf indication contraire.

				Nous affichons la disponibilité des produits que nous vendons sur le Site Internet sur chaque fiche produit. Nous ne pouvons apporter plus de précision concernant la disponibilité des produits que ce qui est indiqué sur ladite page ou ailleurs sur le Site Internet. Lors du traitement de votre commande, nous vous informerons dès que possible par courrier électronique en utilisant l'adresse associée à votre abonnement ou via le Gestionnaire de communication dans Votre compte, si des produits que vous avez commandés s'avèrent être indisponibles, et nous ne vous facturerons pas ces produits.

				En dépit de tous nos efforts, un petit nombre des produits présents dans notre catalogue peuvent afficher une erreur sur le prix. Nous vérifierons le prix au moment du traitement de votre commande et avant tout paiement. S'il s'avérait que nous avons fait une erreur sur l'affichage du prix, et que le prix réel est supérieur au prix affiché sur le Site Internet, nous pouvons vous contacter pour vous demander si vous souhaitez acheter le produit à son prix réel ou si vous préférez annuler votre commande. Si le prix réel est inférieur au prix affiché, nous vous facturerons le montant le plus bas et nous vous enverrons le produit.
				<br><br>
				5. DOUANES

				Lorsque vous commandez des produits sur Amazon pour être livrés en dehors de l'Union Européenne, vous pouvez être soumis à des obligations et des taxes sur l'importation, qui sont perçues lorsque le colis arrive à destination. Tout frais supplémentaire de dédouanement sera à votre charge ; nous n'avons aucun contrôle sur ces frais. Les politiques douanières varient fortement d'un pays à l'autre, vous devez donc contacter le service local des douanes pour plus d'informations. Par ailleurs, veuillez noter que lorsque vous passez commande sur Amazon, vous êtes considéré comme l'importateur officiel et devez respecter toutes les lois et règlements du pays dans lequel vous recevez les produits. La protection de votre vie privée est importante pour nous et nous attirons l'attention de nos clients internationaux sur le fait que les livraisons transfrontalières sont susceptibles d'être ouvertes et inspectées par les autorités douanières. Pour plus d'informations, consultez la page Informations douanières.
				<br><br>
				6. COMMANDE 1-CLICK

				Vous bénéficiez de la garantie légale de conformité dans les conditions des articles L.217-4 et suivants du code de la consommation et de la garantie des vices cachés dans les conditions prévues aux articles 1641 et suivants du code civil. Pour plus d'informations sur ces garanties, rendez-vous sur la page désactiver la commande 1-Click quand vous n'êtes pas devant l'ordinateur.
				<br><br>
				7. NOTRE RESPONSABILITE - GARANTIES

				Vous bénéficiez de la garantie légale de conformité dans les conditions des articles L.217-4 et suivants du code de la consommation et de la garantie des vices cachés dans les conditions prévues aux articles 1641 et suivants du code civil. Pour plus d'informations sur ces garanties, rendez-vous ici.

				Lorsque vous agissez en garantie légale de conformité,

				vous bénéficiez d'un délai de deux ans à compter de la délivrance du bien pour agir ;
				vous pouvez choisir entre la réparation ou le remplacement du bien, sous réserve des conditions de coût prévues par l'article L.217-9 du code de la consommation ;
				pour tout produit acheté jusqu'au 17 mars 2016 à 23:59:59, vous êtes dispensés de rapporter la preuve de l'existence du défaut de conformité du bien durant les six (6) mois suivant la délivrance du bien ;
				pour tout produit acheté à partir du 18 mars 2016 à minuit, vous êtes dispensés de rapporter la preuve de l'existence du défaut de conformité du bien durant les vingt-quatre (24) mois suivant la délivrance du bien, sauf pour les biens d'occasion pour lesquels vous êtes dispensés de rapporter la preuve de l'existence du défaut de conformité du bien seulement durant les six (6) mois suivant la délivrance du bien.
				<br><br>
				La garantie légale de conformité s'applique indépendamment de la garantie commerciale éventuellement consentie.

				Vous pouvez décider de mettre en œuvre la garantie des vices cachés au sens de l'article 1641 du code civil. Dans cette hypothèse, vous pouvez choisir entre la résolution de la vente ou une réduction du prix de vente (article 1644 du code civil).

				Les produits audio, vidéo et multimédia peuvent donner droit à la garantie du fabricant indiquée sur la fiche détaillée du produit. Si le produit devient défectueux pendant la période de la garantie du fabricant, vous pouvez consulter le service après-vente du fabricant.

				A l'exception des livraisons en France et au Luxembourg, nous déclinons toute responsabilité dans l'hypothèse où l'article livré ne respecterait pas la législation du pays de livraison.

				Nous nous engageons à apporter tous les soins en usage dans la profession pour la mise en œuvre du service offert au client. Néanmoins, notre responsabilité ne pourra pas être retenue en cas de retard ou de manquement à nos obligations contractuelles si le retard ou manquement est dû à une cause en dehors de notre contrôle : cas fortuit ou cas de force majeure tel que défini par la loi applicable.

				Notre responsabilité ne sera pas engagée en cas de retard dû à une rupture de stock chez l'éditeur ou chez le fournisseur. En outre, notre responsabilité ne sera pas engagée en cas de différences mineures entre les photos de présentation des articles et les textes affichés sur le Site Internet Amazon.fr, et les produits livrés.

				Nous mettons en œuvre tous les moyens dont nous disposons pour assurer les prestations objets des présentes Conditions Générales de Vente. Nous sommes responsables de tout dommage direct et prévisible au moment de l'utilisation du Site Internet ou de la conclusion du contrat de vente entre nous et vous. Dans le cadre de nos relations avec des professionnels, nous n'encourrons aucune responsabilité pour les pertes de bénéfices, pertes commerciales, pertes de données ou manque à gagner ou tout autre dommage indirect ou qui n'était pas prévisible au moment de l'utilisation du Site Internet ou de la conclusion du contrat de vente entre nous et vous.

				La limitation de responsabilité visée ci-dessus est inapplicable en cas de dol ou de faute lourde de notre part, en cas de dommages corporels ou de responsabilité du fait des produits défectueux, en cas d'éviction et en cas de non-conformité (y compris en raison de vices cachés).
				<br><br>
				8. DROIT APPLICABLE <br>

				Les présentes Conditions d'utilisation sont soumises au droit luxembourgeois (à l'exception de ses dispositions concernant les conflits de loi), et l'application de la Convention de Vienne sur les contrats de vente internationale de marchandises est expressément exclue. Vous, comme nous, acceptons de soumettre tous les litiges occasionnés par la relation commerciale existant entre vous et nous à la compétence non exclusive des juridictions de la ville de Luxembourg, ce qui signifie que pour l'application des présentes Conditions Générales de Vente, vous pouvez intenter une action pour faire valoir vos droits de consommateur, au Luxembourg ou dans le pays de l'Union Européenne dans lequel vous résidez. Si vous êtes un consommateur et que votre résidence habituelle est située dans un pays de l'Union Européenne, vous bénéficier également de droits vous protégeant en vertu des dispositions obligatoires de la loi applicable dans votre pays de résidence.

				Notre entreprise adhère à la Fédération du e-commerce et de la vente à distance (FEVAD) et au service de médiation du e-commerce (60 rue la Boétie, 75008 Paris) – relationconso@fevad.com.

				La Commission Européenne met à disposition une plateforme en ligne de résolution des différends à laquelle vous pouvez accéder ici: https://ec.europa.eu/consumers/odr/. Si vous souhaitez attirer notre attention sur un sujet, merci de nous contacter.
				<br><br>
				9. MODIFICATION DU SERVICE OU DES CONDITIONS GENERALES DE VENTE

				Nous nous réservons le droit de faire des changements à notre Site Internet, nos procédures, et à nos termes et conditions, y compris les présentes Conditions Générales de Vente à tout moment. Vous êtes soumis aux termes et conditions, procédures et Conditions Générales de Vente en vigueur au moment où vous nous commandez un produit, sauf si un changement à ces termes et conditions, ou les présentes Conditions Générales de Vente est exigé par une autorité administrative ou gouvernementale (dans ce cas, cette modification peut s'appliquer aux commandes antérieures que vous avez effectuées). Si l'une des stipulations de ces Conditions Générales de Vente est réputée non valide, nulle ou inapplicable, quelle qu'en soit la raison, cette stipulation sera réputée divisible et n'affectera pas la validité et l'effectivité des stipulations restantes.
				<br><br>
				10. RENONCIATION

				Si vous enfreignez ces Conditions Générales de Vente et que nous ne prenons aucune action, nous serions toujours en droit d'utiliser nos droits et voies de recours dans toutes les autres situations où vous violeriez ces Conditions Générale de Vente.
				<br><br>
				11. MINEURS

				Nous ne vendons pas de produits aux mineurs. Nous vendons des produits pour enfants pour des achats par des adultes. Si vous avez moins de 18 ans, vous ne pouvez utiliser le Site Internet Amazon.fr que sous la surveillance d'un parent ou d'un tuteur.
				<br><br>
				12. IDENTIFICATION

				Amazon.fr est une marque commerciale utilisée par Amazon EU SARL. Nos informations de contact sont les suivantes :

				Amazon EU SARL, Société à responsabilité limitée, 5 rue Plaetis, L-2338 Luxembourg
				Capital social : 37 500 €
				Enregistrée au Luxembourg
				RCS Luxembourg N° : B-101818
				Numéro de licence : 134248
				Numéro de TVA intracommunautaire : LU 20260743
				<br><br>
				Succursale en France :
				Amazon EU SARL, succursale française, 67 Boulevard du General Leclerc, Clichy 92110, France
				Enregistrée en France
				Immatriculation au RCS, numéro : 487773327 R.C.S. Nanterre
				Numéro de TVA intracommunautaire : FR 12487773327

				Liste non exhaustive des marques déposées Amazon :1-CLIC, 1-CLICK, 1-CLICK COMPARE, 1° SOUTH, 1° SOUTH Design, 6PM, 6 Design, 43 PLACES, 43 THINGS, a Design, A9, ABE, ABEBOOKS, ADMASH, AMAZON ADMASH Design,, ADZINIA, ALEXA, ALL CONSUMING, AMAPEDIA, AMAZON, AMAZON Design, AMAZON.CA, AMAZON.CO.JP, AMAZON.CO.UK, AMAZON.DE, AMAZON.ES, AMAZON.FR, AMAZON.IT, AMAZON.ES, AMAZON ANYWHERE, AMAZON BASICS Design, AMAZON BOOKCLIPS PODCAST Design, AMAZON.COM, AMAZON.COM Design, AMAZON.COM ANYWHERE, AMAZONASSIST, AMAZON CLOUDFRONT, AMAZONCONNECT, AMAZONCROSSING, AMAZON CURRENCY CONVERTER, AMAZON DEVPAY, AMAZON EC2, AMAZONENCORE, AMAZONENCORE Design, AMAZONFRESH, AMAZONFRESH Design, AMAZON.FR AND YOU'RE DONE & Design, AMAZON FRUSTRATION-FREE, AMAZON HONOR SYSTEM, AMAZONKINDLE, AMAZONKINDLE COMPATIBLE Design, AMAZONKINDLE Design, AMAZON LINKS (Guitar Design), AMAZON MOBILE SHOPPING CART Logo, AMAZONMP3 Design, AMAZON PREMIUM, AMAZON PRIME, AMAZON SILK, AMAZONTOTE Design, AMAZONUNBOX Design, AMAZON VINE, AMAZON VPC, AMAZON WEB SERVICES Design, AMAZONWINDOWSHOP Design, AMAZON WIRE PODCAST Design, AMI ST Design, AMI DANS LA RUE, AMZN, AND YOU'RE DONE, ARTIFICIAL, ASKVILLE, ASSOCIATES CENTRAL, ASTORE Design, AUDIBLE, AUDIBLELISTENER, AUDILBLEORIGINALS, AUDIBLEREADY, AUDIBLE.COM, AUDIBLE.CO.UK, AUDIBLE.DE, AUDIBLE.FR, AUDIBLE Design, AUDJIE, AWS, BAG O'CRAP, BETTER TOGETHER, BID-CLICK, BONES OF THE BOOK, BOP, BOP BASICS, BOTTOM OF THE PAGE, BOUQUETS, BRIGITTE BAILEY, BUY ONCE, READ EVERYWHERE, BUYPHRASE, BUYVIP, BUY V!P Design, CERTIFIED FRUSTRATION-FREE PACKAGING, CHERCHER AU COEUR!, CHRISTIN MICHAELS, CLICK.HEAR, CLICKRIVER, CLOUDFRONT, CREATESPACE, CREATESPACE Design, CRITICALMASS TICKETING, CROSSLINKS, DEALS.WOOT!, DENALI, DON'T RESTRICT ME, DPREVIEW, DPREVIEW Design, DROP SHIP CENTRAL, EAMAZON, EARTH'S BIGGEST, EARTH'S BIGGEST SELECTION, EC2, EGGHEAD, EAMAZON,ELASTIC COMPUTE CLOUD, ENDLESS, EVERY DEVICE HAS AT LEAST ONE SMALL PART, FIRE, FBA, FLASHING LIGHTS Design, FULFILLMENT BY AMAZON, FILMFINDERS, FITZWELL, GABRIELLA ROCHA, GAME CIRCLE, GOLD BOX, GOOD AT FINDING GOODS, HABIT, H Design, HABIT Design, HOLITUDE, IMDB, IMPROVE YOUR HOLITUDE, JAVARI, JUNGLEE, KINDLE, KINDLE Design, KINDLE FIRE, KINDLE SINGLES, LE COMITE DES MAMANS, LIGHTNING DEALS, LISTMANIA, LOOK INSIDE! Design, LOVEFILM, LOVEFILM Design, LUMIANI, MECHANICAL TURK, MOBIPOCKET Design, MOOFI, MTURK, MES Z'ENVIVES, MYHABIT, NEW FOR YOU, NOWNOW, OMAKASE, OMNIVORACIOUS, ONE COMMUNITY, EVERY DEAL, PAYPAGE, PAYPHRASE, PINZON, POINTING DEVICES, PRIME, PROMISCUOUS, PURCHASE CIRCLES, QUESTVILLE, READERS, ROMANTIC SOLES, RSVP, SEARCH INSIDE THE BOOK, SEARCH INSIDE!, SELLER CENTRAL, SHARE THE LOVE, SHELFARI, SHIRT.WOOT!, SHOPBOP, SMILE DESIGN, SNAPTELL, SNAP TO LISTEN Design, SO YOU'D LIKE TO, SOUNDUNWOUND, STANZA, STARMETER, STATE & LAKE, STRATHWOOD, SUBSCRIBE & SAVE, TAKE-IT PRICE, TEXTBUYME, TEXTPAYME, THE BOOK LIVES ON, THE SIGNIFICANT SEVEN, THING, TYPE Z, UNBOX, UNIVERSIAL WISHLIST Design, VENDOR CENTRAL EUROPE, VIGOTTI, WAG.COM, WE LOVE BRANDS Design, WHISPERCACHE, WHISPERLINK, WHISPERNET, WHISPERSHARE, WHISPERSYNC, WITHOUTABOX, WOOT!, WOOT-OFF!, WRAP YOUR HOLIDAYS IN A SMILE, WISHLIST Design, WWW.LOVEFILM.COM, WWW.LOVEFILM.CO.UK, XRAY, ZAPPOS, ZSHOPS et les autres marques indiquées sur notre site sont des marques commerciales ou des marques déposées de Amazon.com, Inc ou de ses filiales (collectivement "Amazon"), dans l'Union européenne et / ou d'autres juridictions. Les graphiques, logos, en-têtes de page, boutons, scripts et noms de service d'Amazon.fr sont des marques ou visuels d'Amazon. Les marques et visuels d'Amazon ne peuvent pas être utilisées pour des produits ou services qui n'appartiennent pas à Amazon d'une manière susceptible de provoquer la confusion parmi les clients, ou de toutes autres manières dépréciant, dénigrant ou discréditant Amazon. Toutes les autres marques qui n'appartiennent pas à Amazon et qui apparaissent sur ce site sont la propriété de leurs propriétaires respectifs, qui peuvent ou non être affiliés, liés ou parrainés par Amazon. Révisé le 10 avril 2012
				<br><br>
				Liste non exhaustive des brevets Amazon ou affiliés et des brevets sous licence applicables:

				Un ou plusieurs brevets détenus par Amazon ou ses sociétés affiliées s'appliquent à ce site et aux fonctionnalités et services accessibles via ce site.Numéros de brevets des Etats-Unis:5,715,399; 5,727,163; 5,826,258; 5,960,411; 5,963,949; 5,999,924; 6,003,024; 6,006,225; 6,029,141; 6,064,980; 6,144,958; 6,169,986; 6,175,823; 6,185,558; 6,185,556; 6,199,079; 6,233,573; 6,266,649; 6,269,369; 6,317,722; 6,324,535; 6,360,254; 6,366,910; 6,401,084; 6,427,175; 6,442,543; 6,449,601; 6,460,038; 6,466,918; 6,489,968; 6,525,747; 6,539,378; 6,546,393; 6,549,904; 6,564,213; 6,571,243; 6,594,644; 6,606,619; 6,606,608; 6,615,226; 6,625,609; 6,629,079; 6,643,624; 6,675,196; 6,714,926; 6,714,916; 6,760,470; 6,772,150; 6,785,671; 6,851,089; 6,853,993; 6,853,982; 6,865,546; 6,882,981; 6,889,250; 6,907,315; 6,912,505; 6,917,922; 6,941,374; 6,952,715; 6,963,867; 6,963,848; 6,963,850; 6,973,429; 6,999,941; 7,006,989; 7,050,992; 7,058,599; 7,080,124; 7,080,070; 7,082,407; 7,107,227; 7,113,917; 7,117,167; 7,124,129; 7,130,820; 7,139,771; 7,149,353; 7,155,336; 7,174,054; 7,194,419; 7,194,437; 7,210,102; 7,216,103; 7,222,087; 7,246,308; et 7,254,552.Des parties de ce site opèrent sous licence des numéros de brevets des Etats-Unis:5,708,780; 5,715,314; 5,909,492; 6,205,437; 6,195,649; 5,717,860; 5,712,979; 5,819,285; 6,782,370; 5,812,769; 5,528,490; 5,761,649; 6,029,142; et 6,330,592.Révisé le 21 janvier 2011.
				<br><br>
				Ces informations ont-elles été utiles ?
				Oui
				Non
				‹ Toutes les rubriques d'aide
				Politiques et informations légales

				CONDITIONS D'UTILISATION ET GENERALES DE VENTE
				Protection de vos informations personnelles
				Politique d'Amazon en matière de lutte contre les produits contrefaits
				A propos des navigateurs compatibles
				Identifier si un e-mail, appel téléphonique ou SMS proviennent d'Amazon
				Annonces basées sur vos centres d'intérêt
				Normes applicables à la chaîne logistique
				Systèmes de protection de la vie privée
				A propos des informations recueillies par Amazon
				<br><br>
				Solutions rapides

				Vos commandes

				Gérer vos commandes

				Retours et remboursements

				Retourner ou échanger des articles

				Nos transporteurs

				Informations transporteurs

				Amazon Prime

				Annuler ou consulter les avantages

				Paramètres de paiement

				Ajouter ou modifier un moyen de paiement

				Paramètres du compte

				Modifier votre e-mail ou mot de passe
				Retour en haut
				Pour mieux nous connaître

				À propos d'Amazon
				Carrières
				Amazon et notre planète
				<br><br>
				Gagnez de l'argent

				Vendez sur Amazon
				Vendre sous Amazon Accelerator
				Vendez sur Amazon Business
				Vendez sur Amazon Handmade
				Devenez Partenaire
				Expédié par Amazon
				Faites la promotion de vos produits
				Auto-publiez votre livre
				Amazon Pay
				›Tous nos programmes
				<br><br>
				Moyens de paiement Amazon

				Cartes de paiement
				Paiement en plusieurs fois
				Amazon Currency Converter
				Chèques-cadeaux
				Recharge en ligne
				Recharge en point de vente
				<br><br>
				Besoin d'aide ?

				Voir ou suivre vos commandes
				Tarifs et options de livraison
				Amazon Prime
				Retours et remplacements
				Infos sur notre Marketplace
				Application Amazon Mobile
				Amazon Assistant
				Service Client

				AustralieAllemagneBrésilCanadaChineEspagneÉtats-UnisIndeItalieJaponMexiquePays-BasRoyaume-UniÉmirats arabes unisSingapourTurquie
				<br><br>
				Amazon Music
				Écoutez des millions
				de chansons 		AbeBooks
				Livres, art
				& articles de collection 		Amazon Web Services
				Services de Cloud
				Computing Flexibles 		Audible
				Livres audio
				télécharger 		Book Depository
				Livres expédiés
				dans le monde entier 		Kindle Direct Publishing
				Auto-publiez facilement
				vos livres au format numérique

				Offres Reconditionnées
				Bonnes affaires 		Prime Now
				Livraison en 1 heure
				sur des milliers de produits 		Shopbop
				Vêtements de Marque
				& Mode 		Amazon Advertising
				Ciblez, attirez et
				fidélisez vos clients 		Amazon Business
				Paiement 30 jours. Hors TVA.
				Pour les professionnels. 		Amazon Second Chance
				Transmettez, échangez,
				donnez une seconde vie à vos objets

				Conditions générales de venteVos informations personnellesCookiesAnnonces basées sur vos centres d’intérêt

				© 1996-2020, Amazon.com, Inc. ou ses filiales.

			</div>
			<form action="devenir_vendeur.php" method="post">
				<div style="margin-top: 30px;">
					<?php $test=$_SESSION['user_Role']; if ($test !=3) { ?>
						<p><label> Accepter les conditions d'utilisation :  </label><input type="checkbox" name="devenir" id="devenir" required=""></p>
						<input class="btn btn-primary btn-block is-invalid" type="submit" value="Devenir un vendeur !" /><br> <?php }  ?> 
					</div>
				</form>
			</div>
		</div>
		<!-- Footer -->	
		<?php include("footer.php") ?>
	</body>
	</html>