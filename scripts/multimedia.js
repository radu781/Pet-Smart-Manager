const numberOfFields = 20
const columns = 5
const main = document.querySelector(".main")

for (let i = 0; i < Math.ceil(numberOfFields / columns); i++) {
    const newNode = document.createElement("div")
    const textNode = document.createTextNode("")
    newNode.appendChild(textNode)
    newNode.classList.add("row")
    main.appendChild(newNode)
}

const rows = document.querySelectorAll(".row")
for (const row of rows) {
    for (let i = 0; i < columns; i++) {
        const newNode = document.createElement("div")
        const textNode = document.createTextNode("")
        newNode.appendChild(textNode)
        newNode.classList.add("cell")
        row.appendChild(newNode)
    }
}

const samplePetSources = [
    "https://cdn.pixabay.com/photo/2021/10/19/10/56/cat-6723256_960_720.jpg",
    "https://cdn.pixabay.com/photo/2014/10/01/10/44/hedgehog-468228_960_720.jpg",
    "https://cdn.pixabay.com/photo/2019/08/19/07/45/dog-4415649_960_720.jpg",
    "https://media.geeksforgeeks.org/wp-content/uploads/20190529122828/bs21.png"
]
const cells = document.querySelectorAll(".cell")
for (const cell of cells) {
    const node = document.createElement("img")
    const index = parseInt(Math.random() * samplePetSources.length)
    node.src = samplePetSources[index]
    cell.appendChild(node)
}
