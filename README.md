monAppliSymf

Bienvenue dans le projet monAppliSymf ! Ce document vous guidera à travers l'installation, la configuration et le lancement de l'application.
Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

    PHP 8.2 ou supérieur : Vérifiez avec php -v
    Composer : Vérifiez avec composer --version
    Symfony CLI : Vérifiez avec symfony --version
    MySQL ou PostgreSQL : Vérifiez avec mysql --version ou psql --version
    Apache ou Nginx : Vérifiez avec apache2 -v ou nginx -v

Installation

    Cloner le projet :

git clone https://github.com/Cloudm99/monAppliSymf.git
cd monAppliSymf

Installer les dépendances :

composer install

Configurer les variables d'environnement :

    Copiez le fichier .env.example en .env :

        cp .env.example .env

        Modifiez le fichier .env pour configurer les paramètres de votre base de données et autres variables d'environnement.

Configuration

    Configurer la base de données :
        Assurez-vous que votre base de données est en cours d'exécution.
        Mettez à jour les paramètres de connexion à la base de données dans le fichier .env :

    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Exécuter les migrations :

php bin/console doctrine:migrations:migrate

Charger les fixtures :

    php bin/console doctrine:fixtures:load

Lancement

    Démarrer le serveur de développement :

    symfony server:start

    Accéder à l'application :
        Ouvrez votre navigateur et accédez à http://localhost:8000.

Documentation

Pour plus de détails sur le code et les fonctionnalités de l'application, consultez la documentation interne : docs/build/index.html
