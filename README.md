# Laravel Elearning Platform

Une plateforme d’e-learning intelligente construite avec Laravel 11. Elle permet aux étudiants d’apprendre à leur rythme, aux enseignants de gérer leurs cours, et aux administrateurs de superviser l’ensemble. Le système inclut un tableau de bord personnalisé selon le rôle et des fonctionnalités interactives comme les quiz, devoirs et certificats.

> 🚧 **Projet développé conjointement par [@sayouba2](https://github.com/sayouba2) et [@HichamOuteha)](https://github.com/HichamOuteha)**

---

## 🚀 Fonctionnalités principales

* **Rôles multiples** : Étudiants, enseignants, administrateurs avec des dashboards dédiés.
* **Création et gestion de cours et de leçons** : Par les enseignants.
* **Inscription et suivi de progression** : Pour les étudiants.
* **Système de quiz et devoirs** : Évaluation des connaissances.
* **Certificats** : Génération automatique après réussite.
* **Tableaux de bord analytiques** : Statistiques par rôle (revenus, inscriptions, performance...).

---

## 🧰 Prérequis

* PHP >= 8.1
* Composer
* Node.js & npm
* MySQL 5
* Laravel 11
* XAMPP

---

## ⚙️ Installation

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/sayouba2/smart_learning.git
   cd smart_learning
   ```

2. **Installer les dépendances PHP**

   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**

   ```bash
   npm install
   ```

4. **Copier le fichier `.env`**

   ```bash
   cp .env.example .env
   ```

5. **Configurer l’environnement `.env`**

   ```env
   APP_NAME="Smart Learning"
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=

   OPENAI_API_KEY=your_api_key
   PAYPAL_CLIENT_ID=your_paypal_id
   ```

6. **Générer la clé de l’application**

   ```bash
   php artisan key:generate
   ```

7. **Lancer les migrations**

   ```bash
   php artisan migrate --seed
   ```

8. **Compiler les assets**

   ```bash
   npm run dev
   ```

9. **Démarrer le serveur**

   ```bash
   php artisan serve
   ```

---

## 🔒 Authentification et rôles

Le système utilise Laravel Breeze avec des redirections conditionnelles selon le rôle :

* `/admin/dashboard`
* `/teacher/dashboard`
* `/student/dashboard`

Les rôles sont attribués lors de l’inscription.

---

## 📁 Structure du projet

```
smart-learning/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   ├── Teacher/
│   │   ├── Student/
│   │   └── ContactController.php, AboutController.php, StudentController.php ...
│   ├── Models/
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Quiz.php
│   │   └── Certificate.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── js/
├── routes/
│   ├── web.php
│   └── admin.php, teacher.php, student.php
├── public/
├── .env
├── composer.json
├── package.json
└── vite.config.js
```

---

## 📊 Graphiques dynamiques

Utilisation de `Chart.js` pour afficher :

* Cours les plus populaires
* Inscriptions par mois
* Revenus par catégorie
* Progression des étudiants

---

## ✅ Tests

```bash
php artisan test
```

---

## 🤝 Contribution

1. Fork du projet.

2. Créer une branche :

   ```bash
   git checkout -b feature/ma-fonctionnalite
   ```

3. Commit :

   ```bash
   git commit -m "Ajout d’une fonctionnalité"
   ```

4. Push :

   ```bash
   git push origin feature/ma-fonctionnalite
   ```

5. Pull request vers `main`.

---

## 📄 Licence

Projet open source sous licence [MIT](LICENSE).

---

## 🙏 Remerciements

* Laravel pour le framework
* Tailwind CSS, Chart.js, Jetstream/Breeze

---

## 📬 Support

Pour toute question ou bug, merci d’ouvrir une [issue GitHub](https://github.com/sayouba2/smart_learning/issues).

