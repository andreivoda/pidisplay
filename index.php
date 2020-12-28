<!DOCTYPE html>
<html>
	<head>
		<title>Led Matrix</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex" />

		<link rel="stylesheet" href="css/style.css">

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

		<script src="jquery-3.5.1.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<div id="info">Choose what to display!</div>

			<form action="index.php" method="GET">
				<input type="text" name="message" minlength="1" maxlength="100" placeholder="Your message">
				<input type="submit" name="submit" value="Display">
			</form>

			<script>
				var out_msg, msg_size;
				$(document).ready(function() {
					$("form").submit(function(e) {
						return false;
					});

					$("input[type=\"submit\"]").on("click", function() {
						out_msg = $("input[type=\"text\"]").val();
						msg_size = out_msg.length;

						$("#your_message").html("Your message:&nbsp;&nbsp;\"" + out_msg + "\"");

						if (msg_size < 1) {
							$("#message_state").html("Message is empty");
							$("#message_state").css("color", "red");
						}
						else if (msg_size > 100) {
							$("#message_state").html("Message longer than 100 characters");
							$("#message_state").css("color", "red");
						}
						else {
							$("#message_state").html("Printing message...");
							$("#message_state").css("color", "orange");

							$.ajax({
								async: true,
								url: "php/output.php",
								type: "get",
								data: { message: out_msg },
								success: function(response) {
									if (response == "Interrupted\n") {
										$("#message_state").html("Interrupted");
										$("#message_state").css("color", "red");
									}
									else {
										$("#message_state").html("Finished");
										$("#message_state").css("color", "green");
									}
								}
							});
						}

						$("input[type=\"text\"]").val("");
						$("input[type=\"text\"]").focus();
					});
				});
			</script>

			<div id="your_message"></div>
			<div id="message_state"></div>
		</div>
	</body>
</html>