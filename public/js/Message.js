function sendMessage() {
    const message = getAndClearText()
    const sender = getSender()
    const card = createMessage(sender, message)
    const list = document.getElementById("list")
    const yes = boolScroll(list)
    list.appendChild(card)
    disabledButton()
    if (yes) {
        list.scrollTop = list.scrollHeight
    }
}

function getAndClearText() {
    const text = document.getElementById("message")
    const message = text.value
    text.value = ""
    return message
}

function getSender() {
    return "Brad Pitt"
}

function createMessage(sender, text) {
    var container = document.createElement("LI")
    container.innerHTML = messageBox(sender, text)
    return container.firstChild
}

function messageBox(sender, text) {
    return '<li class="d-flex justify-content-between mb-4"> \
    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" \
        class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60"> \
    <div class="card"> \
        <div class="card-header d-flex justify-content-between p-3"> \
            <p class="fw-bold mb-0">'+ sender + '</p> \
            <p class="text-muted small mb-0"><i class="far fa-clock"></i> 10 mins ago</p> \
        </div> \
        <div class="card-body"> \
            <p class="mb-0">'+ text + '</p> \
        </div> \
    </div> \
</li>'
}

function disabledButton() {
    const button = document.getElementById("sendButton")
    button.setAttribute("disabled", true)
}

function boolScroll(list) {
    return (
        list.scrollTop +
        parseInt(list.style.height.substring(0, list.style.height.length - 2)
        )
        === list.scrollHeight)
        ? true : false
}