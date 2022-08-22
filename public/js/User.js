function addUser(name, id) {
    const list = getUserList()
    list.appendChild(newUser(name, id))
}

function getUserList() {
    const userList = document.getElementById("user-list")
    return userList
}

function newUser(name, id) {
    var container = document.createElement("LI")
    container.innerHTML = userHTML(name, id)
    return container
}

function userHTML(name, id) {
    return '<li id=user_' + id + ' class="p-2 border-bottom"> \
            <div class="d-flex flex-row" > \
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" \
                    alt="avatar" \
                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" \
                    width="60"> \
                    <div class="pt-1"> \
                        <p class="fw-bold mb-0">' + name + '</p> \
                    </div> \
                    <button id="down" onclick="down('+ id + ')" type="button" class="btn btn-info btn-rounded float-right" style="margin: 0 0 0 auto">+</button> \
                    </div> \
            </li>'
}
