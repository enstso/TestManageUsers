# Utiliser l'image officielle de k6
FROM grafana/k6

# Définir le répertoire de travail
WORKDIR /usr/src/app

# Copier le script de test dans le conteneur
COPY . .

EXPOSE 8080

# Exécuter k6 avec le script de test
ENTRYPOINT ["k6", "run", "/usr/src/app/k6.js"]

#docker run --rm -v ${PWD}\results:/usr/src/app/results -p 8080:8080 dock-k6