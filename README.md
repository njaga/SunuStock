<p align="center"><a href="https://www.sunu-stock.ndiagandiaye.com/" target="_blank"><img src="https://www.sunu-stock.ndiagandiaye.com/wp-content/uploads/2024/04/cropped-sunu_stock_logo-removebg-preview.png" width="400" alt="Logo de Sunu Stock"></a></p>

<p align="center">
<a href="https://github.com/njaga/SunuStock"><img src="https://img.shields.io/github/stars/njaga/SunuStock" alt="Étoiles GitHub"></a>
<a href="https://github.com/njaga/SunuStock"><img src="https://img.shields.io/github/forks/njaga/SunuStock" alt="Forks GitHub"></a>
<a href="https://github.com/njaga/SunuStock"><img src="https://img.shields.io/github/license/njaga/SunuStock" alt="Licence"></a>
</p>

## À propos de notre logiciel de gestion de stock

Ce logiciel de gestion de stock est un projet collaboratif développé par des étudiants de niveau L3 à HEMI dans le cadre de leur mémoire. Il est conçu pour offrir un système robuste, efficace et convivial pour la gestion des niveaux de stock, des commandes et du catalogage des produits dans un environnement d'entreprise.

Caractéristiques clés :

- **Gestion efficace des stocks :** Suivi facile des niveaux de stock, gestion des réapprovisionnements et optimisation de la manipulation des stocks.
- **Traitement des commandes :** Processus simplifié de saisie, de suivi et de réalisation des commandes.
- **Catalogage des produits :** Interface intuitive pour la gestion des détails des produits, des catégories et des spécifications.
- **Outils de reporting :** Rapports complets offrant des perspectives sur les tendances des ventes, les niveaux de stock et le statut des commandes.
- **Accès multi-utilisateur :** Contrôle d'accès basé sur les rôles pour gérer efficacement les permissions des utilisateurs.

Notre logiciel utilise les dernières technologies web pour garantir une expérience utilisateur fluide et évolutive, notamment PHP avec Laravel, Bootstrap, CSS, DomPDF, JavaScript et Chart.js.

## Apprendre à propos de notre projet

Notre documentation complète du projet [ici](https://github.com/njaga/SunuStock#readme) inclut tout, des guides d'installation aux aperçus des fonctionnalités, rendant facile pour quiconque de comprendre et d'utiliser efficacement notre logiciel.

Intéressé à contribuer ? Consultez notre [dépôt GitHub](https://github.com/njaga/SunuStock) !

## Guide d'installation et de déploiement

### Installation locale

1. **Cloner le dépôt GitHub :** Commencez par cloner le dépôt GitHub sur votre machine locale en utilisant la commande suivante dans votre terminal : <br>
git clone https://github.com/njaga/SunuStock.git

2. **Installer les dépendances :** Naviguez vers le répertoire fraîchement cloné et installez les dépendances en exécutant la commande suivante : <br>
cd SunuStock <br>
composer install

4. **Configurer l'environnement :** Créez un fichier `.env` à la racine du projet en copiant `.env.example` et configurez les variables d'environnement nécessaires telles que les informations de connexion à la base de données.

5. **Générer la clé d'application :** Exécutez la commande suivante pour générer une nouvelle clé d'application :<br>
php artisan key:generate

6. **Migrer la base de données :** Exécutez les migrations pour créer les tables de base de données en utilisant la commande suivante :<br>
php artisan migrate

7. **Lancer l'application :** Lancez l'application en utilisant la commande suivante :<br>
php artisan serve

8. **Accéder à l'application :** L'application sera maintenant accessible à l'adresse suivante dans votre navigateur web : <br> `http://localhost:8000`.

### Déploiement en production

Pour le déploiement en production, veuillez suivre les étapes recommandées pour déployer une application Laravel.

## Remerciements à nos sponsors et supporters

Nous sommes reconnaissants pour le soutien de HEMI et de Vigilus qui ont fourni des conseils et des ressources, aidant à faire de ce projet un succès.

## Contribuer

Vous souhaitez contribuer à notre logiciel de gestion de stock ? Nous accueillons les contributions d'autres étudiants et membres du corps professoral. Retrouvez nos directives de contribution sur notre [page GitHub](https://github.com/njaga/SunuStock#contributing).

## Code de conduite

Pour maintenir une communauté accueillante et inclusive, veuillez lire et respecter notre [Code de conduite](https://github.com/njaga/SunuStock#code-of-conduct).

## Vulnérabilités de sécurité

Si vous découvrez une vulnérabilité de sécurité, veuillez nous en informer via [notre email](mailto:sunu-stock@ndiagandiaye.com). Nous aborderons ces problèmes promptement.

## Licence

Ce logiciel de gestion de stock est un logiciel open-source disponible sous la [licence MIT](https://opensource.org/licenses/MIT).
