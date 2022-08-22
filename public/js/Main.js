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

    const token = document.getElementById('token').value;
    if (token !== null) {
        const centrifuge = new Centrifuge("ws://localhost:3001/connection/websocket", {
            token: token
        });
        console.log()
        centrifuge.on('connecting', function (ctx) {
            console.log(`connecting: ${ctx.code}, ${ctx.reason}`);
        }).on('connected', function (ctx) {
            console.log(`connected over ${ctx.transport}`);
        }).on('disconnected', function (ctx) {
            console.log(`disconnected: ${ctx.code}, ${ctx.reason}`);
        }).connect();

        const arrStr = document.location.pathname.split('/')
        const num = arrStr[arrStr.length - 1]
        const sub = centrifuge.newSubscription("chat#" + num);

        sub.on('publication', function (ctx) {
            addMessage(ctx.data)
        }).on('subscribing', function (ctx) {
            console.log(`subscribing: ${ctx.code}, ${ctx.reason}`);
        }).on('subscribed', function (ctx) {
            console.log('subscribed', ctx);
        }).on('unsubscribed', function (ctx) {
            console.log(`unsubscribed: ${ctx.code}, ${ctx.reason}`);
        }).subscribe();
    }
}

function addMessage(ctx) {
    const card = createMessage(ctx.name, ctx.text, ctx.created_at)
    const list = document.getElementById("list")
    const yes = boolScroll(list)
    list.appendChild(card)
    disabledButton()
    if (yes) {
        list.scrollTop = list.scrollHeight
    }
}

function createMessage(sender, text, data) {
    var container = document.createElement("LI")
    container.innerHTML = messageBox(sender, text, data)
    return container.firstChild
}

function messageBox(sender, text, data) {
    return '<li class="d-flex justify-content-between mb-4"> \
    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" \
        class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60"> \
    <div class="card"> \
        <div class="card-header d-flex justify-content-between p-3"> \
            <p class="fw-bold mb-0">'+ sender + '</p> \
            <p class="text-muted small mb-0"><i class="far fa-clock"></i>' + data + '</p> \
        </div> \
        <div class="card-body"> \
            <p class="mb-0">'+ text + '</p> \
        </div> \
    </div> \
</li>'
}

