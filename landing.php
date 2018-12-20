<?php
    $email = [];
    $emailSent;
    $debug = array();
    if($_GET['action']=='email'){


        $allowedExtensions=array('pdf','doc','jpg','png','jpeg','txt','xls','ppt','svg','xcf','zip','rar','7z','tgz');

        $fileLocations=array();

        if($_FILES){
            $debug['if'] = "IF";

           foreach($_FILES as $name => $file){
               $file_name =$file['name'];
               $temp_name =$file['tmp_name'];
               $file_type = $file['type'];
               $path_parts = pathinfo($file_name);
               $ext = $path_parts ['extension'];

               if(!in_array($ext, $allowedExtensions)){
                   die("File $file_name has the extensions $ext which is not allowed!");
               }
               $first_name = substr($first_name, 0,-4);
               $userName = $_POST['first_name'].'-'.$_POST['last_name'];
               $targetFile = 'landing/tmp/'.$file_name.'_'.$userName.'.'.$ext;

               if(move_uploaded_file($_FILES["attachment"]["tmp_name"],$targetFile)){
                $debug['uploadError']="None";
                }else{
                $debug['uploadError']="issue";
                }
               $fileLocations['attachment']=$targetFile;
           }
          
        }
        //recipient
        $to = 'cjay554@gmail.com';

        //sender
        $fromEmail = $_POST['email']; 
        $fromName = $_POST['first_name'].' '.$_POST['last_name'];
        $userName = $_POST['first_name'].'-'.$_POST['last_name'];

        //email subject
        $subject = 'wereReallyGood.com <MESSAGE:'.$_POST['email'].'>'; 
        

        $ext = pathinfo($fileTmp["name"],PATHINFO_EXTENSION);
        $debug['err1']=$fileTmp["tmp_name"];
        $debug['err2']=$fileTmp["name"];
        $targetFile = 'tmp/'.$fileTmp['name'].'_'.$fileName.'.'.$ext;
        $debug['err3']=$targetFile;

        
        //attachment file path
        $file = $fileLocations['attachment'];
        $debug['file'] = $file;
        //email body content
        $htmlContent = '<h1>From: '.$fromName.' - '.$fromEmail.'</h1>
            <p>'.$_POST['comments'].'</p>';

        //header for sender info
        $headers = "From: $fromName"." <".$fromEmail.">";

        //boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        //headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

        //multipart boundary 
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

        //preparing attachment
        if(!empty($file) > 0){
            if(is_file($file)){
                $message .= "--{$mime_boundary}\n";
                $fp =    @fopen($file,"rb");
                $data =  @fread($fp,filesize($file));

                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
                "Content-Description: ".basename($file)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $message .= "--{$mime_boundary}--";
        $returnpath = "-f" . $fromEmail;
        $emailSent ="false";
        //send email
        $mail = mail($to, $subject, $message, $headers); 
        $emailSent = $mail;
        //email sending status
        $emailSent = $mail?"<h1>Mail sent.</h1>":$mail->ErrorInfo;
   }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <!-- HTML Meta Tags -->
    <title>wereReallyGood.com</title>
    <meta name="description" content="Business Solutions | Fairness • Innovation • Community Involvement | Veteran owned supporting Austism Awareness. Jer. 29:11
    407-930-7600
    ">

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="wereReallyGood.com">
    <meta itemprop="description" content="Business Solutions | Fairness • Innovation • Community Involvement | Veteran owned supporting Austism Awareness. Jer. 29:11
    407-930-7600
    ">
    <meta itemprop="image" content="http://www.werereallygood.com/images/logo-card.png">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="http://www.werereallygood.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="wereReallyGood.com">
    <meta property="og:description" content="Business Solutions | Fairness • Innovation • Community Involvement | Veteran owned supporting Austism Awareness. Jer. 29:11
    407-930-7600
    ">
    <meta property="og:image" content="http://www.werereallygood.com/images/logo-card.png">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="wereReallyGood.com">
    <meta name="twitter:description" content="Business Solutions | Fairness • Innovation • Community Involvement | Veteran owned supporting Austism Awareness. Jer. 29:11
    407-930-7600
    ">
    <meta name="twitter:image" content="http://www.werereallygood.com/images/logo-card.png">

    <!-- Meta Tags Generated via http://heymeta.com -->

    <link rel="stylesheet" href="landing/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        html {
            overflow:hidden;
        }
        a{
            color:#ff9a00!important;
        }
        body{
            background-image:url('landing/assets/img/header-bg.jpg');
            height: -webkit-fill-available;

            background-repeat: no-repeat;
            background-attachment: scroll;
            background-position: 50%;
            background-size: cover;
        }
        
        .text-center {
            text-align:center;
        }


        header {
        }
        
        #masthead{
           margin-top:100px;
           overflow:hidden;
        }
        .masthead {
            
        }
        .iframe-container {
            }
        .logoHeader img{
            height:50px;
            
        }
        .phone-number::selection{
            background-color:#333333;
        }
        .frame-container{
            padding:50px;
        }

        .frame-item{
            -webkit-box-shadow: 0px 15px 6px 0px rgba(0,0,0,0.63); 
            box-shadow: 0px 25px 16px 0px rgba(0,0,0,0.30);          
        }
        
        .content-box {
            font-size: .8em;
        }


        .action-icon{
            font-size:2em;
        }
        
        .action-button{
            padding: 0;
            border:0px;
            line-height: 1.1;

        }

        #mainNav .navbar-toggler{
            background-color:#ff9a00;
        }

        .modal-form{
        }




        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rg(b0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #343a40!important;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @media (min-width: 1200px){
            .container {
                max-width:1400px;
            }
        }
        @media (max-width: 480px){
            .iframe-container {
            width:800px;
            }

        }
        @media (max-width: 480px){
            html {overflow:auto;}
            .iframe-container {
                margin-left:-65px;
            }
            #masthead{
                margin-top:100px;
            }
        }
        @media (max-width: 390px){
            html {overflow:auto;}
            .iframe-container {
                margin-left:-65px;
            }
            #masthead{
                margin-top:100px;
            }
        }
    </style>
</head>

<body id="page-top">









    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-dark" >
        <div class="container">
            <a class="navbar-brand" href="http://dev-werereallygood-com.stackstaging.com/landing.php">
                <span class="logoHeader"><img src="http://dev-werereallygood-com.stackstaging.com/images/logo-negativo-we.png"></span>
            </a>
            <button class="navbar-toggler navbar-toggler-right " data-toggle="collapse" data-target="#navbarResponsive" type="button" data-toogle="collapse" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="nav navbar-nav ml-auto text-uppercase"> 
                    <li  role="presentation"><button id="myBtn" class="button nav-item btn btn-light action-button"> <span class="action-icon">📧</span> </button></li>
                    
                    <!--<li class="nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="#team">Team</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li> -->
                </ul>
            </div> 
        </div>
    </nav>
    <header class="masthead" style="">
        <!-- Trigger/Open The Modal -->
    <?php include "landing/includes/emailModal.php"; ?>
    <!-- The Modal -->
    

        <div id="masthead" class="container">
            <div class="row">
                <div class="col-lg-12 text-center content-box">
                    <h2 style="text-shadow:2px 2px 10px #000;" class="text-uppercase section-heading">
                    Business Solutions </h2>
                    <p  style="font-size:2em;text-shadow:2px 2px 8px #000;">Fairness . Innovation . Community
                    <h3><a class="phone-number" href="tel:1-407-930-7600">407-930-7600</a></h3>
                    <p  style="text-shadow:2px 2px 5px #000;">Veteran owned supporting Autism Awareness.
                    Jer. 29:11</p>
                    <?php echo $email['fileName'];?>
                </div>
            </div>
            <div class="row text-center frame-container" style="">
                <div class="col-xs-8  col-sm-10 col-md-4 col-lg-4 " >
                    <div class="col-xs-10 frame-item"
                        onclick="window.location.href='https://www.facebook.com/werereallygood/';" 
                        style="background-image:url('landing/assets/img/landingfb.png');
                        background-size:cover;
                        
                    style="opacity:1;filter:alpha(opacity=100)" 
                    onmouseout="this.style.opacity=1;this.filters.alpha.opacity=100" 
                    onmouseover="this.style.opacity=0.8;this.filters.alpha.opacity=80"
                >
                </div>
                </div>
                <div 
                    class="col-xs-10  col-sm-10 col-md-4 col-lg-4  " 
                    >
                    <div class="col-xs-10 frame-item"
                        onclick="window.location.href='http://www.werereallygood.com/client/online_payment.php';" 
                        style="background-image:url('landing/assets/img/landingpay.png');
                            background-size:cover;
                           
                            "
                        style="opacity:1;filter:alpha(opacity=100)" onmouseout="this.style.opacity=1;this.filters.alpha.opacity=100" 
                        onmouseover="this.style.opacity=0.8;this.filters.alpha.opacity=80"
                    >
                    </div>
                    
                </div>
                <div style="margin: 0px;
                        padding: 0px;
                        "
                    class="col-xs-10  col-sm-10 col-md-4 col-lg-4  ">
                <iframe 
                    class="iframe-container frame-item col-xs-10"
                    style="width:inherit;position:relative;"
                    style="opacity:1;filter:alpha(opacity=100)" 
                    onmouseout="this.style.opacity=1;this.filters.alpha.opacity=100" 
                    onmouseover="this.style.opacity=0.8;this.filters.alpha.opacity=80"
                    src="https://www.google.com/maps/d/embed?mid=1YWjn5Skzv4hXMG3TeRTC2UNMjYo" width="500px" height="750px"></iframe>

                </div>
            </div>
        </div>
    </header>
  
    
    <!-- <div class="modal fade portfolio-modal text-center" role="dialog" tabindex="-1" id="portfolioModal6">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <h2 class="text-uppercase">Project Name</h2>
                                    <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p><img src="landing/assets/img/portfolio/6-full.jpg" class="img-fluid d-block mx-auto">
                                    <p>testestestestest Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae
                                        cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                    <ul class="list-unstyled">
                                        <li>Date: January 2017</li>
                                        <li>Client: Threads</li>
                                        <li>Category: Illustration</li>
                                    </ul><button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fa fa-times"></i><span>&nbsp;Close Project</span></button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="landing/assets/js/script.min.js"></script>
    <script>
        adaptiveSizeFrames();
        $(window).resize(function(){
            frameWidth = $('.frame-item').css('width');
            frameHeight = $('.frame-item').css('height');
            console.log(frameWidth+' '+frameHeight);
            newHeight = (parseInt(frameWidth)*1.5);
            $('.frame-item').css({"height":newHeight}); 
        });
        $(window).resize(adaptiveSizeFrames());
        function adaptiveSizeFrames(){
        //     frameWidth = $('.frame-item').css('width');
        //     frameHeight = $('.frame-item').css('height');
        //     console.log(frameWidth+' '+frameHeight);
        //     newHeight = (parseInt(frameWidth)*1.5);
        //     $('.frame-item').css({"height":newHeight});
        //     containerWidth = window.innerWidth;
        //     newContHeight = (parseInt(containerWidth)*.75);
        //    $('.frame-container').css({"height":newContHeight});

            frameWidth = $('.frame-item').css('width');
            frameHeight = $('.frame-item').css('height');
            console.log(frameWidth+' '+frameHeight);
            newHeight = (parseInt(frameWidth)*1.5);
            $('.frame-item').css({"height":newHeight});

        }


        startModals();
        function startModals(){
            
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
</body>

</html>