class Calendar {
    constructor() {
        this.rows = document.querySelectorAll(".row")
        this.header = document.querySelector("#header-date")
        this.currentDate = new Date()
        this.selectedDate = this.currentDate

        this.setHeader()

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
        const firstDate = new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth(), 1)
        const firstDay = firstDate.toLocaleDateString("default", { weekday: "long" })
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
            element.innerHTML = prevVal--
                element.style.background = "rgb(128, 128, 128)"
        }

        let val = 1
        for (let i = startingPosition; i < endingPosition + startingPosition; i++) {
            const element = this.dayCells[i]
            element.style.background = "rgb(216, 216, 216)"
            element.innerHTML = val++
        }
        val = 1
        for (let i = endingPosition + startingPosition; i < this.dayCells.length; i++) {
            const element = this.dayCells[i]
            element.style.background = "rgb(128, 128, 128)"
            element.innerHTML = val++
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
                cell.style.background = "rgb(160, 160, 160)"
                cell.style.borderRadius = "10px"
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