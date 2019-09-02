<?php
session_start();

$message = "";
$messageclass = "message_error";

$errors = array();
$errors["name_required"] = false;
$errors["email_required"] = false;
$errors["comments_required"] = false;
$errors["email_format_incorrect"] = false;

$mailsent = false;

//details
$form_email = "";
$form_name = "";
$form_comments = "";

if (isset($_POST["btnSend"]))
{
	//check CSRF
	$csrftoken = (isset($_POST["csrftoken"]) ? $_POST["csrftoken"] : "");

	if ($csrftoken == session_id())
	{
		$form_name = trim($_POST["txtName"]);
		$form_email = trim($_POST["txtEmail"]);
		$form_comments = trim($_POST["txtComments"]);

		if (str_replace(" ", "", $form_name) == "")
		{
			$errors["name_required"] = true;
		}

		if (str_replace(" ", "", $form_email) == "")
		{
			$errors["email_required"] = true;
		}

		if (!validateEmail($form_email))
		{
			$errors["email_format_incorrect"] = true;
		}

		if (str_replace(" ", "", $form_comments) == "")
		{
			$errors["comments_required"] = true;
		}		

		function iserror($x)
		{
		    return $x == true;
		}

		if (sizeof(array_filter($errors)) == 0)
		{
			//email
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8\r\n";
			$headers .= "From: " . sanitize($form_email) . "\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion();

			$subject = "Contact request from " . sanitize($form_name);
			$body = sanitize($form_comments);

			$mailsent = mail("teochewthunder@gmail.com", $subject, $body, $headers);

			if ($mailsent)
			{
				$form_email = "";
				$form_name = "";
				$form_comments = "";

				$message = "Email sent. Thank you!";
				$messageclass = "message_success";
			}
			else
			{
				$message = "An error occured while trying to send your mail. Please try again.";
				$messageclass = "message_error";
			}
		}		
	}
	else
	{
		$message = "CSRF attack foiled!";
		$messageclass = "message_error";
	}
}

function sanitize ($str) 
{
    return htmlentities($str, ENT_COMPAT|ENT_QUOTES, "UTF-8", true); 
}

function validateEmail($str)
{
	if (strlen($str) < 5) return false;
	if (strstr($str, "@") === false) return false;
	if (strpos($str, "@") == 0 || strpos($str, "@") == strlen($str) - 1) return false;
	if (sizeof(explode("@", $str)) != 2) return false;

	return true;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Contact Us</title>

		<style>
			html, body
			{
				padding: 0;
				margin: 0;
				font-size: 14px;
				font-family: arial;
				background-color: #000000;
				height: 100%;
			}

			div
			{
				outline: 0px solid #FF0000;
			}

			.contentContainer
			{
				width: 800px;
				height: 100%;
				margin: 0 auto 0 auto;
				background-color: #FFFFFF;
			}

			.contactContainer
			{
				width: 90%;
				padding-top: 10px;
				margin: 0 auto 0 auto;
			}

			.messageContainer
			{
				width: 100%;
				height: 2.5em;
				padding-top: 1em;
				font-weight: bold;
				margin-bottom: 0.5em;
				border-radius: 10px;
				color: #FFFFFF;
			}

			.messageContainer:before
			{
				content: "";
				display: block;
				width: 2em;
				height: 2em;
				float: left;
				font-size: 2em;
				margin-top: -0.5em;
				text-align: center;
			}

			.message_error
			{
				background-color: #FF9999;
			}

			.message_success
			{
				background-color: #9999FF;
			}

			.message_error:before
			{
				content: "\02718";
			}

			.message_success:before
			{
				content: "\02714";
			}

			.innerContainer
			{
				width: 100%;
			}

			.clear
			{
				clear: both;
			}	

			.hide
			{
				display: none;
			}

			.formContainer
			{
				width: 50%;
				float: left;
				padding: 0.5em;
				background-color: #DDDDDD;
				border: 1px solid #DDDDDD;
				border-radius: 10px;
			}

			label
			{
				font-weight: bold;
				font-size: 0.75em;
				color: #444444;
			}

			input[type = text]
			{
				width: 25em;
				height: 1.5em;
				padding: 0.25em;
				border-radius: 5px;
				border: 0px solid #000000;
			}

			input[type = submit]
			{
				display: inline-block;
				float: right;
				width: 5em;
				height: 2em;
				border-radius: 5px;
				border: 0px solid #000000;
				background-color: #999999;
				font-weight: bold;
				cursor: pointer;
			}

			input[type = submit]:hover
			{
				background-color: #FFFFFF;
				cursor: pointer;
			}

			textarea
			{
				width: 25em;
				padding: 0.25em;
				border-radius: 5px;
				border: 0px solid #000000;
			}

			.formrow
			{
				margin-top: 1em;
				font-size: 1.5em;
			}

			.error
			{
				color: #FF0000;
				font-size: 0.8em;
				font-weight: bold;
			}

			.error span
			{
				display: inline-block;
				height: 1.5em;
				padding-top: 0.25em;
			}

			.cardContainer
			{
				width: 40%;
				float: right;
				padding: 0.5em;
				border: 1px solid #DDDDDD;
				border-radius: 10px;
			}

			.cardContainer:after
			{
				content: "";
				display: block;
				width: 3em;
				height: 3em;
				float: right;
				margin-top: -2em;
				background: url(http://www.teochewthunder.com/img/logo.png) right top no-repeat;
				background-size: contain;
			}

			.cardrow
			{
				margin-bottom: 1em;
				font-size: 1.2em;
			}	

			.icon_phone:before
			{
				display: block;
				content: "\260E";
				width: 2em;
				height: 1em;
				float: left;
				text-align: center;
			}

			.icon_email:before
			{
				display: block;
				content: "\2709";
				width: 2em;
				height: 1em;
				float: left;
				text-align: center;
			}

			.icon_address:before
			{
				display: block;
				content: "\2616";
				width: 2em;
				height: 3em;
				float: left;
				text-align: center;
			}

			.mapContainer
			{
				width: 100%;
				height: 300px;
				float: left;
				margin-top: 1em;
			}

			.mapContainer iframe
			{
				width: 100%;
				height: 100%;
			}		
		</style>

		<script>
			function validateForm() 
			{
				var placeholders = document.getElementsByClassName("error");

				for (var i = 0; i < placeholders.length; i++)
				{
					if (placeholders[i].className.trim() == "error")
					{
						placeholders[i].className = "error hide";
					}
				}

				var errors = [];

				var txtName = document.getElementById("txtName");
				var txtEmail = document.getElementById("txtEmail");
				var txtComments = document.getElementById("txtComments");

				if (txtName.value.replace(/\s/g, "").length == 0)
				{
					errors.push("name_required");
				}

				if (txtEmail.value.replace(/\s/g, "").length == 0)
				{
					errors.push("email_required");
				}

				if (!validateEmail(txtEmail.value))
				{
					errors.push("email_format_incorrect");
				}

				if (txtComments.value.replace(/\s/g, "").length == 0)
				{
					errors.push("comments_required");
				}

				if (errors.length == 0)
				{
					return true;
				}
				else
				{				
					for (var i = 0; i < errors.length; i++)
					{
						document.getElementById(errors[i]).className = "error";
					}

					return false;
				}
			}

			function validateEmail(str)
			{
				if (str.length < 5) return false;
				if (str.indexOf("@") == -1) return false;
				if (str.indexOf("@") == 0 || str.indexOf("@") == str,length - 1) return false;
				if (str.split("@").length != 2) return false;
 
				return true;
			}
		</script>
	</head>

	<body>
		<div class="contentContainer">
			<div class="contactContainer">
				<div class="messageContainer <?php echo ($message == "" ? "hide" : $messageclass); ?>">
					<?php echo $message; ?>
				</div>

				<div class="innerContainer">
					<div class="formContainer">
						<form action="" method="POST" onsubmit="return validateForm();">
							<div class="formrow">
								<label for="txtName">Name</label><br />
								<input type="text" id="txtName" name="txtName" maxlength="50" value="<?php echo sanitize($form_name); ?>" placeholder="e.g, Jose D'Cruz" />
							</div>
							<div class="error <?php echo $errors["name_required"] ? "" : "hide" ?>" id="name_required">
								<span>Name is required.</span>
							</div>

							<div class="formrow">
								<label for="txtEmail">Email</label><br />
								<input type="text" id="txtEmail" name="txtEmail" maxlength="50" value="<?php echo sanitize($form_email); ?>" placeholder="e.g, j_dcruz208@youremail.com" />
							</div>
							<div class="error <?php echo $errors["email_required"] ? "" : "hide" ?>" id="email_required">
								<span>Email is required.</span>
							</div>
							<div class="error <?php echo $errors["email_format_incorrect"] ? "" : "hide" ?>" id="email_format_incorrect">
								<span>Email is in an incorrect format.</span>
							</div>

							<div class="formrow">
								<label for="txtComments">Comments</label><br />
								<textarea type="text" id="txtComments" name="txtComments" rows="5" maxlength="500" placeholder="e.g, You're awesome!"><?php echo sanitize($form_comments); ?></textarea>
							</div>
							<div class="error <?php echo $errors["comments_required"] ? "" : "hide" ?>" id="comments_required">
								<span>Comments are required.</span>
							</div>
							<div class="formrow">
								<input type="submit" id="btnSend" name="btnSend" value="Send">
								<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo session_id(); ?>">
							</div>
						</form>
					</div>

					<div class="cardContainer">
						<div class="cardrow icon_phone">
							+65 1234567
						</div>

						<div class="cardrow icon_email">
							mail@teochewthunder.com
						</div>

						<div class="cardrow icon_address">
							123 South Dakota Avenue<br />
							12-34a<br />
							Singapore 112113
						</div>
					</div>

					<br class="clear" />

					<div class="mapContainer">
						<iframe src="https://www.google.com/maps/d/embed?mid=1UzZMoKTBgihR8EkunVcLPyUjrBVV0sWV&hl=en"></iframe>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
