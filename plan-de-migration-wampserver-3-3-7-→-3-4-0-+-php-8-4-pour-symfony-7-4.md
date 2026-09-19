# Plan de migration : WampServer 3.3.7 → 3.4.0 + PHP 8.4 pour Symfony 7.4

*Dernière mise à jour : 19 juin 2026*
*Autrice : Isabelle Popovics*

---

## 📌 **Contexte et objectifs**
- **Objectif principal** : Migrer de **WampServer 3.3.7** vers **3.4.0** avec **PHP 8.4** pour un projet **Symfony 7.4**.
- **Enjeux** :
  - Assurer la compatibilité de Symfony 7.4 avec PHP 8.4.
  - **Conserver PHP 8.3** pour Symfony 6.3 (branche `main`).
  - Éviter les régressions liées aux dépendances ou à la configuration.
  - Maintenir la stabilité des bases de données et des Virtual Hosts.

---

## 🔗 **Liens utiles**
| Ressource | Lien |
|----------|------|
| WampServer 3.4.0 (installeur) | [wampserver.com](https://www.wampserver.com) |
| Addons, VC++, outils | [wampserver.aviatechno.net](https://wampserver.aviatechno.net) |
| Outil de vérification VC++ | [check_vcredist.exe](https://wampserver.aviatechno.net/files/tools/check_vcredist.exe) |
| Tous les VC++ en un seul exe | [abbodi1406/vcredist](https://github.com/abbodi1406/vcredist/releases) |
| Xdebug 3.4+ (compatible PHP 8.4) | [xdebug.org](https://xdebug.org) |
| Documentation Symfony 7.4 | [symfony.com/doc/7.4](https://symfony.com/doc/7.4) |
| Addon PHP 8.3 (si nécessaire) | [wampserver.aviatechno.net](https://wampserver.aviatechno.net) |
| Release notes PHP 8.4 | [php.net](https://www.php.net/ChangeLog-8.php#8.4.0) |

---

## ⚠️ **Prérequis et recommandations**
- **✅ À faire avant de commencer** :
  - Vérifier que **Symfony 7.4 est compatible avec PHP 8.4** (consulter [la documentation officielle](https://symfony.com/doc/current/setup.html#php-version)).
  - Lister les **bundles tiers** utilisés dans le projet et vérifier leur compatibilité avec PHP 8.4.
  - S’assurer que **toutes les données critiques sont sauvegardées** (bases de données, fichiers, configurations).

- **⚠️ Points clés à retenir** :
  - **WampServer 3.4.0 permet de garder plusieurs versions de PHP en parallèle** (ex: PHP 8.3 et PHP 8.4).
  - Tu pourras **basculer entre PHP 8.3 et PHP 8.4** via le menu WampServer.
  - **Symfony 6.3 (branche `main`)** peut continuer à utiliser **PHP 8.3** pendant que tu tests **Symfony 7.4 avec PHP 8.4**.

- **⚠️ Risques majeurs à anticiper** :
  - PHP 8.4 introduit des **changements majeurs** (ex: [PDO strict types](https://php.watch/versions/8.4/Pdo-strict-types), [implicitly nullable parameters](https://php.watch/versions/8.4/implicitly-nullable-parameters)) qui peuvent casser du code Symfony ou des bundles.
  - Certaines **extensions PHP** peuvent ne pas être compatibles avec PHP 8.4.

---

---

## 📦 **PHASE 0 — Préparation**
### 0.1 — Vérifier la compatibilité PHP 8.4 avec Symfony 7.4
- Consulter la [documentation Symfony 7.4](https://symfony.com/doc/7.4/setup.html) pour confirmer la compatibilité avec PHP 8.4.
- Vérifier les [release notes de Symfony 7.4](https://symfony.com/releases/7.4) pour les éventuelles restrictions.

### 0.2 — Lister les bundles tiers et vérifier leur compatibilité
- Exécuter la commande suivante pour lister les bundles installés :
  ```bash
  composer show --tree
  ```
- Pour chaque bundle, vérifier sa compatibilité avec PHP 8.4 (consulter la documentation du bundle ou son dépôt GitHub).

### 0.3 — Vérifier les dépendances Composer
- Exécuter la commande suivante pour identifier les dépendances obsolètes :
  ```bash
  composer outdated --major-only
  ```
- Utiliser **[PHPStan](https://phpstan.org/)** (niveau 9+) ou **[RectorPHP](https://getrector.com/)** pour détecter les dépréciations dans le code :
  ```bash
  php vendor/bin/phpstan analyse --level 9
  ```

---

---

## 🔄 **PHASE 1 — Sauvegardes (ne pas sauter cette phase)**
### 1.1 — Exporter toutes les bases de données
- Ouvrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
- Pour chaque base de données :
  - **Exporter** → Format **SQL** → Sauvegarder le fichier `.sql`.
  - Stocker les exports dans un dossier **hors de `c:\wamp64\`** (ex: disque externe, cloud).

### 1.2 — Sauvegarder les fichiers du projet
- Copier le dossier `c:\wamp64\www\` vers un autre emplacement.
- Si le projet est sous **Git** :
  ```bash
  git status  # Vérifier les modifications non commitées
  git add . && git commit -m "Sauvegarde avant migration"
  git push
  ```

### 1.3 — Noter la configuration PHP 8.3 active
- Ouvrir `c:\wamp64\bin\php\php8.3.x\php.ini`.
- **Relever les valeurs personnalisées** :
  - `date.timezone`
  - `memory_limit`
  - `upload_max_filesize`
  - `post_max_size`
  - `max_execution_time`
- **Relever les extensions activées** (lignes décommentées `extension=...`).
- **Noter les extensions tierces** installées manuellement (ex: Xdebug, Redis, Imagick).

### 1.4 — Sauvegarder les Virtual Hosts Apache
- Copier les fichiers suivants :
  - `c:\wamp64\bin\apache\apache2.4.x\conf\extra\httpd-vhosts.conf`
  - `c:\wamp64\bin\apache\apache2.4.x\conf\httpd.conf` (si modifié).

### 1.5 — Renommer le dossier WampServer existant
- **Quitter WampServer** complètement (clic droit sur l’icône → **Quitter**).
- Renommer `c:\wamp64\` en `c:\wamp64_backup\`.
  - *Pourquoi ?* Cela permet de **revenir en arrière** en cas de problème, sans rien désinstaller.

---

---

## 🛠️ **PHASE 2 — Prérequis : Visual C++ Redistributables**
### 2.1 — Télécharger l’outil de vérification
- Télécharger [check_vcredist.exe](https://wampserver.aviatechno.net/files/tools/check_vcredist.exe).
- **Lancer en tant qu’administrateur** et noter les packages manquants.

### 2.2 — Installer les packages manquants
- Télécharger le **.exe all-in-one** depuis [abbodi1406/vcredist](https://github.com/abbodi1406/vcredist/releases).
- **Lancer en tant qu’administrateur**.
- Si Windows est en **64 bits**, installer **les deux versions (32 et 64 bits)** de chaque package.

### 2.3 — Vérifier l’installation
- Relancer `check_vcredist.exe` pour confirmer que **tout est au vert** avant de continuer.

---

---

## 🗑️ **PHASE 3 — Désinstallation propre de WampServer 3.3.7**
### 3.1 — Désinstaller via Windows
- Aller dans **Panneau de configuration** → **Programmes** → **Désinstaller un programme**.
- Sélectionner **WampServer** → **Désinstaller**.
- **⚠️ Attention** : Ne **pas installer WampServer par-dessus une version existante** (risque d’installation défectueuse).

### 3.2 — Vérifier la désinstallation
- S’assurer que `c:\wamp64\` **n’existe plus** (ou a bien été renommé à l’étape 1.5).
- Vérifier dans **services.msc** qu’aucun service **wamp/apache/mysql** ne tourne encore.

---

---

## 🆕 **PHASE 4 — Installation de WampServer 3.4.0**
### 4.1 — Télécharger WampServer 3.4.0
- Aller sur [wampserver.com](https://www.wampserver.com) → Télécharger la version **64 bits**.
- Ou directement sur [wampserver.aviatechno.net](https://wampserver.aviatechno.net) pour la version complète avec tous les addons.

### 4.2 — Lancer l’installeur
- **Exécuter en tant qu’administrateur** (clic droit sur le `.exe`).
- Choisir le répertoire d’installation : **`c:\wamp64\`** (nouveau, propre).
- Suivre l’assistant jusqu’à la fin.

### 4.3 — Premier lancement
- Lancer WampServer via le **raccourci** (pas en double-cliquant sur l’exe directement).
- Attendre que l’icône passe au **vert** dans la barre des tâches.
- Vérifier [http://localhost](http://localhost) → La page d’accueil WampServer doit s’afficher.

---

---

## 🐘 **PHASE 5 — Installer et activer PHP 8.4 et PHP 8.3**
### 5.1 — Vérifier la disponibilité de PHP 8.4
- **PHP 8.4 n’est pas inclus par défaut** dans WampServer 3.4.0.
- Télécharger l’**addon PHP 8.4** depuis [wampserver.aviatechno.net](https://wampserver.aviatechno.net) si nécessaire.

### 5.2 — Installer PHP 8.4
- Extraire l’addon PHP 8.4 dans `c:\wamp64\bin\php\php8.4.x\`.
- Redémarrer WampServer.

### 5.3 — Vérifier la disponibilité de PHP 8.3
- **PHP 8.3 doit être disponible par défaut** dans WampServer 3.4.0.
- Si **PHP 8.3 n’apparaît pas** dans le menu WampServer :
  1. Télécharger l’**addon PHP 8.3** depuis [wampserver.aviatechno.net](https://wampserver.aviatechno.net).
  2. L’installer dans `c:\wamp64\bin\php\php8.3.x\`.
  3. Redémarrer WampServer.

### 5.4 — Basculer entre PHP 8.3 et PHP 8.4
- **Pour Symfony 6.3 (branche `main`)** :
  - Clic gauche sur l’icône WampServer → **PHP** → **Version** → Sélectionner **8.3.x**.
- **Pour Symfony 7.4 (branche de test)** :
  - Clic gauche sur l’icône WampServer → **PHP** → **Version** → Sélectionner **8.4.x**.
- WampServer redémarre automatiquement Apache à chaque changement.

### 5.5 — Vérifier les versions PHP
- Aller sur [http://localhost/?phpinfo=1](http://localhost/?phpinfo=1).
- Confirmer que **PHP 8.3.x** et **PHP 8.4.x** sont bien disponibles.

---

---

## ⚙️ **PHASE 6 — Reconfigurer PHP 8.4 et PHP 8.3**
### 6.1 — Configurer PHP 8.4 pour Symfony 7.4
- **Éditer le `php.ini` de PHP 8.4** : `c:\wamp64\bin\php\php8.4.x\php.ini`.
- **⚠️ Attention** : Ne jamais copier l’ancien `php.ini` par-dessus le nouveau.
- **Reporter les valeurs personnalisées** notées à l’étape **1.3** :
  ```ini
  date.timezone = Europe/Paris
  memory_limit = 256M
  upload_max_filesize = 64M
  post_max_size = 64M
  max_execution_time = 60
  ```
- **Activer les extensions nécessaires pour Symfony** :
  ```ini
  extension=intl
  extension=pdo_mysql
  extension=mbstring
  extension=openssl
  extension=curl
  extension=fileinfo
  extension=zip
  extension=sodium
  extension=xsl
  ```

### 6.2 — Configurer PHP 8.3 pour Symfony 6.3
- **Éditer le `php.ini` de PHP 8.3** : `c:\wamp64\bin\php\php8.3.x\php.ini`.
- Reporter les **mêmes valeurs personnalisées** que pour PHP 8.4 (si elles étaient identiques).
- Activer les **mêmes extensions** que pour PHP 8.4.

### 6.3 — Configurer Xdebug (si utilisé)
- **Xdebug 3.4+ est requis** pour PHP 8.4.
- Télécharger la version compatible depuis [xdebug.org](https://xdebug.org).
- Ajouter dans **les deux `php.ini`** (8.3 et 8.4) :
  ```ini
  zend_extension=php_xdebug.dll
  xdebug.mode=debug
  xdebug.start_with_request=yes
  xdebug.client_port=9003
  ```

### 6.4 — Redémarrer les services
- Clic gauche sur l’icône WampServer → **Redémarrer tous les services**.

---

---

## 🌐 **PHASE 7 — Restaurer les Virtual Hosts**
### 7.1 — Configurer les Virtual Hosts pour Symfony 6.3 et 7.4
- **Objectif** : Avoir **deux Virtual Hosts** distincts :
  - Un pour **Symfony 6.3 (PHP 8.3)**.
  - Un pour **Symfony 7.4 (PHP 8.4)**.

- **Éditer le fichier `httpd-vhosts.conf`** :
  ```apache
  # Virtual Host pour Symfony 6.3 (PHP 8.3)
  <VirtualHost *:80>
      ServerName symfony63.local
      DocumentRoot "c:/wamp64/www/symfony63/public"
      <Directory "c:/wamp64/www/symfony63/public">
          AllowOverride All
          Require all granted
      </Directory>
  </VirtualHost>

  # Virtual Host pour Symfony 7.4 (PHP 8.4)
  <VirtualHost *:80>
      ServerName symfony74.local
      DocumentRoot "c:/wamp64/www/symfony74/public"
      <Directory "c:/wamp64/www/symfony74/public">
          AllowOverride All
          Require all granted
      </Directory>
  </VirtualHost>
  ```

### 7.2 — Vérifier le fichier `hosts` de Windows
- Fichier : `C:\Windows\System32\drivers\etc\hosts`.
- Ajouter les entrées suivantes :
  ```plaintext
  127.0.0.1 symfony63.local
  127.0.0.1 symfony74.local
  ```
- **Éditer en tant qu’administrateur** si nécessaire.

### 7.3 — Redémarrer Apache
- Redémarrer Apache via WampServer.
- Vérifier que les deux vhosts répondent :
  - [http://symfony63.local](http://symfony63.local) (PHP 8.3).
  - [http://symfony74.local](http://symfony74.local) (PHP 8.4).

---

---

## 🗃️ **PHASE 8 — Restaurer les bases de données**
### 8.1 — Importer via phpMyAdmin
- Ouvrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
- **Créer les bases de données** avec les mêmes noms qu’avant.
- Pour chaque base : **Importer** → Sélectionner le fichier `.sql` sauvegardé.

### 8.2 — Vérifier les utilisateurs MySQL
- Vérifier que l’utilisateur MySQL du projet Symfony existe et a les bons droits :
  ```sql
  SELECT User, Host FROM mysql.user;
  ```
- Tester la connexion depuis Symfony :
  ```bash
  php bin/console doctrine:query:sql "SELECT 1"
  ```

---

---

## 🚀 **PHASE 9 — Tester Symfony 6.3 et Symfony 7.4**
### 9.1 — Tester Symfony 6.3 avec PHP 8.3
- **Basculer sur PHP 8.3** :
  - Clic gauche sur l’icône WampServer → **PHP** → **Version** → Sélectionner **8.3.x**.
- Accéder à [http://symfony63.local](http://symfony63.local).
- Vérifier que tout fonctionne :
  ```bash
  cd c:\wamp64\www\symfony63
  composer install
  php bin/console cache:clear
  php bin/console about
  ```

### 9.2 — Tester Symfony 7.4 avec PHP 8.4
- **Basculer sur PHP 8.4** :
  - Clic gauche sur l’icône WampServer → **PHP** → **Version** → Sélectionner **8.4.x**.
- Accéder à [http://symfony74.local](http://symfony74.local).
- **Vérifier la compatibilité** :
  ```bash
  cd c:\wamp64\www\symfony74
  composer install
  php bin/console cache:clear
  php bin/console about
  ```
- **Tester les fonctionnalités critiques** :
  - Endpoints API (si applicable).
  - Commandes CLI (`php bin/console`).
  - Envoi d’emails (SwiftMailer/Symfony Mailer).
  - Tâches cron ou workers (si applicable).

### 9.3 — Corriger les erreurs (si nécessaire)
- Si des erreurs apparaissent avec **Symfony 7.4 + PHP 8.4** :
  - Utiliser `composer outdated` et `phpstan` pour identifier les problèmes.
  - Mettre à jour les bundles incompatibles.
  - **Ne pas merger la branche Symfony 7.4** tant que les tests ne sont pas concluants.

### 9.4 — Test de performance (optionnel)
- Utiliser **[Blackfire](https://www.blackfire.io/)** ou **[XHProf](https://github.com/facebook/xhprof)** pour comparer les performances entre PHP 8.3 et PHP 8.4.

---

---

## 🧹 **PHASE 10 — Finalisation et nettoyage**
### 10.1 — Merger la branche Symfony 7.4 sur `main`
- **Une fois les tests validés** :
  ```bash
  git checkout main
  git merge symfony74
  git push
  ```

### 10.2 — Appliquer la mise à jour 3.4.2 (si disponible)
- La mise à jour **3.4.2 est cumulative** (pas besoin d’appliquer les versions intermédiaires).
- Télécharger la mise à jour sur [wampserver.aviatechno.net](https://wampserver.aviatechno.net) et l’appliquer.

### 10.3 — Supprimer le dossier de sauvegarde
- **Attendre au moins 48h** après validation complète avant de supprimer `c:\wamp64_backup\`.
- *Pourquoi ?* Ce dossier est votre **filet de sécurité** en cas de problème tardif.

### 10.4 — Documenter la migration
- Noter les **versions exactes** installées (WampServer, PHP, Apache, MySQL).
- Documenter les **problèmes rencontrés** et leurs solutions.
- Sauvegarder une copie du :
  - `php.ini` final pour PHP 8.3 et PHP 8.4.
  - Fichiers de configuration Apache (`httpd.conf`, `httpd-vhosts.conf`).

---

---

## 📝 **Annexe : Solutions aux problèmes courants**

| Problème | Cause possible | Solution |
|----------|----------------|----------|
| **Erreur PDO** (ex: `PDO::ATTR_EMULATE_PREPARES`) | PHP 8.4 active le mode strict pour PDO. | Ajouter dans `config/packages/doctrine.yaml` :
```yaml
doctrine:
    dbal:
        options:
            1002: true  # PDO::ATTR_EMULATE_PREPARES
``` |
| **Extension PHP manquante** | L’extension n’est pas activée dans `php.ini`. | Décommenter la ligne `extension=...` dans `php.ini` et redémarrer Apache. |
| **Problèmes de permissions** | Dossiers `var/`, `public/` non accessibles. | Exécuter :
```bash
icacls c:\wamp64\www\symfony63\var /grant Everyone:(OI)(CI)F
icacls c:\wamp64\www\symfony74\var /grant Everyone:(OI)(CI)F
``` |
| **MySQL ne démarre pas** | Conflit de port ou service bloqué. | Vérifier dans `services.msc` que **wampmysqld64** est démarré. |
| **Virtual Host non accessible** | Fichier `hosts` ou `httpd-vhosts.conf` mal configuré. | Vérifier les chemins dans `httpd-vhosts.conf` et le fichier `hosts`. |
| **Composer plante** | Version de Composer obsolète. | Mettre à jour Composer :
```bash
composer self-update
``` |
| **PHP 8.3 ou 8.4 n’apparaît pas dans WampServer** | Addon PHP non installé. | Télécharger et installer l’addon manquant depuis [wampserver.aviatechno.net](https://wampserver.aviatechno.net). |

---

---

## 💡 **Conseils finaux**
- **Ne pas supprimer `c:\wamp64_backup\`** avant d’avoir validé que tout fonctionne correctement pendant **au moins une session de travail complète**. 
- **Tester chaque étape** avant de passer à la suivante.
- **Documenter chaque modification** pour faciliter le débogage futur.
- **Prévoir un temps de rollback** si la migration échoue (ex: 1-2 heures).
- **Utiliser les Virtual Hosts** pour basculer facilement entre Symfony 6.3 (PHP 8.3) et Symfony 7.4 (PHP 8.4).

---

*Bon courage pour ta migration, Isabelle ! 🚀*