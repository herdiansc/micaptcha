<html>
<head>
	<title>CAPTCHA Demo in Contact Form</title>
	<style>
	    div.input {
	        margin-bottom:20px;
	    }
        div#main {
            width: 600px;
            margin: 0 auto;
            border: 10px solid #EEE;
            padding: 50px;
            border-radius: 10px;
            border-image: initial;
        }
	</style>
</head>
<body>
    <div id="main">
        <h1>Contact Us</h1>
        <p>CAPTCHA Test Form</p>
	    <form method="post" action="process.php">
	        <div class="text input">
	            <label>
	                Name :<br />
	                <input class="input" type="text" name="name" />
                </label>
	        </div>
	        <div class="text input">
	            <label>
	                Email :<br />
	                <input class="input" type="text" name="email" />
                </label>
	        </div>
	        <div class="text input">
	            <label>
	                Message :<br />
	                <textarea class="message" name="message"></textarea>
                </label>
	        </div>
	        <?php
                include('include/classes/View.php');
                $View = new View();
                echo $View->generate();
	        ?>
	        <div style="clear:both"></div>
		    <input type="submit" value="Submit" />
	    </form>
	</div>
</body>
</html>
