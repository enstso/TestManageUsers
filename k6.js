import http from "k6/http";
import { check, sleep } from "k6";

// Configuration du test
export const options = {
  thresholds: {
    // Vérifier que 99% des requêtes prennent moins de 3s
    http_req_duration: ["p(99) < 3000"],
  },
  stages: [
    { duration: "30s", target: 500 }, // Monter à 500 utilisateurs en 30s
    { duration: "1m", target: 500 },  // Maintenir 500 utilisateurs pendant 1 minute
    { duration: "20s", target: 0 },  // Redescendre à 0 en 20s
  ],
};

// Comportement simulé des utilisateurs
export default function () {
  // Données du formulaire sous forme d'un objet
  let formdata = {
    name: "test",
    email: "test@outlook.fr",
    date: "2023-10-01",
  };

  // Spécification des en-têtes pour le multipart/form-data
  let params = {
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  };

  // Envoi de la requête POST
  let res = http.post("http://host.docker.internal:80/indexex3.html", formdata, params);
  // Vérification du statut HTTP
// Vérification du statut HTTP
check(res, { "status was 200": (r) => r.status === 200 });  
  sleep(1); // Pause de 1 seconde entre chaque requête
}
