class Calendar {
    constructor() {
        this.days = [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        ]

        this.feedingTimes = []
        const tableFeedTimes = document.querySelector(".cell")
        const feed = tableFeedTimes.children;
        for (let i = 1; i < feed.length; i++) {
            const pet = feed[i]
            const name = pet.innerHTML.substring(6)
            this.feedingTimes.push({
                "feedTime": pet.innerHTML.substring(0, 5),
                "name": name
            })
        }
        this.feedingTimes.sort((left, right) => left.feedTime > right.feedTime)


        this.refreshFeed();
        this.rows = document.querySelectorAll(".row")
        this.header = document.querySelector("#header-date")
        this.currentDate = new Date()
        this.selectedDate = this.currentDate

        this.setHeader()

        this.dayCells = []
        for (let row of this.rows) {
            for (let cell of row.childNodes) {
                this.dayCells.push(cell)
            }
        }

        const mainTable = document.querySelector("#feed-values")
        const mainContent = document.querySelector(".main-content")
        mainContent.removeChild(mainTable)
    }

    simpleHash(str) {
        let hash = 0;
        for (let i = 0, len = str.length; i < len; i++) {
            let chr = str.charCodeAt(i);
            hash = (hash << 5) - hash + chr;
            hash |= 0;
        }
        return hash;
    }

    refreshFeed(rows, calendarBody, cols) {
        for (let i = 0; i < rows; i++) {
            const row = document.createElement("div")
            row.classList.add("row")
            calendarBody.appendChild(row)
            for (let j = 0; j < cols; j++) {
                const cell = document.createElement("div")
                cell.classList.add("cell")
                const textField = document.createElement("div")
                textField.classList.add("calendar-day")
                cell.appendChild(textField)

                for (let i = 0; i < this.feedingTimes.length; i++) {
                    const feed = document.createElement("div")
                    feed.classList.add("feed")
                    feed.innerHTML = this.feedingTimes[i].feedTime.slice(0, 5) + " - " + this.feedingTimes[i].name
                    feed.style.backgroundColor = this.feedingTimes[i].bgColor
                    cell.appendChild(feed)
                }
                row.appendChild(cell)
            }
        }
    }

    getStart() {
        const firstDate = new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth(), 1)
        const firstDay = firstDate.toLocaleDateString("default", { weekday: "long" })

        let index = 0
        for (const day of this.days) {
            if (firstDay === day) {
                return index
            }
            index++
        }
    }

    getEnd(year, month) {
        return new Date(year, month, 0).getDate();
    }

    isSameMonth() {
        return (this.currentDate.getFullYear() === this.selectedDate.getFullYear() &&
            this.currentDate.getMonth() === this.selectedDate.getMonth())
    }

    setHeader() {
        if (this.isSameMonth()) {
            this.header.innerHTML = `${this.selectedDate.toLocaleString("default", { month: "long" })} ${this.selectedDate.getFullYear()}`
        } else {
            this.header.innerHTML = `${this.selectedDate.toLocaleString("default", { month: "long" })} ${this.selectedDate.getFullYear()}<br>Go to today`
        }
    }

    setDates() {
        const startingPosition = this.getStart()
        const endingPosition = this.getEnd(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1)

        let prevVal = this.getEnd(this.selectedDate.getFullYear(), this.selectedDate.getMonth())
        for (let i = startingPosition - 1; i >= 0; i--) {
            const element = this.dayCells[i]
            if (element.nodeName == "#text") {
                continue
            }
            this.markWeekend(element, i)
            element.style.background = "var(--darkgreen)"
            element.firstChild.innerHTML = prevVal--
        }

        let val = 1
        for (let i = startingPosition; i < endingPosition + startingPosition; i++) {
            const element = this.dayCells[i]
            if (element.nodeName == "#text") {
                continue
            }
            element.style.background = "var(--yellow)"
            this.markWeekend(element, i)
            element.firstChild.innerHTML = val++
        }
        val = 1
        for (let i = endingPosition + startingPosition; i < this.dayCells.length; i++) {
            const element = this.dayCells[i]
            if (element.nodeName == "#text") {
                continue
            }
            this.markWeekend(element, i)
            element.style.background = "var(--darkgreen)"
            element.firstChild.innerHTML = val++
        }

        const bottomLeft = calendar.dayCells[calendar.dayCells.length - 7]
        if (bottomLeft.nodeName === "#text") {
            return
        }
        bottomLeft.style.borderBottomLeftRadius = "10px"
        const bottomRight = calendar.dayCells[calendar.dayCells.length - 1]
        bottomRight.style.borderBottomRightRadius = "10px"

        this.markToday()
    }
    markWeekend(element, index) {
        switch (index % 7) {
            case 6:
                element.style.background = "#ccc19b"
                break
            case 5:
                element.style.background = "#ccc19b"
                break
            default:
                break
        }
    }

    markToday() {
        const days = document.querySelectorAll(".calendar-day")
        if (!this.isSameMonth()) {
            for (const day of days) {
                day.style.background = "none"
                day.style.border = "none"
            }
            return
        }
        const today = this.currentDate.getDate()
        for (const cell of days) {
            if (cell.innerText === today.toString() && this.isSameMonth()) {
                cell.style.background = "var(--lightgreen)"
                cell.style.borderRadius = "10px"
                cell.style.border = "1px solid var(--darkgreen)"
            } else if (cell.innerText === today.toString()) {}
        }
    }

    makeButtons() {
        let prevBtn = document.querySelector("#prev-month-button")
        prevBtn.addEventListener("click", () => {
            this.selectedDate = new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth() - 1)
            this.setHeader()
            this.setDates()
        })

        let nextBtn = document.querySelector("#next-month-button")
        nextBtn.addEventListener("click", () => {
            this.selectedDate = new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1)
            this.setHeader()
            this.setDates()
        })

        let todayBtn = document.querySelector("#header-date")
        todayBtn.addEventListener("click", () => {
            this.selectedDate = this.currentDate
            this.setHeader()
            this.setDates()
        })
    }
}

let calendar = new Calendar()
calendar.setDates()
calendar.makeButtons()

function onPetFilterChanged() {
    const checkboxes = document.getElementsByName("pet-filter")
    const feedDivs = document.querySelectorAll(".feed")

    let names = []
    for (const time of calendar.feedingTimes) {
        for (const box of checkboxes) {
            if (time.name === box.defaultValue && box.checked) {
                names.push(time.name)
            }
        }
    }

    if (names !== []) {
        for (const feedDiv of feedDivs) {
            if (!findAny(names, feedDiv.innerHTML)) {
                feedDiv.style.display = "none"
            } else {
                feedDiv.style.display = "block"
            }
        }
    }
    calendar.refreshFeed()
}

function findAny(array, str) {
    for (const item of array) {
        if (str.indexOf(item) !== -1) {
            return true
        }
    }
    return false
}
let clickedItems = {}

function onFeedCellClicked(id) {
    if (clickedItems[id]) {
        return
    }
    clickedItems[id] = true
    let currentCell = document.getElementById(id)
    let oldValue = currentCell.innerHTML.substring(0, 5)
    currentCell.innerHTML = ""
    let form = document.createElement("form")
    form.method = "POST"
    let input = document.createElement("input")
    input.type = "text"
    input.name = `update${id}`
    input.required = "true"
    input.value = oldValue
    form.appendChild(input)
    currentCell.append(form)
}