import { API_ORIGIN } from "./publicEnvironmentVariables.js";

function searchArtifacts(e) {
  let requestBody = {
    query: e.target.value,
  };
  fetch("https://" + API_ORIGIN + "/artifacts.php", {
    method: "POST",
    credentials: "include",
    body: JSON.stringify(requestBody),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.authenticated == false) {
        location.href = "/login.php";
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

const searchTitlesInput = document.querySelector("input#SearchTitles");
searchTitlesInput.addEventListener("input", searchArtifacts);
