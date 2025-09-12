# 🌱 GreenGoodies – Site et API
Projet n°13 – Formation Développeur d’application PHP Symfony @OpenClassrooms

---

## 📑 Table des matières
- [Contexte](#-contexte)
- [Fonctionnalités](#-fonctionnalités)
- [Installation](#-installation)
- [Technologies utilisées](#-technologies-utilisées)

---

## 📄 Contexte

GreenGoodies est un **site e-commerce responsive** développé avec **Symfony**.  
Il permet aux utilisateurs de visualiser des produits écologiques, gérer un panier et passer des commandes fictives.

Le projet s’appuie sur les maquettes du designer : [Figma](https://www.figma.com/file/dwbwGIJqxan1qJFwKt8juV/Green-Goodies?type=design&node-id=0%3A1&mode=design&t=OXiRrAW0OXecVME4-1)

---

## ✨ Fonctionnalités

### Partie publique
- Visualisation des produits
- Inscription et connexion sécurisées

### Partie utilisateur (authentifiée)
- Passer une commande
- Suivi des commandes
- Gestion du panier : ajout, modification, suppression

### API (authentifiée)
- Récupération de la liste des produits

### Interface & bonnes pratiques
- Validation des formulaires via **Symfony Validator** + vérification **JS**
- Site **responsive** (desktop, tablette, mobile)
- Images optimisées au format **WebP**
- CSS et JS minifiés ([minifier.org](https://www.minifier.org/))

**Compte de test (fixtures) :**
- email : `user@test.com`
- mot de passe : `12345678`

---

## ⚙️ Installation

### Prérequis
- PHP >= 8.1
- Composer
- Symfony CLI
- MySQL ou phpMyAdmin

### Cloner le projet
```bash
git clone https://github.com/JingFERMENT/OS-P13-GreenGoodies.git
cd OS-P13-GreenGoodies
