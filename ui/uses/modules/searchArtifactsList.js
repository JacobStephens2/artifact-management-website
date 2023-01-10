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
        const searchResultsList = document.querySelector('ul.searchResults');
        searchResultsList.innerHTML = '';
        if (data.artifacts.length > 10) {
          var resultsListLength = 10;
        } else {
          var resultsListLength = data.artifacts.length;
        }
        for (let i = 0; i < resultsListLength; i++) {
          let listItem = document.createElement("li");
          listItem.value = data.artifacts[i].id;
          listItem.innerText = data.artifacts[i].Title;
          searchResultsList.append(listItem);
        }
      }
    });
}

function changeDisplayOnFocus() {
  document.querySelector('div.searchResults').style.display = 'block';
}

function changeDisplayOnBlur() {
  document.querySelector('div.searchResults').style.display = 'block ';
}

function addSearchValueToSearchInput(event) {
  console.log(event);
  document.querySelector('input#SearchTitles').value = 1;
}
function addSearchValueTwoToSearchInput(event) {
  console.log(event);
  // Get value of target in event
  document.querySelector('input#SearchTitles').value = 2;
}

const searchTitlesInput = document.querySelector("input#SearchTitles");

searchTitlesInput.addEventListener('focus', changeDisplayOnFocus);

searchTitlesInput.addEventListener('blur', changeDisplayOnBlur);

searchTitlesInput.addEventListener("input", searchArtifacts);

document.querySelector('#result0').
  addEventListener('click', addSearchValueToSearchInput)
;
document.querySelector('#result1').
  addEventListener('click', addSearchValueTwoToSearchInput)
;