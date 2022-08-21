async function sendMessage() {
    const message = getAndClearText()
    const token = document.getElementById('tokenAuth').value;

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("chat_id", "1");
    urlencoded.append("text", message);

    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: urlencoded,
        redirect: 'follow'
    };

    await fetch("http://0.0.0.0:8080/api/messages", requestOptions)
        .then()
        .then()
        .catch(error => console.log('error', error));

    const list = document.getElementById("list")
    const yes = boolScroll(list)
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