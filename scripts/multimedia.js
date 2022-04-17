const numberOfFields = 20
const columns = 5
const expectedSize = 100
const main = document.querySelector(".main")
const mainContent = document.querySelector(".main-content")
const availableWidth = (mainContent.clientWidth - mainContent.style.margin * 2 - mainContent.style.padding * 2) / 2 - 100
const samplePetSources = [
    { "src": "https://cdn.pixabay.com/photo/2021/10/19/10/56/cat-6723256_960_720.jpg", "alt": "cat", "desc": "this is a dog" },
    { "src": "https://cdn.pixabay.com/photo/2014/10/01/10/44/hedgehog-468228_960_720.jpg", "alt": "hedgehog", "desc": "same for a hedgehog" },
    { "src": "https://cdn.pixabay.com/photo/2019/08/19/07/45/dog-4415649_960_720.jpg", "alt": "dog", "desc": "another dog, not the same for sure" },
    { "src": "https://cdn.pixabay.com/photo/2020/10/03/11/08/girl-5623231_960_720.jpg", "alt": "dog", "desc": "girl with dog, the pet is happy" },
    { "src": "https://cdn.pixabay.com/photo/2013/10/17/20/59/horse-197199_960_720.jpg", "alt": "horse", "desc": "horses are fun" },
    { "src": "https://cdn.pixabay.com/photo/2020/04/07/20/36/bunny-5014814_960_720.jpg", "alt": "bunny", "desc": "rabbits are fluffy and jumpy" },
    { "src": "https://cdn.pixabay.com/photo/2016/03/05/18/54/animal-1238228_960_720.jpg", "alt": "rat", "desc": "rats are not always gross" },
    { "src": "https://cdn.pixabay.com/photo/2018/06/19/12/03/fish-3484346_960_720.jpg", "alt": "axolotl", "desc": "axolotls are weird but cute in a way" }
]

function refresh() {
    for (let i = 0; i < availableWidth / expectedSize; i++) {
        const newNode = document.createElement("div")
        const textNode = document.createTextNode("")
        newNode.appendChild(textNode)
        newNode.classList.add("column")
        main.appendChild(newNode)
    }

    const cols = document.querySelectorAll(".column")
    for (const col of cols) {
        for (let i = 0; i < columns; i++) {
            const newNode = document.createElement("div")
            const textNode = document.createTextNode("")
            newNode.appendChild(textNode)
            newNode.classList.add("cell")
            col.appendChild(newNode)
        }
    }

    const cells = document.querySelectorAll(".cell")
    for (const cell of cells) {
        const imgNode = document.createElement("img")
        const index = parseInt(Math.random() * samplePetSources.length)
        imgNode.src = samplePetSources[index].src
        imgNode.alt = samplePetSources[index].alt
        cell.appendChild(imgNode)
        const pNode = document.createElement("p")
        const textNode = document.createTextNode(samplePetSources[index].desc)
        pNode.appendChild(textNode)
        cell.appendChild(pNode)
    }
}
refresh()