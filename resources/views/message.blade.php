<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <!-- Bootstrap CSS (jsDelivr CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ asset('js/Message.js') }}"></script>
    <script src="{{ asset('js/ActiveButton.js') }}"></script>
    <script src="{{ asset('js/Search.js') }}"></script>
    <script src="{{ asset('js/User.js') }}"></script>
</head>

<body>
    <section style="background-color: rgb(255, 255, 255);">
        <div class="container py-1">
            <div class="row">
                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                    <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>

                    <div class="card">
                        <div class="card-body">
                            <input id="search" class="form-control" type="text" placeholder="Введите имя">
                            <ul id="user-list" class="list-unstyled mb-0" style="overflow-y:scroll; overflow-x:hidden; height:400px;">
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-7 col-xl-8">
                    <a href="{{ asset(route('logout')) }}">
                        <button type="button" class="btn btn-info btn-rounded float-end">Выход</button>
                    </a>
                    <div href="#!" class="d-flex justify-content-center" style="padding-bottom: 15px;">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="40">
                        <div class="pt-1">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start center">Kate Moss</h5>
                        </div>
                    </div>

                    <ul id="list" class="list-unstyled" style="overflow-y:scroll; overflow-x:hidden; height:350px;">
                    </ul>
                    <div class="bg-white mb-3">
                        <div class="form-outline">
                            <textarea id="message" class="form-control" id="textAreaExample2" rows="4" style="resize: none;"></textarea>
                            <label class="form-label" for="textAreaExample2">Сообщение</label>
                        </div>
                        <button id="sendButton" onclick="sendMessage()" type="button" class="btn btn-info btn-rounded float-end">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>