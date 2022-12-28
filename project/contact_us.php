<?php
// include database connection
include 'check_user_login.php';
?>

<?php include 'topnav.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/online-shopping.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>


<body>
    <div class="container">
        <div class="container my-5">
            <section class="mb-10">
                <div class="row">
                    <div class="col-md-9 col-lg-7 col-xl-5 mx-auto text-center">
                        <h4 class="mb-4">Contact Us</h4>
                        <div class="card bg-info text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <form class="" action="contact_us.php" method="post">
                                    
                                        <div class="col-md-12">
                                            <div class="form-outline mb-4">
                                                <label for="exampleFormControlInput1" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="subject" id="exampleFormControlInput1" placeholder="John Doe">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-outline mb-4">
                                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                            </div>
                                        </div>
                                   
                                    <div class="form-outline mb-4">
                                        <label for="exampleFormControlTextarea1" class="form-label">Your Message</label>
                                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>

                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <td>
                                            <input type='submit' value='Save' class='btn btn-primary mx-2' />
                                            <a href='index.php' class='btn btn-secondary'>Back to home</a>
                                        </td>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                
                </div>
            </section>
        </div>
    </div>




    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if (isset($_POST["send"])) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'junshengwebdev@gmail.com';
        $mail->Password = 'crafucwqvicnlnga';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';

        $mail->setFrom('junshengwebdev@gmail.com');

        $mail->addAddress('junshengwebdev@gmail.com');

        $mail->isHTML(true);

        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"] . " " . $_POST['email'];

        $mail->send();

        echo
        "
    <script>
    alert('Send Sucessfully');
    document.location.herf = 'contact_us.php'
    </script>
    ";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> </script>
</body>

</html>