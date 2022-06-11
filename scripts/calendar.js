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

        const backgroundColors = ["#025DF5", "#03A3FF", "#0ED2E8", "#03FFD3", "#02F586"]
        this.feedingTimes = []
        const tableFeedTimes = document.querySelectorAll(".feed-time-cell")
        for (let i = 0; i < tableFeedTimes.length; i += 4) {
            const petId = tableFeedTimes[i + 1].innerHTML.trim()
            this.feedingTimes.push({
                "id": tableFeedTimes[i].innerHTML.trim(),
                "pet_id": petId,
                "feedTime": tableFeedTimes[i + 2].innerHTML.trim(),
                "bgColor": backgroundColors[this.simpleHash(petId.toString()) % backgroundColors.length],
                "name": tableFeedTimes[i + 3].innerHTML.trim()
            })
        }
        this.feedingTimes.sort((left, right) => left.feedTime > right.feedTime)


        this.generateCells()
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

    generateCells() {
        const days = document.querySelector("#days")
        const rows = 7
        const columns = 6

        for (let i = 0; i < rows; i++) {
            const dayNode = document.createElement("div")
            const textNode = document.createTextNode(this.days[i])
            dayNode.appendChild(textNode)
            dayNode.classList.add("day")
            days.appendChild(dayNode)
        }

        const calendarBody = document.querySelector("#calendar-body")

        this.refreshFeed(columns, calendarBody, rows)
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

                for (let i = 0; i < Math.min(5, this.feedingTimes.length); i++) {
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
            element.style.background = "var(--darkgreen)"
            this.setBorder(element, i)
            element.firstChild.innerHTML = prevVal--
        }

        let val = 1
        for (let i = startingPosition; i < endingPosition + startingPosition; i++) {
            const element = this.dayCells[i]
            element.style.background = "var(--yellow)"
            this.setBorder(element, i)
            element.firstChild.innerHTML = val++
        }
        val = 1
        for (let i = endingPosition + startingPosition; i < this.dayCells.length; i++) {
            const element = this.dayCells[i]
            element.style.background = "var(--darkgreen)"
            this.setBorder(element, i)
            element.firstChild.innerHTML = val++
        }

        const bottomLeft = calendar.dayCells[calendar.dayCells.length - 7]
        bottomLeft.style.borderBottomLeftRadius = "10px"
        const bottomRight = calendar.dayCells[calendar.dayCells.length - 1]
        bottomRight.style.borderBottomRightRadius = "10px"

        this.markToday()
    }
    setBorder(element, index) {
        switch (index % 7) {
            case 6:
                element.style.border = "1px solid red"
                element.style.borderLeft = "none"
                break
            case 5:
                element.style.border = "1px solid red"
                element.style.borderRight = "none"
                break
            default:
                element.style.border = "none"
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
            if (time.pet_id === box.id && box.checked) {
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
