<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>NUSPlan - Plan to be Efficient (:</title>

        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>


        <!-- Custom Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!-- Plugin CSS -->

        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <!-- Custom CSS -->

        <link href="assets/css/creative.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>
    <body id="page-top">
        <?php session_start(); //print_r($_SESSION['test1']); echo "<br> 2+"; print_r($_SESSION['test2']); echo "<br>"; print_r($_SESSION['test3']);?>
        <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>   
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">
                <div class="active item">
                    <br>

                    <h2 style="color:#fff">We've got what you need!</h2>

                    <hr class="light">

                    <div class ="carousel-caption"
                         <p class="text-faded">NUSPlan has what you want when it comes to module planning for the rest of your studying journey!
                            Be it searching for a module, planning your module, or finding more about how NUSPlan works!

                        </p>
                        <a href="curriculumView.php" class="btn btn-default btn-xl">Get Started!</a>
                        <br>
                        <br>
                    </div>

                </div>
                <div class="item">
                    <img src="assets/images/slide2.jpg" style="width:100%;height:350px;">
                </div>
                <div class="item">
                    <img src="assets/images/back-to-school.jpg" style="width:100%;height:400px">

                    <div class="carousel-caption" style="top: 25%">
                        <h2>Welcome back to school!</h2>
                        <p>We hope that you have enjoy yourself during the summer break! Do enjoy using NUSPlan.</p>
                    </div>
                </div>
            </div>
            <!-- Carousel controls -->
            <a class="carousel-control centre" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3><a href ="aboutUsView.php">About Us</a></h3>
                        <p class="text-muted">Wanna know more about founders of NUSPlan?</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3><a href="planCurriculumView.php">Plan your Modules</a></h3>
                        <p class="text-muted">Start your module planning with this click!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3><a href="curriculumView.php">Course Requirements</a></h3>
                        <p class="text-muted">We update dependencies to keep things fresh.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-search wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <!-- <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star -->
                        <h3><a href ="moduleInfoView.php"> Search for Module</a></h3>
                        <p class="text-muted">We make things seem easier for you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <aside class="bg-dark">
        <div class="container text-center">

            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Let's Get In Touch!             
                </h2>

                <hr class="primary">
                <p>Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!
                <p>If not you can also leave your feedback at the form below!</p>

            </div>
            <div class="col-lg-4 col-lg-offset-2 text-center">
                <i class="fa fa-phone fa-3x wow bounceIn"></i>
                <p>+65-9755 5721</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                <p><a href="mailto:a0125464h@nus.edu.sg">feedback@nusplan.com</a></p>
            </div>
            <div class="">
                <!-- FaceBook Like and Share -->
                <table width="100%">
                    <tr>
                        <td align="right" width="46%">
                            <div
                                class="fb-like"
                                data-share="true"
                                data-width="300"
                                colorscheme ="dark"
                                data-show-faces="false">
                            </div> 
                        </td>
                        <td width="13%">&nbsp;</td>
                        <!-- Goggle +1 -->
                        <td align="left">
                            <div class="g-plusone" data-annotation="inline" data-width="300" data-href="https://nusplan.herokuapp.com/"></div>
                        </td>
                    </tr>   
                    <tr><td>&nbsp;&nbsp;</td></tr>
                </table>
            </div>


            <div>

                <form name="feedbackForm" method="post" action="submitFeedback.php" onsubmit="return thankYou()">
                    <div class="form-group">
                        <input width="100%" name="name" class="form-control" id="exampleInputName1" placeholder="Enter name" style="width:100%;">
                    </div>
                    <div class="form-group">
                        <input name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="width:100%;">
                    </div>
                    <div class="form-group">
                        <input name="subject" class="form-control" id="exampleInputSubject1" placeholder="Enter subject" style="width:100%;">
                    </div>
                    <div class="form-group">
                        <textarea name= "message" class="form-control" id="exampleInputMessage" placeholder="Enter message" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default btn-xl wow tada col-lg-4 col-md-4 col-md-offset-4"><span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>Submit!</button>
                </form>
            </div>
        </div>
    </aside>



    <!-- jQuery -->

    <script src="assets/js/jquery.js" type="text/javascript"></script>
    <!-- Bootstrap Core JavaScript -->

    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Plugin JavaScript -->
    <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.fittext.js" type="text/javascript"></script>
    <script src="assets/js/wow.min.js" type="text/javascript"></script>


    <!-- Custom Theme JavaScript -->
    <script src="assets/js/creative.js" type="text/javascript"></script>

    <!-- Feedback Form Submission -->
    <script>
                    function thankYou() {
                        var w = document.forms["feedbackForm"]["name"].value;
                        var x = document.forms["feedbackForm"]["email"].value;
                        var y = document.forms["feedbackForm"]["subject"].value;
                        var z = document.forms["feedbackForm"]["message"].value;
                        if (w == null || w == "" || x == null || x == "" || y == null || y == "" || z == null || z == "") {
                            alert("Please fill in all details");
                            return false;
                        } else {
                            alert("Thank you for your feedback");
                            return true;
                        }
                    }
    </script>

    <!-- FaceBook SDK -->
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '689822974457698',
                xfbml: true,
                version: 'v2.3'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Google +1 -->
    <script type="text/javascript">
        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>

</body>
</html>