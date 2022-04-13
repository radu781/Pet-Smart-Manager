class Calendar {
    constructor() {
        this.calendar = document.getElementById("calendar")
        this.rows = document.querySelectorAll(".row")
        this.header = document.querySelector("#header")
        this.currentDate = new Date()
        this.startingPosition = this.getStart()
        this.endingPosition = this.getEnd(this.currentDate.getFullYear(), this.currentDate.getMonth())

        header.innerHTML = `${this.currentDate.toLocaleString("default", { month: "long" })} ${this.currentDate.getFullYear()}`

        this.dayCells = []
        for (let row of this.rows) {
            for (let cell of row.childNodes) {
                if (cell.innerText === "") {
                    this.dayCells.push(cell)
                }
            }
        }
    }

    getStart() {
        const currentDay = this.currentDate.toLocaleDateString("default", { weekday: "long" })
        const days = [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        ]
        let index = 0
        for (const day of days) {
            if (currentDay === day) {
                return index
            }
            index++
        }
    }

    getEnd(year, month) {
        return new Date(year, month, 0).getDate();
    }

    setDates() {
        let val = 1
        for (let i = 0; i < this.startingPosition; i++) {
            const element = this.dayCells[i];
            element.innerHTML = "&nbsp;"
            element.style.background = "rgb(128, 128, 128)"
        }
        for (let i = this.startingPosition; i < this.endingPosition; i++) {
            const element = this.dayCells[i];
            element.innerHTML = val++
        }
        for (let i = this.endingPosition; i < this.dayCells.length; i++) {
            const element = this.dayCells[i];
            element.style.background = "rgb(128, 128, 128)"
            element.innerHTML = "&nbsp;"
        }
    }

    markToday() {
        const today = this.currentDate.getDate()
        for (const cell of this.dayCells) {
            if (cell.innerText === today.toString()) {
                cell.style.background = "rgb(160, 160, 160)"
                break
            }
        }
    }
}

let calendar = new Calendar()
calendar.setDates()
calendar.markToday()