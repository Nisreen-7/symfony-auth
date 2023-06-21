## Créer un User et une inscription :


	
Dans le dossier Entity, créer une classe User avec un id, un email et un password et des getter setters ainsi qu'un constructeur
	
Faire que le User implémente les interfaces UserInterface et PasswordAuthenticatedUserInterface et toutes leurs méthodes (le getUserIdentifier devra renvoyer l'email, le eraseCredentials ne fera rien et le getRoles renverra ['ROLE_USER'] )
	
Copier/coller le Database.php puis créer un UserRepository qui contiendra uniquement une méthode persist (classique, elle fera exactement comme les autres persists qu'on a déjà fait) et un findByEmail qui renverra un ?User en se basant sur l'email (tout pareil qu'un findById, mais avec l'email)
	
Créer un AuthController avec dedans une route "/register" et un template qui va afficher un formulaire avec un champ email, un champ password et un champ repeatPassword
	
On fait le traitement du formulaire comme on l'a déjà fait pour le CourseController, mais avant de faire persister on va commencer par vérifier avec le findByEmail s'il n'y a pas déjà un user qui existe avec cet email, sinon on affiche un message d'erreur, et si le password correspond au repeatPassword (il ne servira qu'à ça, on ne le fait pas persister), sinon pareil message d'erreur
	
Dans les arguments de la route, on rajoute un paramètre de type UserPasswordHahserInterface et on utilise sa méthode hashPassword pour obtenir un hash à partir du mot de passe passé dans le formulaire. On setPassword ce hash et on fait persister
	
Inscription terminée, on peut vérifier si dans la bdd ça stock bien le user avec un mot de passe hashé