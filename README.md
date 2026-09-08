# Gestion des Cotisations — AJUDN

Application web complète de gestion des cotisations d'une association, développée avec **Laravel 12**, **PHP 8.3**, **MySQL**, **Bootstrap 5** et **Blade**.

## ✨ Fonctionnalités

- Authentification sécurisée (administrateur unique)
- Tableau de bord avec statistiques et graphiques (Chart.js) :
  - total des membres, membres à jour, membres en retard, total encaissé
- Gestion des membres (CRUD complet) avec matricule automatique
- Gestion des cotisations (paiements) avec référence de reçu automatique
- Historique des paiements par membre
- Recherche et filtrage des membres et des cotisations
- Génération de reçus PDF (barryvdh/laravel-dompdf)
- Export Excel et PDF des membres et des cotisations (maatwebsite/excel)
- Sauvegarde de la base de données (mysqldump)
- Interface responsive (Bootstrap 5 + Bootstrap Icons)

## 🧰 Prérequis

- PHP >= 8.2 (recommandé 8.3) avec les extensions : `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `gd`
- Composer 2.x
- MySQL 5.7+ / MariaDB 10.3+
- (Optionnel) `mysqldump` accessible dans le PATH pour la fonctionnalité de sauvegarde

## 🚀 Installation

### 1. Décompresser et ouvrir le projet

Décompressez l'archive ZIP puis ouvrez le dossier dans **Visual Studio Code**.

```bash
cd cotisation-app
code .
```

### 2. Installer les dépendances Composer

```bash
composer install
```

### 3. Configurer le fichier `.env`

Un fichier `.env` est déjà fourni (copié depuis `.env.example`). Adaptez les valeurs à votre environnement, notamment la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cotisation_association
DB_USERNAME=root
DB_PASSWORD=

ADMIN_EMAIL=ajudn@gmail.com
ADMIN_PASSWORD=Ajudn2026
```

Si le fichier `.env` n'existe pas, créez-le à partir de l'exemple :

```bash
cp .env.example .env
```

### 4. Générer la clé d'application

```bash
php artisan key:generate
```

### 5. Créer la base de données

Créez manuellement une base de données MySQL nommée `cotisation_association` (ou le nom choisi dans `.env`), par exemple via phpMyAdmin ou en ligne de commande :

```sql
CREATE DATABASE cotisation_association CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Lancer les migrations

```bash
php artisan migrate
```

### 7. Lancer les seeders (compte administrateur + données de démonstration)

```bash
php artisan db:seed
```

Cette commande crée :
- le compte administrateur (`ajudn@gmail.com` / `Ajudn2026`)
- 25 membres et des cotisations de démonstration

> Vous pouvez tout faire en une seule commande : `php artisan migrate:fresh --seed`

### 8. Créer le lien de stockage public (facultatif)

```bash
php artisan storage:link
```

### 9. Lancer l'application

```bash
php artisan serve
```

L'application est alors accessible sur : **http://127.0.0.1:8000**

## 🔑 Connexion administrateur par défaut

| Champ         | Valeur              |
|---------------|---------------------|
| E-mail        | `ajudn@gmail.com`   |
| Mot de passe  | `Ajudn2026`         |

⚠️ Pensez à modifier ce mot de passe après la mise en production.

## 🗂️ Structure du projet (MVC)

```
app/
  Http/Controllers/     → Contrôleurs (Auth, Dashboard, Membres, Cotisations, Exports, Sauvegarde)
  Http/Middleware/       → Middlewares personnalisés (auth.admin, locale FR)
  Models/                → Modèles Eloquent (User, Membre, Cotisation)
  Exports/               → Classes d'export Excel
database/
  migrations/            → Migrations des tables
  seeders/                → Seeders (admin + données de démo)
  factories/              → Factories pour les tests/démo
resources/views/         → Vues Blade (layouts, auth, dashboard, membres, cotisations, pdf, exports)
routes/web.php           → Routes de l'application
public/                  → Point d'entrée, CSS, assets publics
```

## 📦 Commandes Composer utiles

| Commande                          | Description                                  |
|-----------------------------------|-----------------------------------------------|
| `composer install`                | Installe toutes les dépendances               |
| `composer update`                 | Met à jour les dépendances                    |
| `composer dump-autoload`          | Régénère l'autoload PSR-4                     |

## 🗄️ Commandes Artisan utiles

| Commande                                  | Description                                       |
|--------------------------------------------|----------------------------------------------------|
| `php artisan migrate`                      | Exécute les migrations                             |
| `php artisan migrate:fresh --seed`         | Réinitialise la base et réinsère les données de démo |
| `php artisan db:seed`                      | Exécute les seeders                                |
| `php artisan serve`                        | Démarre le serveur local                           |
| `php artisan route:list`                   | Liste toutes les routes disponibles                |
| `php artisan config:clear`                 | Vide le cache de configuration                     |
| `php artisan storage:link`                 | Crée le lien symbolique de stockage public          |

## 📄 Génération des reçus et exports

- **Reçu PDF** : disponible après chaque enregistrement de paiement, ou depuis la liste des cotisations / la fiche membre.
- **Export Excel/PDF des membres** : bouton disponible sur la page "Membres".
- **Export Excel/PDF des cotisations** : bouton disponible sur la page "Cotisations".

## 💾 Sauvegarde de la base de données

Depuis le menu **Sauvegarde**, cliquez sur "Nouvelle sauvegarde" pour générer un fichier `.sql` via `mysqldump`. Le fichier peut ensuite être téléchargé ou supprimé.

> `mysqldump` doit être installé sur le serveur (inclus par défaut avec XAMPP, WAMP, Laragon, ou une installation MySQL standard).

## 🌐 Déploiement sur un hébergement gratuit

1. Uploadez tout le contenu du projet **sauf** `vendor/` et `node_modules/` via Git ou FTP.
2. Exécutez `composer install --no-dev --optimize-autoloader` sur le serveur (ou via SSH si disponible).
3. Configurez le fichier `.env` avec les informations de la base de données de l'hébergeur.
4. Pointez le **document root** du domaine vers le dossier `public/`.
5. Exécutez `php artisan migrate --force` et `php artisan db:seed --force`.
6. Exécutez `php artisan config:cache` et `php artisan route:cache` pour optimiser les performances.

## 🛠️ Stack technique

- **Backend** : Laravel 12, PHP 8.3
- **Base de données** : MySQL
- **Frontend** : Blade, Bootstrap 5, Bootstrap Icons, Chart.js
- **PDF** : barryvdh/laravel-dompdf
- **Excel** : maatwebsite/excel

---
Développé pour **AJUDN**.
