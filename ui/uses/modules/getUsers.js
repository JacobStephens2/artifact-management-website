function addSweetSpotInputAndButton(event) {
  event.preventDefault();
  let inputs = document.querySelectorAll("input.sweetSpot");

  let input = document.createElement("input");
  input.setAttribute("id", "SwS" + inputs.length);
  input.setAttribute("name", "SwS[" + inputs.length + "]");
  input.classList.add("sweetSpot");

  let button = document.createElement("button");
  button.setAttribute("id", "RemoveSwS" + inputs.length);
  button.classList.add("sweetSpot");
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
  .querySelector("button#addSweetSpot")
  .addEventListener("click", addSweetSpotInputAndButton);
