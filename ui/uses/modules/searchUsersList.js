import { API_ORIGIN } from "./publicEnvironmentVariables.js";

// Search artifacts

function searchUsers(e) {
  let requestBody = {
    query: e.target.value,
  };
  fetch("https://" + API_ORIGIN + "/users.php", {
    method: "POST",
    credentials: "include",
    body: JSON.stringify(requestBody),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.authenticated == false) {
        location.href = "/login.php";
      } else {
        const userResultsList = document.querySelector('ul.userResults');
        userResultsList.innerHTML = '';
        if (e.target.value.length === 0) {
          hideSearchResults();
        } else {
          showSearchResults();
          if (data.users.length > 10) {
            var userSearchResultsListLength = 10;
          } else {
            var userSearchResultsListLength = data.users.length;
          }
          for (let i = 0; i < userSearchResultsListLength; i++) {
            let listItem = document.createElement("li");
            listItem.value = data.users[i].id;
            listItem.innerText = data.users[i].FullName;
            listItem.addEventListener('click', function() {
              document.querySelector('input#user0id').value = data.users[i].id;
              document.querySelector('input#user0name').value = data.users[i].FullName;
              hideSearchResults();
            });
            userResultsList.append(listItem);
          }
        }
      }
    });
}

const searchUsersInput = document.querySelector("input.user");
searchUsersInput.addEventListener("input", searchUsers);

// Show and hide search results

function showSearchResults() {
  document.querySelector('div.userResults').style.display = 'block';
}

function hideSearchResults() {
  document.querySelector('div.userResults').style.display = 'none';
}

searchUsersInput.addEventListener('focus', showSearchResults);
