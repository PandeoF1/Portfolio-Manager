function displaychange() {
    var x = document.getElementById("footer").style.display = 'none';
    if (x.style.display === "none") {
     x.style.display = "block";
   } else {
     x.style.display = "none";
   }
 }