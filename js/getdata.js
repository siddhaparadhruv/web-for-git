var lst = []
function getdata() {
    var z = document.getElementById("text1").value;
    lst.push(z)
    display()
}

function remove(z) {
    lst.splice(z, 1)
    display()


}
function display() {
    var tbl = "<table border=2  >"
    for (let i = 0; i < lst.length; i++) {

        tbl = tbl + "<tr>" + "<td>" + lst[i] + "</td>" + "<td>" + "<button onclick='remove(" + i + ")'>remove</button>" + "<button onclick='update(" + i + ")'>update</button>" + "</td>" + "</tr>"
    }
    tbl = tbl + "</table>"
    document.getElementById("ans").innerHTML = tbl
}
function update(k) {
    z = prompt("enetr the new value")
    lst[k] = z;
    display()
}