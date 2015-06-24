<html>
    <head>
        <title>My Bootstrap Exercise - Team xAspire</title>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <style type="text/css">
            h2{
                margin: 0;     
                color: #777;
                padding-top: 90px;
                font-size: 52px;
                font-family: "trebuchet ms", sans-serif;    
            }
            .item{
                background: #333;    
                text-align: center;
                height: 300px !important;
            }
            .carousel{
                margin-top: 20px;
            }
            
            .bs-example{
                margin: 20px;
            }
            .item-image{
                background: url(http://www.ambwallpapers.com/wp-content/uploads/2015/02/1840631.jpg);
                background-size: cover;
                background-position: center; 
                background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#navigationbar">
                        <img alt="Bootstrap Mission Control" src="http://logonoid.com/images/bootstrap-logo.png" width="20px">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#myCarosel">Carousel</a></li>
                        <li><a href="#signup">Sign Up</a></li>
                    </ul>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        <!-- xAspire Carousell -->
        <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>   
            <!-- Carousel items -->
            <div class="item item-image">
                <div class="active item">
                    <h2>Team xAspire</h2>
                    <div class="carousel-caption">
                        <h3>Welcome!</h3>
                        <p>This team consist of 2 Year 1 IS Student - Tan Boon Jun & NG Wan Sin</p>
                    </div>
                </div>
                <div class="item">
                    <h2>NUSPlan - Part 1</h2>
                    <div class="carousel-caption">
                        <h3>So what is it about?</h3>
                        <p>NUSPlan is a web platform for students to plan their modules throughout their studying journey.</p>
                    </div>
                </div>
                <div class="item">
                    <h2>NUSPlan - Part 2</h2>
                    <div class="carousel-caption">
                        <h3>Why NUSPlan?</h3>
                        <p>Students had a hard time planning for their modules in their studying journey</p>
                    </div>
                </div>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>

        <br>
        
        <!-- Sign Up Form -->
        <div id="signup" class="well col-md-4 col-lg-offset-4">
            <center><h1>Sign Up Form</h1></center>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit
                    <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>
                </button>
            </form>
        </div>
    </body>
</html>
