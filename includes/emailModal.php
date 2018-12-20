<?php ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Send us a message!</p>
                <form name="contactform" method="post" action="landing.php?action=email" enctype="multipart/form-data">
                    <div class="form-group modal-form">
                    
                    <label for="first_name">First Name *</label>
                    <input class="form-control" type="text" name="first_name" maxlength="50" size="30">
                    <label for="last_name">Last Name *</label>
                    <input class="form-control" type="text" name="last_name" maxlength="50" size="30">
                    <label for="email">Email Address *</label>
                    <input class="form-control" type="text" name="email" maxlength="80" size="30">
                    <label for="telephone">Telephone Number</label>
                    <input class="form-control" type="text" name="telephone" maxlength="30" size="30">
                    <label for="comments">Comments *</label>
                    <textarea class="form-control" name="comments" maxlength="1000" cols="25" rows="6"></textarea>
                    <input class="form-control" type="submit" value="Submit">
                    <input  type="file" name="attachment">
                    </div>
                </form>
                <?php 
               // echo $emailSent?"<script>window.alert('Email Sent Successful!');</script>":"";
                echo $_FILES['attachment']['name'].' - '.$emailSent.' / '.$debug['err1'].' / '.$debug['err2'].' / '.$debug['uploadError'].' --------------'. $fileLocations['attachment'];
                ?>
            </div>
        </div>
    </div>

</div>
