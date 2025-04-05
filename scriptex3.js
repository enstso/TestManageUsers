// Exécute le script une fois que le DOM est complètement chargé
document.addEventListener("DOMContentLoaded", function () {
    // Récupération des éléments HTML nécessaires
    const userForm = document.getElementById("userForm");     // Formulaire d'ajout/mise à jour utilisateur
    const userList = document.getElementById("userList");     // Liste où seront affichés les utilisateurs
    const userIdField = document.getElementById("userId");    // Champ caché pour stocker l'ID lors de l'édition
  
    // Fonction pour récupérer tous les utilisateurs depuis l'API
    function fetchUsers() {
      fetch("src/apiex3.php") // Requête GET à l'API PHP
        .then((response) => response.json()) // Parse la réponse JSON
        .then((users) => {
          userList.innerHTML = ""; // Vide la liste avant de la re-remplir
  
          // Parcourt les utilisateurs et les ajoute à la liste
          users.forEach((user) => {
            const li = document.createElement("li"); // Crée un nouvel élément <li>
            
            // Remplit le <li> avec les infos de l'utilisateur + boutons d'action + ajout de la date
            li.innerHTML = `${user.name} (${user.email} | ${user.date})
                          <button onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.date}')">✏️</button>
                          <button onclick="deleteUser(${user.id})">❌</button>`;
            
            userList.appendChild(li); // Ajoute l'élément à la liste
          });
        });
    }
  
    // Événement lors de la soumission du formulaire
    userForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Empêche le rechargement de la page
  
      // Récupère les valeurs des champs du formulaire
      const name = document.getElementById("name").value;
      const email = document.getElementById("email").value;
      const dateInput = document.getElementById("date"); // Champ date
      const today = new Date().toISOString().split("T")[0]; // Format "YYYY-MM-DD"
  
      // Si aucun champ date n'est rempli, on met la date du jour
      if (!dateInput.value) {
        dateInput.value = today;
      }
  
      const userId = userIdField.value; // Récupère l'ID si en mode édition
  
      // Si un ID est présent, on met à jour un utilisateur
      if (userId) {
        fetch("src/apiex3.php", {
          method: "PUT", // Méthode PUT pour mise à jour
          body: new URLSearchParams({
            id: userId,
            name,
            email,
            date: dateInput.value,
          }),
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
        }).then(() => {
          fetchUsers(); // Rafraîchit la liste
          userForm.reset(); // Réinitialise le formulaire
          userIdField.value = ""; // Vide le champ caché ID
        });
  
      // Sinon, on ajoute un nouvel utilisateur
      } else {
        fetch("src/apiex3.php", {
          method: "POST", // Méthode POST pour ajout
          body: new URLSearchParams({ name, email, date: dateInput.value }),
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
        }).then(() => {
          fetchUsers(); // Rafraîchit la liste
          userForm.reset(); // Réinitialise le formulaire
        });
      }
    });
  
    // Fonction globale pour pré-remplir le formulaire lors d'une édition
    window.editUser = function (id, name, email, date) {
      document.getElementById("name").value = name;
      document.getElementById("email").value = email;
      document.getElementById("date").value = date; // Remplit le champ date
      userIdField.value = id; // Stocke l'ID dans le champ caché
    };
  
    // Fonction globale pour supprimer un utilisateur
    window.deleteUser = function (id) {
      // Envoie une requête DELETE à l'API
      fetch(`src/apiex3.php?id=${id}`, { method: "DELETE" }).then(() =>
        fetchUsers() // Rafraîchit la liste après suppression
      );
    };
  
    // Appelle fetchUsers() au chargement initial pour afficher les utilisateurs existants
    fetchUsers();
  });
  