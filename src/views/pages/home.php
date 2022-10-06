<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VCS site</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <nav class="navbar navbar-dark bg-dark" style="height: 75px">
        <h2 style="color:red; margin-left: 8%; font-family: Georgia, 'Times New Roman', Times, serif;"><strong>
                Wellcome to my site
            </strong></h2>
        <div class="row g-0 d-flex align-items-center">
            <form action="/" method="GET" enctype="multipart/form-data">
                <button type="button" class="btn btn-primary btn-block mb-4" style="background-color: rgb(215, 98, 2);margin-top:15px;margin-right: 50px" onclick="gotopage('upload')">Upload</button>
                <button type="button" class="btn btn-primary btn-block mb-4" style="background-color: red;margin-top:15px; margin-right: 50px;" onclick="gotopage('scan')">ScanIP </button>
                <?php
                if (isset($_SESSION['user'])) {
                    echo ' <button type="button" class="btn btn-primary btn-block mb-4" style="background-color: green;margin-top:15px; margin-right: 50px;" onclick="gotopage(\'logout\')">Logout</button>';
                    if ($_SESSION['user'] == 'admin') {
                        echo ' <button type="button" class="btn btn-primary btn-block mb-4" style="background-color: black;margin-top:15px; margin-right: 50px;" onclick="gotopage(\'admin\')">Admin! </button>';
                    }
                }
                ?>
                <script>
                    function gotopage(pagename) {
                        document.location = '/index.php?controller=pages&action=' + pagename
                    }
                </script>
            </form>
        </div>
    </nav>
</head>

<body style="background-image: url(https://wallpaperaccess.com/full/343619.jpg)">
    <?php
    if (isset($_SESSION['user'])) {
        echo '';
    } else {
        echo '   <div style="margin-top:140px; opacity: 0.8; width: 500px; margin-left: 8%">
            <!-- Section: Design Block -->
            <section class=" text-center text-lg-start">
                <style>
                    .rounded-t-5 {
                        border-top-left-radius: 0.5rem;
                        border-top-right-radius: 0.5rem;
                    }
    
                    @media (min-width: 992px) {
                        .rounded-tr-lg-0 {
                            border-top-right-radius: 0;
                        }
    
                        .rounded-bl-lg-5 {
                            border-bottom-left-radius: 0.5rem;
                        }
                    }
                </style>
                <div class="card mb-3">
                    <div class="row g-0 d-flex align-items-center">
                        <div class="col-lg-8">
                            <div class="card-body py-5 px-md-5">
    
                                <form action="/index.php?controller=pages&action=register" method="POST">
                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <input type="" id="form2Example1" class="form-control" name="username" />
                                        <label class="form-label" for="form2Example1">Username</label>
                                    </div>
    
                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="form2Example2" class="form-control" name="password"/>
                                        <label class="form-label" for="form2Example2">Password</label>
                                    </div>
                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
    
                                </form>
                                <a href="index.php?controller=pages&action=login">Already have an account? </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Section: Design Block -->
        </div>';
    }
    ?>
</body>

</html>