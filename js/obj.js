var lst = [];
function getdata() {

    var name = document.getElementById("t1").value;
    var age = document.getElementById("t2").value;
    var sal = document.getElementById("t3").value;

    if (name == "" && age == "" && sal == "") {
        alert("field can't be Empty")
    }
    else if (name == "") {
        alert("field can't be Empty")
    }

    else if (sal == "") {

        alert("field can't be Empty")
    }
    else if (age == "") {

        alert("field can't be Empty")
    }
    else {
        z = { "name": name, "age": age, "sal": sal }

        lst.push(z)
        display()
    }

}
function display() {
    var tbl = "<table border=2  >"
    for (let i = 0; i < lst.length; i++) {

        tbl = tbl + "<tr>" + "<td>" + lst[i].name + "</td>" + "<td>" + lst[i].age + "</td>" + "<td>" + lst[i].sal + "</td>" + "<td>" + "<button onclick='remove(" + i + ")'>remove</button>" + "<button onclick='update(" + i + ")'>update</button>" + "</td>" + "</tr>"
    }
    tbl = tbl + "</table>"
    document.getElementById("ans").innerHTML = tbl
}

function remove(z) {
    lst.splice(z, 1)
    display()


}
function update(k) {
    z1 = prompt("enetr the name")
    z2 = prompt("enetr the age")
    z3 = prompt("enetr the sal")
    lst[k] = {
        "name": z1,
        "age": z2,
        "sal": z3
    };
    display()
}