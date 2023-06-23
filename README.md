# Symfony Auth

## Projet symfony avec de l'authentification

    Cloner le projet
    Lancer composer install
    Créer une base de données et importer le database.sql dedans
    Lancer le serveur avec symfony server:start

Authentification étapes

Etapes qui sont à priori valable quelque soit le framework, dans le cas d'une connexion avec mot de passe et hashing
Inscription

    On vérifie si un user existe déjà en base de données avec le username/email/identifiant donné
    Si non, on hash le mot de passe avec un algorithme, du sel et du poivre
    On stock en base de données le user avec son identifiant et son mot de passe hashé et son sel

Connexion

    Le user envoie vers le backend son identifiant et son mot de passe en clair
    On récupère le user correspondant à l'identifiant donné (s'il existe, sinon, erreur de connexion)
    On prend le mot de passe et on récupère le sel dedans
    On hash le mot de passe en clair envoyé au moment du login avec le sel et le poivre stockés
    On compare les 2 hash pour voir s'ils correspondent
    Si oui, connexion réussi, on crée une session utilisateur pour l'identifiant donné




## Créer un User et une inscription :

Dans le dossier Entity, créer une classe User avec un id, un email et un password et des getter setters ainsi qu'un constructeur
	
Faire que le User implémente les interfaces UserInterface et PasswordAuthenticatedUserInterface et toutes leurs méthodes (le getUserIdentifier devra renvoyer l'email, le eraseCredentials ne fera rien et le getRoles renverra ['ROLE_USER'] )
	
Copier/coller le Database.php puis créer un UserRepository qui contiendra uniquement une méthode persist (classique, elle fera exactement comme les autres persists qu'on a déjà fait) et un findByEmail qui renverra un ?User en se basant sur l'email (tout pareil qu'un findById, mais avec l'email)
	
Créer un AuthController avec dedans une route "/register" et un template qui va afficher un formulaire avec un champ email, un champ password et un champ repeatPassword
	
On fait le traitement du formulaire comme on l'a déjà fait pour le CourseController, mais avant de faire persister on va commencer par vérifier avec le findByEmail s'il n'y a pas déjà un user qui existe avec cet email, sinon on affiche un message d'erreur, et si le password correspond au repeatPassword (il ne servira qu'à ça, on ne le fait pas persister), sinon pareil message d'erreur
	
Dans les arguments de la route, on rajoute un paramètre de type UserPasswordHahserInterface et on utilise sa méthode hashPassword pour obtenir un hash à partir du mot de passe passé dans le formulaire. On setPassword ce hash et on fait persister
	
Inscription terminée, on peut vérifier si dans la bdd ça stock bien le user avec un mot de passe hashé


## La connexion au site


	
Créer un dossier Security dans src et dedans, créer une classe UserProvider qui va implémenter l'interface UserProviderInterface. Cette interfaces a besoin des méthodes suivantes :
	* loadUserByIdentifier(string $identifier): UserInterface - Dedans, on fait une instance de notre UserRepository et on utilise la méthode findByEmail pour récupérer le user avec le $identifier, si le résultat est null, alors on fait un throw new UserNotFoundException(), sinon on fait un return du user
	* refreshUser(UserInterface $user): UserInterface - Dedans on peut juste faire un appel à la méthode du dessus comme ça : return $this->loadUserByIdentifier($user->getUserIdentifier());
	* supportsClass(string $class): bool - Dedans on renvoit User::class == $class, c'est pour indiquer à Symfony dans quel cas il devra utiliser ce provider
	
Dans le fichier config/packages/security.yaml, ligne 14 on remplace user_in_memory par user_provider puis on remplace la ligne 7 par 
	user_provider:
	    id: App\Security\UserProvider
	
En suivant cette documentation depuis la partie form-login https://symfony.com/doc/current/security.html#form-login, créer une nouvelle route et un formulaire de connexion. Vous pouvez vous arrêter avant CSRF Protection in Login Forms ou avant JSON Login

### Pour tester que le login a bien marché,
 vous pouvez faire une nouvelle route sur "/protected" avec un template et juste un ptit bonjour dedans. et dans le security.yaml on peut rajouter dans la partie access_control une ligne avec ça :


- { path: ^/protected, roles: ROLE_USER }
 
(ça indique à symfony que toutes les routes qui commencent par /protected nécessitent d'être connecté avec le rôle ROLE_USER pour y accéder)

### Poster des messages lorsqu'on est connecté :


	
Relancer le script database.sql pour mettre à jour la base de données et rajouter la table message
	
Créer une entité Message et un MessageRepository dans lequel on ne va faire que un findAll et un persist (pour simplifier, on va mettre une propriété idUser dans le Message)
	
Créer un MessageController et faire que sur la route "/" ça fasse un findAll et dans le template faire une boucle pour afficher les messages
	
Créer une autre route "/add-message" et faire en sorte qu'elle ne soit accessible qu'aux user connectés
	
Dans cette route, faire un formulaire avec juste un champ content et dans le traitement du formulaire, faire en sorte de récupérer le user connecté avec $this->getUser() et assigner l'id de ce User avec un setIdUser() au message avant de le faire persister

Bonus : Faire qu'au lieu d'un idUser on ait une propriété de type User directement dans le Message et modifier le findAll pour faire une requête avec jointure

# Dans l'étape 5,
 pour pouvoir accéder à l'id du User, il va d'abord falloir s'assurer qu'on a bien une instance de notre classe en faisant 

$user = $this->getUser();
if($user instanceof User) {
 
}