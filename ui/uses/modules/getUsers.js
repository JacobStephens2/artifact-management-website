import { API_ORIGIN } from "./publicEnvironmentVariables.js";

function addUserInputAndButton(event) {
  // Prevent the button click from submitting the form
  event.preventDefault();

  // Get current inputs
  let inputs = document.querySelectorAll("input.user");

  // Create remove user button (-)
  let button = document.createElement("button");
  button.setAttribute("id", "RemoveUser" + inputs.length);
  button.classList.add("user");
  let selector = "#SwSDiv" + inputs.length;
  button.addEventListener("click", function (event) {
    event.preventDefault();
    let element = document.querySelector(selector);
    element.remove();
  });
  button.innerText = "-";

  // Create ul
  let ul = document.createElement("ul");
  ul.setAttribute("id", "userList" + inputs.length);
  ul.classList.add("user");

  // Create add user input
  let hiddenInput = document.createElement('input');
  hiddenInput.setAttribute("id", "user" + inputs.length + "id");
  hiddenInput.setAttribute("name", "user[" + inputs.length + "][id]");
  hiddenInput.setAttribute("type", "hidden");

  let input = document.createElement("input");
  input.setAttribute("id", "user" + inputs.length + "name");
  input.setAttribute("name", "user[" + inputs.length + "][name]");
  input.setAttribute("data-userid", document.querySelector('#user0name').dataset.userid);
  input.setAttribute("type", "search");
  input.classList.add("user");
  input.addEventListener("input", function(event){
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
          ul.innerHTML = '';
          if (event.target.value.length === 0) {
            document.querySelector('ul#userList' + inputs.length).style.display = 'none';
          } else {
            document.querySelector('ul#userList' + inputs.length).style.display = 'block';
            if (data.users.length > 10) {
              var userSearchResultsListLength = 10;
            } else {
              var userSearchResultsListLength = data.users.length;
            }
            for (let i = 0; i < userSearchResultsListLength; i++) {
              let li = document.createElement("li");
              li.value = data.users[i].id;
              li.innerText = data.users[i].FirstName + ' ' + data.users[i].LastName;
              li.addEventListener('click', function() {
                document.querySelector('input#user' + inputs.length + 'id').value = data.users[i].id;
                document.querySelector('input#user' + inputs.length + 'name').value = data.users[i].FirstName + ' ' + data.users[i].LastName;
                ul.style.display = 'none';
              });
              ul.append(li);
            }
          }
        }
      });
  });

  // Create div container
  let div = document.createElement("div");
  div.setAttribute("id", "SwSDiv" + inputs.length);
  div.classList.add("sweetSpot");

  // Append the input and button to the div
  div.append(input);
  div.append(hiddenInput);
  div.append(button);
  div.append(ul);

  // Append the div to the users section
  let sweetSpotSection = document.querySelector("section#users");
  sweetSpotSection.appendChild(div);
}

document
  .querySelector("button#addUser")
  .addEventListener("click", addUserInputAndButton)
;


