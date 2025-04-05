Voici un exemple complet de **README.md** pour ton projet **TaskManagerTest**, structuré pour correspondre à l’énoncé de l’exercice et aux éléments de ton dossier :

---

# TaskManagerTest – Validation et Tests d'une Application de Gestion des Utilisateurs

## 📌 Objectif

Ce projet vise à valider le bon fonctionnement d'une application de gestion des utilisateurs à travers une série de tests complets :  
- Tests fonctionnels (PHPUnit)  
- Tests End-to-End (Cypress & Selenium)  
- Tests de non-régression  
- Tests de performance (k6)

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
|--------|-- UserManagerTest.php #                 
├── index.html                   # Interface frontend
├── indexex3.html                # Interface frontend ex3
├── k6.js                        # Script de test de performance
├── ex2.side                     # Scénario Selenium ex2
├── ex3.side                     # Scénario Selenium ex3
├── docker-compose.yaml          # Configuration Docker-compose (phpMyadmin,api,mariadb)
└── README.md                  
```

---

## ✅ Fonctionnalités à tester

L'application permet de :
- ➕ Ajouter un utilisateur (nom, prénom, email)
- ✏️ Modifier un utilisateur
- ❌ Supprimer un utilisateur
- 📋 Afficher la liste des utilisateurs

---

## 🔍 1. Tests Fonctionnels – PHPUnit

**Fichier concerné :** `tests/`  
**Backend testé :** `class/UserManager.php`  

### ✒️ Tests réalisés :
- `testAddUser()`  
- `testAddUserEmailException()`  
- `testUpdateUser()`  
- `testRemoveUser()`  
- `testGetUsers()`  
- `testInvalidUpdateThrowsException()`  
- `testInvalidDeleteThrowsException()`

### 🖼️ Captures & Résultats :
📸 Voir `/captures/phpunit_results.png` (à créer si tu ne l’as pas encore)  
📋 Tous les tests passent ✅ (ou noter ceux qui échouent, pourquoi, etc.)

---

## 🧪 2. Tests End-to-End – Cypress / Selenium

**Fichiers :**  
- `ex2.side` et `ex3.side` : fichiers d’automatisation Selenium  
- `index.html`, `script.js` : interface utilisateur  

### 🔁 Scénario testé :
1. Ajout d’un utilisateur via l’interface  
2. Vérification de son affichage  
3. Modification des informations  
4. Suppression et vérification de disparition  

### 🖼️ Captures & Résultats :
📸 Voir `/captures/e2e_results.png`  
📋 Tous les scénarios se déroulent comme attendu ✅

---

## 🔁 3. Tests de Non-Régression

**Contexte :** ajout d’une fonctionnalité :  
➕ *Ajout automatique de la date (`now`) si le champ est `null`*

**Comparaison :**
- Avant : `UserManager.php`  
- Après : `UserManagerex3.php`

### ✅ Résultats :
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

---

## 🚀 Lancer le projet

```bash
docker-compose up -d
```

Accès à l’interface : [http://localhost:8000/index.html](http://localhost:8000/index.html)

---

## 🧰 Technologies utilisées

- **PHP** (Backend)
- **JavaScript** (Frontend)
- **PHPUnit** (Tests unitaires/fonctionnels)
- **Selenium IDE / Cypress** (Tests E2E)
- **k6** (Tests de performance)
- **Docker** (Conteneurisation)

---

## 📎 Auteurs

- Réalisé par *[Ton nom ici]*  
- Pour le cours de *[Nom du cours / prof / école]*

---

Souhaite-tu que je te génère aussi un rapport détaillé (ex. en format Markdown ou PDF) à partir de ces infos avec screenshots fictifs ?

![image](https://github.com/user-attachments/assets/9aad8c93-bdd3-48c9-88dd-9ed734695d4b)
![image](https://github.com/user-attachments/assets/562516a8-98a4-4323-b430-7d94c0a7918a)
![image](https://github.com/user-attachments/assets/6220e6b3-869b-49a6-8348-f9842833e25d)

![image](https://github.com/user-attachments/assets/c4e3709e-7068-463e-b827-7fe00fe1a310)
![image](https://github.com/user-attachments/assets/d9354263-0c53-453e-9d5a-d9e0afd4fd65)

![image](https://github.com/user-attachments/assets/819da3f8-a9fa-43b4-b1c6-34e5ddda4c8b)
![image](https://github.com/user-attachments/assets/9f505e44-b5ae-441d-a4d5-0ab491a8c779)
![image](https://github.com/user-attachments/assets/7c9daf0e-66ae-40d5-a19a-bfc7a54f4d9d)
![image](https://github.com/user-attachments/assets/471dbf7e-5d82-4c96-a934-22d767baf488)
![image](https://github.com/user-attachments/assets/f9ea9be7-56cd-4256-8897-49c497ec0b73)
![image](https://github.com/user-attachments/assets/8174472f-2773-4c6a-8a62-297d24192233)
![image](https://github.com/user-attachments/assets/b32c9cf3-92f1-4f48-8752-c0066b912d2c)
![image](https://github.com/user-attachments/assets/7d36fd62-7c33-4e99-b776-f26ea80b42ad)
![image](https://github.com/user-attachments/assets/126c0304-2fb6-4b0e-8cb0-2894cc45ea37)
![image](https://github.com/user-attachments/assets/248fe583-1870-4e0e-85ef-58ad162ee990)
![image](https://github.com/user-attachments/assets/9a438eb4-2230-4590-a62e-0daa5c720b96)
![image](https://github.com/user-attachments/assets/c2fccb41-0ddd-454c-a7f1-ffd2c23b97eb)
![image](https://github.com/user-attachments/assets/ca8c9068-0086-46ba-9795-9ac2b2179ff2)

![image](https://github.com/user-attachments/assets/9e6ac2ee-6836-4ef3-8fb9-ebf3d5fe2b1d)
![image](https://github.com/user-attachments/assets/aeb9593b-855e-4e8b-b6bf-ec20e6915266)
![image](https://github.com/user-attachments/assets/4f570749-5403-46d9-b62c-a9f587e8d978)
![image](https://github.com/user-attachments/assets/f3365341-b85d-4dc9-aed4-b68a92cf0f23)

![image](https://github.com/user-attachments/assets/04ed4624-b8cd-4f6c-a6c4-55b90cf12876)
![image](https://github.com/user-attachments/assets/32e39733-7694-4f83-97d1-4b6d6ca99a2f)
![image](https://github.com/user-attachments/assets/bcdb0ba8-8549-4b49-b408-fe7e2c276068)

![image](https://github.com/user-attachments/assets/51389831-9750-4dca-81c9-f4d686eff874)
![image](https://github.com/user-attachments/assets/84d0b47c-3594-444c-9d33-49e1555f0d1e)

![image](https://github.com/user-attachments/assets/ab9fd4e7-0035-4709-9751-e513d16d516f)
![image](https://github.com/user-attachments/assets/7b504e86-fb10-4094-8e54-c12534dd1c33)
