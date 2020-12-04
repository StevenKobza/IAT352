var oldStr, oldType;

function filter(str, type, location) {
    oldStr = str;
    oldType = type;
    var table = document.getElementById("table");
    
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
    if (location == "base") {
        //p = what to filter by
        //t = which column to filter
        //b = base location in folder or not
        xhttp.open("GET", "data/getPlayers.php?p=" + str + "&t=" + type + "&f=" + "y", true);
    } else {
        xhttp.open("GET", "../data/getPlayers.php?p=" + str + "&t=" + type + "&b=" + "n" + "&f=" + "n", true);
    }
    xhttp.send();
}


function changePage(str, location) {
    var table = document.getElementById("table");
    var link = document.getElementById("list");
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var temp = this.responseText.split("IAT352");
            table.innerHTML = temp[0];
            link.innerHTML = temp[1];
            console.log(temp[1]);
            console.log(link.innerHTML);
        }
    };
    
    if (oldStr  == undefined|| oldType == undefined) {
        oldStr = "";
        oldType = "";
    }
    if (location == "base") {
        //p = what to filter by
        //t = which column to filter
        //b = base location in folder or not
        console.log("data/getPlayers.php?p=" + oldStr + "&t=" + oldType + "&page=" + str);
        xhttp.open("GET", "data/getPlayers.php?p=" + oldStr + "&t=" + oldType + "&page=" + str, true);
    } else {
        console.log("../data/getPlayers.php?p=" + oldStr + "&t=" + oldType + "&page=" + str);
        xhttp.open("GET", "../data/getPlayers.php?p=" + oldStr + "&t=" + oldType + + "&page=" + str + "&b=" + "n", true);
    }
    xhttp.send();
}

function getSearch(str) {
    var table = document.getElementById("clubTable");
    let xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            table.innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "../data/getClubs.php?s=" + str, true);
    xhttp.send();
}