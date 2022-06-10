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
        for (let i = 0; i < tableFeedTimes.length; i += 3) {
            const id = tableFeedTimes[i + 1].innerHTML.trim()
            this.feedingTimes.push({
                "id": tableFeedTimes[i].innerHTML.trim(),
                "pet_id": tableFeedTimes[i + 1].innerHTML.trim(),
                "feedTime": tableFeedTimes[i + 2].innerHTML.trim(),
                "bgColor": backgroundColors[this.simpleHash(id.toString()) % backgroundColors.length]
            })
        }


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
        const columns = 6

        for (let i = 0; i < columns; i++) {
            const dayNode = document.createElement("div")
            const textNode = document.createTextNode(this.days[i].slice(0, 3))
            dayNode.appendChild(textNode)
            dayNode.classList.add("day")
            days.appendChild(dayNode)
        }

        const rows = 7
        const calendarBody = document.querySelector("#calendar-body")

        for (let i = 0; i < columns; i++) {
            const row = document.createElement("div")
            row.classList.add("row")
            calendarBody.appendChild(row)
            for (let j = 0; j < rows; j++) {
                const cell = document.createElement("div")
                cell.classList.add("cell")
                const textField = document.createElement("div")
                textField.classList.add("calendar-day")
                cell.appendChild(textField)

                for (let i = 0; i < Math.min(3, this.feedingTimes.length); i++) {
                    const feed = document.createElement("div")
                    feed.classList.add("feed")
                    feed.innerHTML = this.feedingTimes[i].feedTime.slice(0, 5) + "id" + this.feedingTimes[i].pet_id
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
            element.style.border = "none"
            element.style.background = "var(--darkgreen)"
            element.firstChild.innerHTML = prevVal--
        }

        let val = 1
        for (let i = startingPosition; i < endingPosition + startingPosition; i++) {
            const element = this.dayCells[i]
            element.style.border = "none"
            element.style.background = "var(--yellow)"
            element.firstChild.innerHTML = val++
        }
        val = 1
        for (let i = endingPosition + startingPosition; i < this.dayCells.length; i++) {
            const element = this.dayCells[i]
            element.style.background = "var(--darkgreen)"
            element.style.border = "none"
            element.firstChild.innerHTML = val++
        }

        const bottomLeft = calendar.dayCells[calendar.dayCells.length - 7]
        bottomLeft.style.borderBottomLeftRadius = "10px"
        const bottomRight = calendar.dayCells[calendar.dayCells.length - 1]
        bottomRight.style.borderBottomRightRadius = "10px"

        this.markToday()
    }

    markToday() {
        if (!this.isSameMonth()) {
            return
        }
        const today = this.currentDate.getDate()
        for (const cell of this.dayCells) {
            if (cell.innerText === today.toString()) {
                cell.style.background = "var(--lightgreen)"
                cell.style.borderRadius = "10px"
                cell.style.border = "1px solid var(--darkgreen)"
                break
            }
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