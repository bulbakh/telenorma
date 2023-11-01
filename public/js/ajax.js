$(document).ready(function () {

    hideForm();
    getWorkers();

    $('#add').click(function () {
        clearForm();
        showForm();
    });

    $('#workerform').submit(function (e) {
        e.preventDefault();
        saveWorker();
    });

    $('#cancel').click(function (e) {
        e.preventDefault();
        hideForm();
    });

});

function clearForm() {
    $('#workerform input[type="text"], #workerform select').val('');
}

function showForm() {
    $('#workerform').show();
    hideAddBtn();
}

function hideForm() {
    $('#workerform').hide();
    showAddBtn();
}

function showAddBtn() {
    $('#add').show();
}

function hideAddBtn() {
    $('#add').hide();
}

function saveWorker() {
    $.ajax({
        type: "POST",
        url: 'ajax.php?entity=worker&method=save',
        data: $('#workerform').serialize(),
        success: function (response) {
            editWorker(response);
            hideForm();
            getWorkers();
        },
        error: function () {
            alert('AJAX ERROR');
        }
    });
}

function deleteWorker(id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php?entity=worker&method=delete&id=' + id,
        success: function (response) {
            var jsonData = JSON.parse(response);
            if (jsonData.status === "ERROR") {
                alert('ERROR: ' + jsonData.data);
            }
            getWorkers();
        },
        error: function () {
            alert('AJAX ERROR');
        }
    });
}

function getWorker(id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php?entity=worker&method=get&id=' + id,
        success: function (response) {
            editWorker(response);
        },
        error: function () {
            alert('AJAX ERROR');
        }
    });
}

function editWorker(response) {
    var jsonData = JSON.parse(response);
    if (jsonData.status === "OK") {
        showForm();

        $('#id').val(jsonData.data.id);
        $('#name').val(jsonData.data.name);
        $('#last_name').val(jsonData.data.last_name);
        $('#position').val(jsonData.data.position_id);
    } else {
        alert('ERROR: ' + jsonData.data);
    }
}

function getWorkers() {

    $.ajax({
        type: "POST",
        url: 'ajax.php?entity=worker&method=selectWithPosition',
        success: function (response) {
            showTable(response);
        },
        error: function () {
            alert('AJAX ERROR');
        }
    });
}

function showTable(response) {
    var jsonData = JSON.parse(response);
    if (jsonData.status === "OK") {
        const table = document.querySelector("table");
        table.innerHTML = '';
        const row = table.insertRow();
        row.insertCell(0).innerHTML = 'ID';
        row.insertCell(1).innerHTML = 'Name';
        row.insertCell(2).innerHTML = 'Last Name';
        row.insertCell(3).innerHTML = 'Position';
        row.insertCell(4).innerHTML = 'Action';

        jsonData.data.forEach(function (item) {
            var row = table.insertRow();
            var idCell = row.insertCell(0);
            var nameCell = row.insertCell(1);
            var lastNameCell = row.insertCell(2);
            var positionIdCell = row.insertCell(3);
            var actionsCell = row.insertCell(4);

            idCell.innerHTML = item.id;
            nameCell.innerHTML = item.name;
            lastNameCell.innerHTML = item.last_name;
            positionIdCell.innerHTML = item.position_name;

            var editButton = document.createElement("button");
            editButton.innerHTML = "Edit";
            editButton.setAttribute("data-id", item.id); // Встановлення атрибуту id
            editButton.addEventListener("click", function () {
                var id = this.getAttribute("data-id");
                getWorker(id)
            });

            var deleteButton = document.createElement("button");
            deleteButton.innerHTML = "Delete";
            deleteButton.setAttribute("data-id", item.id); // Встановлення атрибуту id
            deleteButton.addEventListener("click", function () {
                var id = this.getAttribute("data-id");
                var confirmation = confirm("Are you sure you want to delete the record with ID " + id + "?");
                if (confirmation) {
                    deleteWorker(id);
                }
            });

            actionsCell.appendChild(editButton);
            actionsCell.appendChild(deleteButton);
        });
    } else {
        alert('ERROR: ' + jsonData.data);
    }
}