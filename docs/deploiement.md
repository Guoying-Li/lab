# 📦 Documentation de déploiement – Emprunthèque

Cette documentation vise à faciliter le déploiement, la maintenance et les futures mises à jour du site Emprunthèque.

---

## 🔧 Prérequis serveur

- **OS** : Ubuntu 22.04 LTS
- **Webserver** : Apache 2.4 ou Nginx 1.18+
- **PHP** : 8.2 minimum avec les extensions :
  - pdo_mysql
  - intl
  - mbstring
  - xml
  - curl
  - zip
  - openssl
- **Base de données** : MariaDB ou MySQL ≥ 10.3
- **Autres outils** :
  - Composer ≥ 2.0
  - Node.js ≥ 18 + npm
  - Git
  - Accès SSH au serveur

---

## 🚀 Étapes de déploiement

1. **Connexion au serveur**
  
2. **Récupération du code via git clone ou git pull**

3. **Installation des dépendances PHP avec composer install --no-dev --optimize-autoloader**

4. **Configuration de l’environnement (.env.local) : base de données, clés API, etc.**

5. **Migrations de base de données via Doctrine (cf. ci-dessous)**

6. **Compilation des assets front-end avec npm install puis npm run build**

7. **Configuration du serveur web (Apache/Nginx + SSL via Let's Encrypt)**

8. **Mise en place des permissions sur les dossiers var/ et public/**

9. **Redémarrage du serveur ou rechargement des services si nécessaire**

🧾 Scripts de migration et commandes Symfony utiles
php bin/console doctrine:migrations:migrate : applique les migrations

php bin/console cache:clear : vide le cache

php bin/console assets:install public : copie les assets

php bin/console messenger:consume async -vv : lance les workers (si utilisés)

🔁 Procédures de rollback en cas de problème
Sauvegarde préalable de la base de données avant chaque déploiement :
mysqldump -u user -p dbname > backup.sql

Restaurer une sauvegarde en cas de besoin :
mysql -u user -p dbname < backup.sql

Possibilité de revenir à une version précédente via Git :
git checkout <tag-ou-commit> + redéploiement

👥 Contacts techniques 
[Guoying LI] – Développeuse principale 


Lien vers le dépôt Git : [(https://github.com/Guoying-Li/lab.git)]


