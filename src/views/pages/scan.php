<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VCS site</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <a href="index.php" style="text-decoration: none ;">
        <nav class="navbar navbar-dark bg-dark">
            <h2 style="color:red; margin-left: 8%; font-family: Georgia, 'Times New Roman', Times, serif;"><strong>
                    Scanning NMAP Service
                </strong></h2>
        </nav>
    </a>
    <nav class="navbar navbar-light" style="background-color: #e3f2fd; opacity: 0.5">
        <!-- Navbar content -->
    </nav>
</head>

<body style="background-image: url(https://wi.wallpapertip.com/wsimgs/81-811946_fondos-de-pantalla-para-pc-8k.jpg);">
    <div style="margin-top:90px; opacity: 0.8; width: 500px; margin-left: 8%">
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

                            <form action="/index.php?controller=pages&action=scan" method="POST">
                                <!-- Email input -->
                                <select class="custom-select" id="inputGroupSelect01" name="ip">
                                    <option selected value="all">Choose one IP to scan</option>
                                    <option value="all">Scan All</option>
                                    <?php
                                    $html = "";
                                    $i = 1;
                                    foreach ($ip as $p) {
                                        $html .= "<option value='$p' >$p</option>";
                                    }
                                    echo $html;
                                    ?>
                                </select>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4" style="margin-top: 5% ;">Scan this IP</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Design Block -->
    </div>
    <?php
    if (@$res) {
        echo ' <div style="margin-top:90px; opacity: 0.8; width: 500px; margin-left: 8%">
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
                <div class="card mb-3" style ="width:1000px">
                    <div class="row g-0 d-flex align-items-center">
                    <form action="/index.php?controller=pages&action=scan" method="GET">';
        echo $res;
        echo "<button type=\"button\" class=\"btn btn-primary btn-block mb-4\" style=\"margin-left: 83%; background-color: green\" onclick = \"download(btoa(`$res`),'scan_result.txt','text/plain')\">Save result</button>";
        echo '</form>
                    </div>
                </div>
            </section>
            <!-- Section: Design Block -->
        </div>';
    }
    ?>
</body>
<script>
    function download(data, filename, type) {
        data = atob(data);
        data = String(data).replaceAll("<div class='container' style='margin-top: 100px'><pre>","")
        data = String(data).replaceAll("</pre></div>","")
        var file = new Blob([data], {
            type: type
        });
        if (window.navigator.msSaveOrOpenBlob) // IE10+
            window.navigator.msSaveOrOpenBlob(file, filename);
        else { // Others
            var a = document.createElement("a"),
                url = URL.createObjectURL(file);
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 0);
        }
    }
</script>

</html>