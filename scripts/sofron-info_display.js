const infoButton = document.getElementById("info");
var infoPanel = document.querySelectorAll(".informations");

infoButton.addEventListener('click', () => {
    for(let index = 0; index < infoPanel.length; index++)
        infoPanel[index].classList.toggle('display');
    infoButton.classList.toggle('accessed');
})