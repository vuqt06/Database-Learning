function secretMessage() {
	var name = prompt("Please input the password:");
	var message = document.getElementById("secretmessage");
	if (name == "AprilTheFirst") {
		message.style.display = "block";
	}
	else {
		alert("You are not Nhung. You do not have permission to access the secret message.");
		message.style.display = "none";
	}
}