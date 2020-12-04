//Learned Ajax from here https://www.w3schools.com/js/js_ajax_database.asp
function getSearch(str) {
    var table = document.getElementById("clubTable");
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            table.innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "../data/getClubs.php?s=" + str + "&f=" + "n", true);
    xhttp.send();
}

var oldStr, oldType;

function filter(str, type) {
    oldStr = str;
    oldType = type;
    var table = document.getElementById("table");
    //Position, workRate and Strongfoot are all Selects so we can grab their values
    var position = document.getElementById("position");
    var workRate = document.getElementById("workRate");
    var strongFoot = document.getElementById("strongFoot");

    let output = "?pos=" + position.value + "&work=" + workRate.value + "&strong=" + strongFoot.value;
    console.log(output);

    var link = document.getElementById("list");
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var temp = this.responseText.split("IAT352");
            table.innerHTML = temp[0];
            link.innerHTML = temp[1];

        }
    };
    xhttp.open("GET", "data/getPlayers.php" + output, true);
    xhttp.send();
}

function getresult(url) {

}

function changePage(str) {
    var table = document.getElementById("table");
    var link = document.getElementById("list");
    //Position, workRate and Strongfoot are all Selects so we can grab their values
    var position = document.getElementById("position");
    var workRate = document.getElementById("workRate");
    var strongFoot = document.getElementById("strongFoot");
    let xhttp;
    let output = "?pos=" + position.value + "&work=" + workRate.value + "&strong=" + strongFoot.value;
    if (str == "") {
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var temp = this.responseText.split("IAT352");
            table.innerHTML = temp[0];
            link.innerHTML = temp[1];
        }
    };
    xhttp.open("GET", "data/getPlayers.php" + output + "&page=" + str, true);
    xhttp.send();
}