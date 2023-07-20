import { API_ORIGIN } from "./publicEnvironmentVariables.js";

// Search artifacts

function searchUsers(event) {
  var listposition = event.srcElement.dataset.listposition;
  let requestBody = {
    query: event.target.value,
    userid: event.srcElement.dataset.userid
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
        var selector = 'ul#userResults' + listposition;
        var userResultsList = document.querySelector(selector);
        userResultsList.innerHTML = '';
        if (event.target.value.length === 0) {
          clearSearchResults(listposition);
        } else {
          showSearchResults(listposition);
          if (data.users.length > 10) {
            var userSearchResultsListLength = 10;
          } else {
            var userSearchResultsListLength = data.users.length;
          }
          for (let i = 0; i < userSearchResultsListLength; i++) {
            let listItem = document.createElement("li");
            listItem.value = data.users[i].id;
            listItem.innerText = data.users[i].FirstName + ' ' + data.users[i].LastName;
            listItem.addEventListener('click', function() {
              document.querySelector('input#user' + listposition + 'id').value = data.users[i].id;
              document.querySelector('input#user' + listposition + 'name').value = data.users[i].FirstName + ' ' + data.users[i].LastName;
              clearSearchResults(listposition);
            });
            userResultsList.append(listItem);
          }
        }
      }
    });
}

const searchUsersInput = document.querySelectorAll("input.user");
searchUsersInput.forEach(element => element.addEventListener("input", searchUsers));

function clearSearchResults(position) {
  let selector = 'ul#userResults' + position;
  document.querySelector(selector).innerHTML = `<li></li>`;
  document.querySelector('div#userResultsDiv' + position).style.display = 'none';
}

function showSearchResults(position) {  
  let selector = 'div#userResultsDiv' + position;
  document.querySelector(selector).style.display = 'block';
}

searchUsersInput.forEach(element => element.addEventListener('focus', showSearchResults));