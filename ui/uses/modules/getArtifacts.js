import { API_ORIGIN } from "./publicEnvironmentVariables.js";

function getArtifacts() {
  fetch("https://" + API_ORIGIN + "/artifacts.php", {
    method: "GET",
    credentials: "include",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.authenticated == false) {
        location.href = "/login.php?action=logout";
      } else {
        const titleSelect = document.querySelector("select#Title");
        titleSelect.innerHTML = "";
        for (let i = 0; i < data.artifacts.length; i++) {
          let option = document.createElement("option");
          option.value = data.artifacts[i].id;
          option.innerText = data.artifacts[i].Title;
          titleSelect.append(option);
        }
      }
    });
}

getArtifacts();
