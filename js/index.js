function displaychange() {
    document.getElementById("footer").style.display = 'none';
    if (document.getElementById("footer").style.display === "none") {
      document.getElementById("footer").style.display = "block";
    } else {
      document.getElementById("footer").style.display = "none";
    }
  }