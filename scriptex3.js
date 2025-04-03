document.addEventListener("DOMContentLoaded", function () {
  const userForm = document.getElementById("userForm");
  const userList = document.getElementById("userList");
  const userIdField = document.getElementById("userId");

  function fetchUsers() {
    fetch("src/api.php")
      .then((response) => response.json())
      .then((users) => {
        userList.innerHTML = "";
        users.forEach((user) => {
          const li = document.createElement("li");
          li.innerHTML = `${user.name} (${user.email} | ${user.date})
                        <button onclick="editUser(${user.id}, '${user.name}', '${user.email}')">✏️</button>
                        <button onclick="deleteUser(${user.id})">❌</button>`;
          userList.appendChild(li);
        });
      });
  }

  userForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const dateInput = document.getElementById("date");
    const today = new Date().toISOString().split("T")[0];
    // Si la date est vide, on met la date d'aujourd'hui
    if (!dateInput.value) {
      dateInput.value = today;
    }
    const userId = userIdField.value;

    if (userId) {
      fetch("src/api.php", {
        method: "PUT",
        body: new URLSearchParams({
          id: userId,
          name,
          email,
          date: dateInput.value,
        }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      }).then(() => {
        fetchUsers();
        userForm.reset();
        userIdField.value = "";
      });
    } else {
      fetch("src/api.php", {
        method: "POST",
        body: new URLSearchParams({ name, email, date: dateInput.value }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      }).then(() => {
        fetchUsers();
        userForm.reset();
      });
    }
  });

  window.editUser = function (id, name, email) {
    document.getElementById("name").value = name;
    document.getElementById("email").value = email;
    const dateInput = (document.getElementById("date").value = date);
    const today = new Date().toISOString().split("T")[0];
    // Si la date est vide, on met la date d'aujourd'hui
    if (!dateInput.value) {
      dateInput.value = today;
    }
    userIdField.value = id;
  };

  window.deleteUser = function (id) {
    fetch(`src/api.php?id=${id}`, { method: "DELETE" }).then(() =>
      fetchUsers()
    );
  };

  fetchUsers();
});
