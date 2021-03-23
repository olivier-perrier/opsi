<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Olivier

- Une colonne content sur le Post permet de stacker directement des données dessus en json. Doit correspondre à un type complexe (lien, liste de valeur, etc). Limite : si un post doit contenir des nouvelles valeurs par la suite alors sera bloqué
- Une table Menu qui est liée à la table de Post qui contient les informations relatives aux menus. Limite : faudra t il créer une novelle table spécifique pour chaque type de données compexe que je veux créer ?


- Type complexe en json permet de stokage de plusieurs informations pour un même type directement sur le post: par exemple pour les select, liste de données, ou type link (une url + un nom d'affichage). Besoin d'une colonne en plus type json dans la table data ou uniquement changer le type de la valeur de base

* Data *
Id	-	PostId	-	FieldId	-	Value			-	Relation
1		4			20			"Nom client"
2		5			21			"Nom Nego"
3		6			22			"Titre contrat"
4		6			23			4
5		6			24			5

6		1			1			"Main menu"
7		2			3								1

* Post *
Id	-	PostTypeId	Data
1		1			{ name : "Main menu", item1 : "2" }
2		2			{ name : "home", displayName : "Accueil", link : "/" }
3		2			{ menu : 1, name : "home2", displayName : "Accueil 2", link : "/" }

4		4			{ name : "Test C" }
5		5			{ name : "Test N" }
6		6			{ title : "Contrat", client : 

* Field *
Id	- 	PostTypeId	-	Name	-	DisplayName		Type	-	Enable
1		1				name		Nom				Text		1
2		1				item1		Champ 1			Relation	1

3		2				menu		Menu			Relation
5		2				name		Nom				Text
6		2				displayN	Nom				Text
7		2				link		Lien			Text
8		2				
						
10		3				title		Titre			Text		
11						content		Contenue		Text
						
20		4				name						Text
21		5				name						Text

22		6				title						Text
23		6				client						Relation
24		6				nego						Relation


* PostType *
Id	-	Name	- 	DisplayName
1		Menu
2 		Menu-item
3		Page
4		Client
5		Nego
6		Contrat
