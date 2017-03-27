function sortCurrentField(u,v,w) {
    document.location.href = "uniinput.php?mn=" +u + "&cn=" + v + "&dir=" + w;
}

function addNewRow() {
    document.getElementById("newdatadiv").style.display = "none";
    document.getElementById("datainputdiv").style.display = "block";
}