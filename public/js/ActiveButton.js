function empty() {
    const text = document.getElementById("message").value
    return text === ""
}

window.onload = function () {
    const button = document.getElementById("sendButton")
    button.setAttribute("disabled", true)

    const text = document.getElementById("message")
    text.addEventListener('input', function () {
        if (empty()) {
            button.setAttribute("disabled", true)
        } else {
            button.removeAttribute("disabled")
        }
    })
}

