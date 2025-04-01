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
  const formdata = new FormData();
formdata.append("name", "test");
formdata.append("email", "test@outllok.fr");
  let res = http.post("http://host.docker.internal:80/",formdata);  //J'utilise un conteneur pour pouvoir requété localhost:8000, je dois passer par cette url
  
  // Vérification du statut HTTP
  check(res, { "status was 400": (r) => r.status === 400 });
  
  sleep(1); // Pause de 1 seconde entre chaque requête
}
