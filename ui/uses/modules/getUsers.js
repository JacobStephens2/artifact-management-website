function addUserInputAndButton(event) {
  event.preventDefault();
  let inputs = document.querySelectorAll("input.addUser");

  let input = document.createElement("input");
  input.setAttribute("id", "User" + inputs.length);
  input.setAttribute("name", "User[]");
  input.classList.add("user");

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

  let div = document.createElement("div");
  div.setAttribute("id", "SwSDiv" + inputs.length);
  div.classList.add("sweetSpot");
  div.append(input);
  div.append(button);

  let sweetSpotSection = document.querySelector("section#sweetSpots");
  sweetSpotSection.appendChild(div);
}

document
  .querySelector("button#addUser")
  .addEventListener("click", addUserInputAndButton)
;
