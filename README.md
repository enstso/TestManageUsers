# TestManageUsers – Validation et Tests d'une Application de Gestion des Utilisateurs

## 📌 Objectif

Ce projet vise à valider le bon fonctionnement d'une application de gestion des utilisateurs à travers une série de tests complets :  
- Tests fonctionnels (PHPUnit)  
- Tests End-to-End (Cypress & Selenium)  
- Tests de non-régression  
- Tests de performance (k6)

L'application permet de :
- ➕ Ajouter un utilisateur (name, email)
- ✏️ Modifier un utilisateur
- ❌ Supprimer un utilisateur
- 📋 Afficher la liste des utilisateurs

---

## 🧰 Technologies utilisées

- **PHP** (Backend)
- **JavaScript** (Frontend)
- **PHPUnit** (Tests unitaires/fonctionnels)
- **Selenium IDE** (Tests E2E)
- **k6** (Tests de performance)
- **Docker** (Conteneurisation)

---

## 📂 Structure du projet

```
TestManageUsers/
├── class/                       # Classes PHP, ex: UserManager.php
|--------|-- UserManager.php     # Classe UserManager.php
|--------|-- UserManagerex3.php  # Classe UserManagerex3.php classe avec les modifications du code pour l'ex 3
├── src/                         # API PHP (backend)
|------|-- api.php               # api.php
|------|-- apiex3.php            # apiex3.php apiex3.php avec les modifications du code pour l'ex 3                      
├── docker/                      # Environnement Docker (php, k6, etc.)
|---------|--/k6                 # Dockerfile
|---------|--/php                # Dockerfile
├── tests/                       # Tests PHPUnit
|--------|-- UserManagerTest.php # test de la classe UserManager.php               
├── index.html                   # Interface frontend
├── indexex3.html                # Interface frontend ex3
├── k6.js                        # Script de test de performance
├── ex2.side                     # Scénario Selenium ex2
├── ex3.side                     # Scénario Selenium ex3
├── docker-compose.yaml          # Configuration Docker-compose (phpMyadmin,api,mariadb)
└── README.md                  
```



---

## Installation

git clone du projet :

```bash
git clone https://github.com/enstso/TestManageUsers.git
```
aller dans le dossier du projet :

```bash
cd TestManageUsers
```
build les images :

```bash
docker-compose build
```
Lancement des containers :

```bash
docker-compose up -d
```
Aller à l'url phpMyadmin [http://localhost:8081/](http://localhost:8081/) pour créer la table users.

credentials phpMyAdmin
server:mariadb
username:root
password:root

Dans le fichier [database.sql](database.sql), mon script de base données.

Nous créeons la table users dans phpMyadmin:
![image](https://github.com/user-attachments/assets/9aad8c93-bdd3-48c9-88dd-9ed734695d4b)


Depuis son terminal rentrer dans le container de l'api :

```bash
docker exec -it  taskmanagertest-api-1 bash
```
Installer les dépendances, création du dossier vendor :

```bash
composer install
```

Vérification :
Aller à l'url [http://localhost/](http://localhost/) :

![image](https://github.com/user-attachments/assets/562516a8-98a4-4323-b430-7d94c0a7918a)

Dans postman, tester l'api :

![image](https://github.com/user-attachments/assets/6220e6b3-869b-49a6-8348-f9842833e25d)
---

## 🔍 1. Tests Fonctionnels – PHPUnit

**Fichier concerné :** `tests/UserManagerTest.php`  
**Backend testé :** `class/UserManager.php`  

**Rappel** pour accéder au conteneur :

```bash
docker exec -it  taskmanagertest-api-1 bash
```

Depuis le conteneur :

```bash
./vendor/bin/phpunit tests
```
ou 

```bash
composer tests
```

Les explications des tests sont en commentaire, dans le fichier [UserManagerTest.php](UserManagerTest.php).

### ✒️ Tests réalisés :
- `testAddUser()` : success
- `testAddUserEmailException()` : success  
- `testUpdateUser()`  : success
- `testRemoveUser()`  : success
- `testGetUsers()`  : success
- `testInvalidUpdateThrowsException()` : non testable  
- `testInvalidDeleteThrowsException()` : non testable

Résultats des tests :

![image](https://github.com/user-attachments/assets/c4e3709e-7068-463e-b827-7fe00fe1a310)

---

## 🧪 2. Tests End-to-End – Cypress / Selenium

**Fichiers :**  
- `ex2.side` : fichier d’automatisation Selenium  
- `index.html`, `script.js` : interface utilisateur  

### 🔁 Scénario testé :
1. Ajout d’un utilisateur via l’interface  
2. Vérification de son affichage  
3. Modification des informations  
4. Suppression et vérification de disparition  

**Faire un truncate de la table users avant de faire les nouveax tests** :

![image](https://github.com/user-attachments/assets/8174472f-2773-4c6a-8a62-297d24192233)


### 🖼️ Captures & Résultats :
Dans selenium, on se mets en Capture pour les tests suivants :

addUser, on insère un utilisateur en respectant les champs suivant :

![image](https://github.com/user-attachments/assets/d9354263-0c53-453e-9d5a-d9e0afd4fd65)

updateUser :

Nous Ajoutons l'utilisateur à modifier et le modifions :

![image](https://github.com/user-attachments/assets/819da3f8-a9fa-43b4-b1c6-34e5ddda4c8b)

Modification valide de l'utilisateur :

![image](https://github.com/user-attachments/assets/9f505e44-b5ae-441d-a4d5-0ab491a8c779)

deleteUser :

Ajout de l'utilisateur à supprimer :

![image](https://github.com/user-attachments/assets/7c9daf0e-66ae-40d5-a19a-bfc7a54f4d9d)

![image](https://github.com/user-attachments/assets/471dbf7e-5d82-4c96-a934-22d767baf488)

Nous supprimons l'utilisateur en cliquant sur la croix :

![image](https://github.com/user-attachments/assets/f9ea9be7-56cd-4256-8897-49c497ec0b73)

Avant de relancer les tests, faisons un truncate, de la table :

![image](https://github.com/user-attachments/assets/8174472f-2773-4c6a-8a62-297d24192233)

Résultats des tests :

![image](https://github.com/user-attachments/assets/b32c9cf3-92f1-4f48-8752-c0066b912d2c)


📋 Tous les scénarios se déroulent comme attendu ✅

---

## 🔁 3. Tests de Non-Régression

**Contexte :** ajout d’une fonctionnalité :  
➕ *Ajout automatique de la date (`now`) si le champ est `null`* (Toutes les anciennes fonctionnalités sont fonctionnels).

**Comparaison :**
- Avant : `UserManager.php`  
- Après : `UserManagerex3.php` Ajout du champs date dans les différentes méthodes. Voir le fichier [UserManagerex3.php](UserManagerex3.php)
- Avant : `index.html`
- Après : `indexex3.html` Ajout d'un input type Date au formulaire. [indexex3.html](indexex3.html)
- Avant : `script.js`
- Après : `scriptex3.js` modification du code afin d'avoir la date, implémtation de la logique si null on prends la date now. [scriptex3.js](scriptex3.js)
  
Création de la nouvelle table usersex3 :

![image](https://github.com/user-attachments/assets/7d36fd62-7c33-4e99-b776-f26ea80b42ad)

### ✅ Résultats :

Nous créeons, un nouveau projet, selenium pour l'exercice 3 et mettons en mode capture, pour chaque test.

Ajout d'un champs date :

![image](https://github.com/user-attachments/assets/126c0304-2fb6-4b0e-8cb0-2894cc45ea37)

ajout d'un utilisateur :

![image](https://github.com/user-attachments/assets/248fe583-1870-4e0e-85ef-58ad162ee990)

Nous pouvons voir l'utilisateur :

![image](https://github.com/user-attachments/assets/9a438eb4-2230-4590-a62e-0daa5c720b96)

Création d'un utilisateur, sans lui passer de date, donc la date est à null :
![image](https://github.com/user-attachments/assets/c2fccb41-0ddd-454c-a7f1-ffd2c23b97eb)

Nous pouvons voir, que ça a bien pris la date du jour :

![image](https://github.com/user-attachments/assets/ca8c9068-0086-46ba-9795-9ac2b2179ff2)

Pour la mise à jour d'un utilisateur :

![image](https://github.com/user-attachments/assets/9e6ac2ee-6836-4ef3-8fb9-ebf3d5fe2b1d)

![image](https://github.com/user-attachments/assets/aeb9593b-855e-4e8b-b6bf-ec20e6915266)

Mise à jour de l'utilisateur :

![image](https://github.com/user-attachments/assets/4f570749-5403-46d9-b62c-a9f587e8d978)

![image](https://github.com/user-attachments/assets/f3365341-b85d-4dc9-aed4-b68a92cf0f23)

![image](https://github.com/user-attachments/assets/04ed4624-b8cd-4f6c-a6c4-55b90cf12876)
![image](https://github.com/user-attachments/assets/32e39733-7694-4f83-97d1-4b6d6ca99a2f)

![image](https://github.com/user-attachments/assets/bcdb0ba8-8549-4b49-b408-fe7e2c276068)

![image](https://github.com/user-attachments/assets/51389831-9750-4dca-81c9-f4d686eff874)

- Aucun test existant n’a échoué après ajout 🔁  
- Fonctionnalité ajoutée testée et validée ✔️


---

## ⚙️ 4. Tests de Performance – k6

**Fichier :** `k6.js`  
**Commande d'exécution (dans le conteneur Docker k6) :**

```bash
docker-compose run k6 run /scripts/k6.js
```

### 🔬 Objectif :
- Simuler **500 utilisateurs** ajoutant des comptes  
- Mesurer le **temps de réponse**  
- Identifier d’éventuels **goulots d’étranglement**

### 📊 Résultats :
- Temps moyen de réponse : **~250ms**  
- Taux d’échec : **0%**  
- Recommandation : envisager un cache ou une optimisation SQL si utilisateurs >1000




![image](https://github.com/user-attachments/assets/84d0b47c-3594-444c-9d33-49e1555f0d1e)

![image](https://github.com/user-attachments/assets/ab9fd4e7-0035-4709-9751-e513d16d516f)
![image](https://github.com/user-attachments/assets/7b504e86-fb10-4094-8e54-c12534dd1c33)
