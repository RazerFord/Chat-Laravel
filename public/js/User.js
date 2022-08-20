//addUser()


function addUser() {
    const list = getUserList()
    list.appendChild(newUser())
}

function getUserList() {
    const userList = document.getElementById("user-list")
    return userList
}

function newUser() {
    var container = document.createElement("LI")
    container.innerHTML = userHTML('Kate Moss')
    return container
}

function userHTML(name) {
    return '<a href="#!" class="d-flex justify-content-between"> \
            <div class="d-flex flex-row" > \
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" \
                    alt="avatar" \
                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" \
                    width="60"> \
                    <div class="pt-1"> \
                        <p class="fw-bold mb-0">' + name + '</p> \
                        <p class="small text-muted">Lorem ipsum dolor sit.</p> \
                    </div> \
                </div> \
            <div class="pt-1"> \
                <p class="small text-muted mb-1">Yesterday</p> \
            </div> \
            </a >'  
}