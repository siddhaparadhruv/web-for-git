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
        resetFields();
        displayData();
    }
}

function displayData() {
    let output = "<table class='table table-striped table-dark jastify-content-center'>";
    // output += "<tr>";
    // output += "<th>ContactName</th>";
    // output += "<th>Email</th>";
    // output += "<th>Contact</th>";
    // output += "<th>Action</th>";
    // output += "</tr>";

    for (let i = 0; i < contacts.length; i++) {
        output += "<tr>";
        output += "<td>" + contacts[i].ContactName + "</td>";
        output += "<td>" + contacts[i].email + "</td>";
        output += "<td>" + contacts[i].number + "</td>";
        // output += "<td><a class='btn' href='#' onclick='updateContact(" + i + ")'>Update</a>";
        // output += "<a class='btn' href='#' onclick='deleteContact(" + i + ")'>Delete</a></td>";
        output += "<td><a href='#' onclick='updateContact(" + i + ")' class='btn btn-warning btn-sm Update'>Update</a>" + " " + "<a href='#' onclick='deleteContact(" + i + ")' class='btn btn-danger btn-sm Delete'>Delete</a>" + "</td>";
        // output += "<td><a href='#' class='btn btn-danger btn-sm Delete'>Delete</a>" + "</td>";
        // <a href="" class="btn btn-danger btn-sm Delete">Delete</a>
        output += "</tr>";
    }
    // output += "</table>";
    document.getElementById("displayData").innerHTML = output;
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
        displayData();
    }

}

function deleteContact(index) {
    var confirmation = confirm("Are you sure you want to delete this contact?");
    if (confirmation) {
        contacts.splice(index, 1);
        displayData();
    }
}
function nav() {
    // Current URL: https://my-website.com/page_a
    const nextURL = 'show.html';

    // This will create a new entry in the browser's history, reloading afterwards
    window.location.href = nextURL;

    // This will replace the current entry in the browser's history, reloading afterwards
    window.location.assign(nextURL);

    // This will replace the current entry in the browser's history, reloading afterwards
    window.location.replace(nextURL);
}
console.log(contacts);