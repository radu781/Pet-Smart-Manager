var petCard = document.querySelectorAll(".pet");
var deleteImg = document.querySelectorAll(".delete");

petCard.addEventListener('mouseover', () => {
   for(var index = 0; index < deleteImg.length; index++)
        deleteImg[index].classList.toggle('display');
})