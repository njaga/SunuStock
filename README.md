# SunuStock - Logiciel de Gestion de Stock

<p align="center">
  <a href="https://www.sunu-stock.ndiagandiaye.com/" target="_blank">
    <img src="https://www.sunu-stock.ndiagandiaye.com/wp-content/uploads/2024/04/cropped-sunu_stock_logo-removebg-preview.png" width="400" alt="Logo de Sunu Stock">
  </a>
</p>

<p align="center">
  <a href="https://github.com/njaga/SunuStock"><img src="https://img.shields.io/github/stars/njaga/SunuStock" alt="Étoiles GitHub"></a>
  <a href="https://github.com/njaga/SunuStock"><img src="https://img.shields.io/github/forks/njaga/SunuStock" alt="Forks GitHub"></a>
</p>

## 📋 Table des matières

- [À propos](#-à-propos)
- [Démonstration](#-démonstration)
- [Technologies utilisées](#-technologies-utilisées)
- [Fonctionnalités](#-fonctionnalités)
- [Installation](#-installation)
- [Utilisation](#-utilisation)
- [Documentation](#-documentation)
- [Contribution](#-contribution)
- [Licence](#-licence)
- [Contact](#-contact)

## 🚀 À propos

SunuStock est un logiciel de gestion de stock développé par des étudiants de niveau L3 dans le cadre de leur mémoire. Ce projet vise à fournir une solution robuste, efficace et conviviale pour la gestion des stocks, des commandes et du catalogage des produits dans un environnement d'entreprise.

## 🖥 Démonstration

- **Application de démonstration** : [https://app-stock.ndiagandiaye.com/](https://app-stock.ndiagandiaye.com/)
- **Site web** : [https://www.sunu-stock.ndiagandiaye.com/](https://www.sunu-stock.ndiagandiaye.com/)
- **Présentation du projet** : [Voir la présentation Canva](https://www.canva.com/design/DAGCHmYyBwY/SD0zxp-ZTIcVZomwgL_WuA/view?utm_content=DAGCHmYyBwY&utm_campaign=designshare&utm_medium=link&utm_source=editor)
- **Slides du projet** : [Voir les slides Canva](https://www.canva.com/design/DAGGutufnuA/VzpFADV6LMIQtyrglkZiOg/view?utm_content=DAGGutufnuA&utm_campaign=designshare&utm_medium=link&utm_source=editor)

## 🛠 Technologies utilisées

- Laravel
- MySQL
- Blade
- Bootstrap
- Chart.js
- DomPDF

## ✨ Fonctionnalités

- **Gestion efficace des stocks** : Suivi facile des niveaux de stock, gestion des réapprovisionnements et optimisation de la manipulation des stocks.
- **Traitement des commandes** : Processus simplifié de saisie, de suivi et de réalisation des commandes.
- **Catalogage des produits** : Interface intuitive pour la gestion des détails des produits, des catégories et des spécifications.
- **Outils de reporting** : Rapports complets offrant des perspectives sur les tendances des ventes, les niveaux de stock et le statut des commandes.
- **Accès multi-utilisateur** : Contrôle d'accès basé sur les rôles pour gérer efficacement les permissions des utilisateurs.

## 🚀 Installation

1. Clonez le dépôt :
   ```
   git clone https://github.com/njaga/SunuStock.git
   ```
2. Naviguez dans le répertoire du projet :
   ```
   cd SunuStock
   ```
3. Installez les dépendances PHP :
   ```
   composer install
   ```
4. Installez les dépendances JavaScript :
   ```
   npm install
   ```
5. Copiez le fichier `.env.example` en `.env` et configurez vos variables d'environnement :
   ```
   cp .env.example .env
   ```
6. Générez une clé d'application :
   ```
   php artisan key:generate
   ```
7. Exécutez les migrations de la base de données :
   ```
   php artisan migrate
   ```
8. (Optionnel) Remplissez la base de données avec des données de test :
   ```
   php artisan db:seed
   ```

## 💻 Utilisation

1. Lancez le serveur de développement :
   ```
   php artisan serve
   ```
2. Compilez les assets :
   ```
   npm run dev
   ```
3. Accédez à l'application dans votre navigateur à l'adresse `http://localhost:8000`

## 📚 Documentation

Pour une documentation plus détaillée, veuillez consulter notre [Wiki](https://github.com/njaga/SunuStock/wiki) sur GitHub.

## 🤝 Contribution

Les contributions sont les bienvenues ! Veuillez consulter notre [guide de contribution](CONTRIBUTING.md) pour plus de détails.

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📞 Contact

Pour toute question ou suggestion, n'hésitez pas à nous contacter à [sunu-stock@ndiagandiaye.com](mailto:sunu-stock@ndiagandiaye.com).

---

Développé avec ❤️ par l'équipe SunuStock
