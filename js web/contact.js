// var selectedRow = null;
// // Show Alerts
// function showAlert(message, className) {
//     const div = document.createElement("div");
//     div.className = `alert alert-${className}`;
//     div.appendChild(document.createTextNode(message));
//     const container = document.querySelector(".container");
//     const main = document.querySelector(".main");
//     container.insertBefore(div, main);
//     setTimeout(() => document.querySelector(".alert").remove(), 3000)
// }

// let popup = document.getElementById("popup");

// function openpopup() {
//     // popup.classList.add("open-popup")
//     console.log(popup.classList.add("open-popup"));
// }
// function closepopup() {
//     console.log(popup.classList);
//     // popup.classList.remove("open-popup")
// }



var contacts = []

function addContact() {
    var ContactName = document.getElementById("t1").value;
    var email = document.getElementById("t2").value;
    var number = document.getElementById("t3").value;

    if (ContactName && email && number) {
        var contact = {
            ContactName: ContactName,
            email: email,
            number: number
        };
        contacts.push(contact);
        openpopup("Added successfully...!");
        resetFields();
        displayData();

        // showAlert("added successfully", "success")

    }
}

function displayData() {
    // let output = "<table class='table table-striped table-dark jastify-content-center'>";
    // output += "<tr>";
    // output += "<th>ContactName</th>";
    // output += "<th>Email</th>";
    // output += "<th>Contact</th>";
    // output += "<th>Action</th>";
    // output += "</tr>";
    var output = ""
    for (let i = 0; i < contacts.length; i++) {
        output += "<tr>";
        output += "<td>" + contacts[i].ContactName + "</td>";
        output += "<td>" + contacts[i].email + "</td>";
        output += "<td>" + contacts[i].number + "</td>";
        // output += "<td><a class='btn' href='#' onclick='updateContact(" + i + ")'>Update</a>";
        // output += "<a class='btn' href='#' onclick='deleteContact(" + i + ")'>Delete</a></td>";
        output += "<td><a href='#' onclick='updateContact(" + i + ")' class='btn btn-warning btn-sm Update'><i class='bi bi-arrow-up-circle-fill'></i></a>" + " " + "<a href='#' onclick='deleteContact(" + i + ")' class='btn btn-danger btn-sm Delete'><i class='bi bi-trash3'></i></a>" + "</td>";
        // output += "<td><a href='#' class='btn btn-danger btn-sm Delete'>Delete</a>" + "</td>";
        // <a href="" class="btn btn-danger btn-sm Delete">Delete</a>
        output += "</tr>";
    }
    output += "</table>";
    document.getElementById("cd").innerHTML = output;
}

function resetFields() {
    document.getElementById("t1").value = "";
    document.getElementById("t2").value = "";
    document.getElementById("t3").value = "";
}

// function updateContact(index) {
//     var newContactName = document.getElementById("t1".value);
//     var newEmail = document.getElementById("t2").value;
//     var newNumber = document.getElementById("t3").value;

//     if (newContactName && newEmail && newNumber) {
//         contacts[index].ContactName = newContactName;
//         contacts[index].email = newEmail;
//         contacts[index].number = newNumber;
//         displayData();
//     }
function updateContact(index) {
    var newContactName = prompt("Enter new ContactName:");
    var newEmail = prompt("Enter new email:");
    var newNumber = prompt("Enter new number:");

    if (newContactName && newEmail && newNumber) {
        contacts[index].ContactName = newContactName;
        contacts[index].email = newEmail;
        contacts[index].number = newNumber;

        openpopup("Update Successfully..!");
        displayData();
    }

}


function deleteContact(index) {
    var confirmation = confirm("Are you sure you want to delete this contact?");
    if (confirmation) {
        contacts.splice(index, 1);
        // showAlert("Added Successfully", "Success")

        openpopup("Deleted successfully...!");
        displayData();
    }
}
// function nav() {
//     // Current URL: https://my-website.com/page_a
//     const nextURL = 'show.html';

//     // This will create a new entry in the browser's history, reloading afterwards
//     window.location.href = nextURL;

//     // This will replace the current entry in the browser's history, reloading afterwards
//     window.location.assign(nextURL);

//     // This will replace the current entry in the browser's history, reloading afterwards
//     window.location.replace(nextURL);
// }
console.log(contacts);



