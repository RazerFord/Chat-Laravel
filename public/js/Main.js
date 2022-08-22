function empty() {
    const text = document.getElementById("message").value
    return text === ""
}

window.onload = function () {
    const button = document.getElementById("sendButton")
    button.setAttribute("disabled", true)

    const text = document.getElementById("message")
    text.addEventListener('input', function () {
        const tok = document.getElementById('token');

        if (empty() || tok === null) {
            button.setAttribute("disabled", true)
        } else {
            button.removeAttribute("disabled")
        }
    })

    const tok = document.getElementById('token');
    if (tok !== null) {
        token = tok.value
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

    search()
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
</li > '
}

function search() {
    const text = document.getElementById("search")
    const listUser = getUserList()
    var children = getArrayChild(listUser)

    text.addEventListener('input', (event) => {
        setTimeout(() => {
            if (text.value === "") {
                clearList(listUser)
                addChildren(listUser, children)
            } else {
                clearList(listUser)
                var myHeaders = new Headers();
                const tok = document.getElementById('tokenAuth')
                if (tok !== null) {
                    token = tok.value
                    myHeaders.append("Authorization", "Bearer " + token)

                    var requestOptions = {
                        method: 'GET',
                        headers: myHeaders,
                        redirect: 'follow'
                    };

                    console.log()

                    fetch("http://0.0.0.0:8080/api/users?name=" + text.value, requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            for (let obj of result.data) {
                                addUser(obj.name, obj.id)
                            }
                        })
                        .catch(error => console.log('error', error));
                }
            }
        }, 1000)
    })
}

function clearList(list) {
    while (list.firstChild) {
        list.removeChild(list.firstChild);
    }
}

function getArrayChild(list) {
    var newCh = []
    if (list.hasChildNodes()) {
        var children = list.childNodes;

        for (var i = 0; i < children.length; ++i) {
            newCh.push(children[i])
        }
    }
    return newCh
}

function addChildren(list, children) {
    for (var i = 0; i < children.length; ++i) {
        list.appendChild(children[i])
    }
}

function down(id) {
    const user = document.getElementById('user_' + id)

    const newMessage = document.getElementById('newMessage' + id)

    if (newMessage === null) {
        const div = document.createElement('div')
        div.setAttribute('style', 'margin-top:10px;')
        div.innerHTML = '<div id=newMessage' + id + ' class="d-flex flex-row" > \
    <input id="mintext" class="form-control" type="text" placeholder="Начать новый чат" style="animation-name: slidein; transition: width 1s cubic-bezier(0, 0, 1, 1) 500ms;"> \
                    <button onclick="sendMessageBox()" type="button" class="btn btn-info btn-rounded float-right" style="margin: 0 0 0 auto">Отправить</button> \
    </div>'
        user.appendChild(div)
    }
}

function sendMessageBox() {
    location.assign('http://0.0.0.0:8080/messages')
}