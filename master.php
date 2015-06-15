<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Page</title>
        <!-- Bootstrap Core CSS -->

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet" type="text/css"/>


        <!-- Custom Fonts -->
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>


        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <table> 
                        <td>
                            <a class="navbar-brand" href="index.php"><img src="assets/images/logo.jpg" alt="" width =30px; height = 30px;/></a>
                        </td>
                        <td>
                            <h4> <a href="index.php"> <font color="white"> NUSPlan </font> </a></h4>
                        </td>

                    </table>
                </div>

                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <?php
                        $navigation_content = ["Introduction", "About Us", "160 MCs Requirement", "Search for Module", "Plan your Module"];
                        $page_url = ["index.php", "aboutUsView.php", "#", "moduleInfoView.php", "#"];
                                
                        for ($i = 0; $i < count($navigation_content); $i++) {
                            if ($navigation_content[$i] == $getActive) {
                                echo "<li class ='active'>";
                            } else {
                                echo "<li>";
                            }
                            echo "<a href=" . $page_url[$i] . " > " . $navigation_content[$i] . "</a>";
                            echo "</li>";
                        }
                        
                        ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
<?php
echo $header;
?>
                            </h1>
                            <!-- <ol class="breadcrumb">
                                <li>
                                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li class="active">
                                    <i class="fa fa-desktop"></i> Bootstrap Elements
                                </li>
                            </ol>
                        </div>
                    </div>
                             /.row 
                    
                            <!-- Main jumbotron for a primary marketing message or call to action -->

                            <div class="jumbotron">
<?php
include($page_content);
echo $content; //Testing for without $page_content
?>
                            </div>

                        </div>


                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>