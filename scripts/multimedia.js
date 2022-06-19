function onCancelButtonClicked() {
    const div = document.querySelector("#form-div")
    const form = document.querySelector(".inline-form")
    const button = document.querySelector("#cancel-button")
    div.removeChild(form)
    div.removeChild(button)
}