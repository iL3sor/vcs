<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>VCS site</title>
</head>

<body>
    <section class="vh-100" style="background-color: darkslategray;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <form action="/index.php?controller=pages&action=login" method="POST">
                        <div class="card-body p-5 text-center">
                                <h3 class="mb-5">Sign in</h3>

                                <div class="form-outline mb-4">
                                    <input type="" id="typeEmailX-2" class="form-control form-control-lg" name="username"/>
                                    <label class="form-label" for="typeEmailX-2">Username</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="typePasswordX-2" class="form-control form-control-lg " name="password" />
                                    <label class="form-label" for="typePasswordX-2">Password</label>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

