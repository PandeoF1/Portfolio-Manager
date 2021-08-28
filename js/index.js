document.getElementById("footer").style.display = 'none';
function displaychange() {
    if (document.getElementById("footer").style.display === "none") {
        document.getElementById("footer").style.display = "block";
        document.getElementById("up").style.display = "none";
        document.getElementById("down").style.display = "block";
        document.getElementById("footer-btn").style.bottom = "98px";
    } else {
        document.getElementById("footer").style.display = "none";
        document.getElementById("up").style.display = "block";
        document.getElementById("down").style.display = "none";
        document.getElementById("footer-btn").style.bottom = "0";
    }
}
