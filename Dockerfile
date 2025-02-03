# Utiliser l'image officielle PHP avec Apache
FROM php:8.1-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Copier les fichiers de l'application dans le répertoire de travail d'Apache
COPY . .

# Copier une configuration personnalisée pour Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Vérifier la configuration et éviter le problème de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && apachectl configtest

# Exposer le port 80
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
