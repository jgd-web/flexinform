require('./bootstrap');

/* A klienshez tartozó járművek lekérdezése */
$(document).on('click', '.client-name-link', function () {
    let clientId = $(this).attr("client-id");
    let subElement = $('#client-' + clientId + '-cars');

    if (subElement.is(':empty')) {
        $.ajax({
            type: 'GET',
            url: "/ajax/get-client-cars/" + clientId,
            success: function (response) {
                subElement.append(displayCarData(clientId, response));
                subElement.find(".cars-table").show(500);
            },
            error: function (response) {
                console.log(response);
            }
        });
    } else {
        subElement.empty();
    }
    return false;
});

/* Kliens adatainak lekérése */
$(document).on('click', '#client-search-submit', function () {
    let error = false;
    const clientName = document.getElementById('client-name-search-input');
    const idcard = document.getElementById('idcard-search-input');
    const searchResults = $('#search-result');

    searchResults.html('');

    if (clientName.value.length === 0 && idcard.value.length === 0) {
        error = true;
        event.preventDefault();
        alert('Nem töltöttél ki egy mezőt sem!');
    }

    if (clientName.value.length !== 0 && idcard.value.length !== 0) {
        error = true;
        event.preventDefault();
        alert('Csak egy mezőt tölts ki!');
    }

    if (!error) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "/ajax/client-search",
            data: {client_name: clientName.value, idcard: idcard.value},
            success: function (response) {
                searchResults.append(displayClientData(response));
                searchResults.find(".client-data-table").show(500);
            },
            error: function (response) {
                let errors = '';
                $.each(response.responseJSON.errors, function (index, value) {
                    errors += '<span style="color: red;">' + value + '</span><br>';
                });
                searchResults.html(errors);
            }
        });
    }
});

/* Járműhöz tartozó adatok lekérdezése */
$(document).on('click', '.car-id-link', function () {
    let carId = $(this).attr("car-id");
    let clientId = $(this).attr("client-id");
    let subElement = $('#client-' + clientId + '-car-services');

    if (subElement.is(':empty')) {
        $.ajax({
            type: 'GET',
            url: "/ajax/get-client-car-services/" + clientId + "/" + carId,
            success: function (response) {
                subElement.append(displayCarServices(response));
                subElement.find(".car-services-table").show(500);
            },
            error: function (response) {
            }
        });
    } else {
        subElement.empty();
    }
    return false;
});

/* A klienshez tartozó járművek megjelenítése sikeres találat esetén*/
function displayCarData(clientId, response) {
    let html = "";

    if (response.data.length === 0) {
        return '<p>Ehhez az ügyfélhez nem tartozik regisztrált jármű!</p>';
    }

    html += '<table class="table table-sm cars-table" style="display: none;">';
    html += '<tr>';
    html += '<th>Autó sorszáma</th>';
    html += '<th>Típúsa</th>';
    html += '<th>Regisztrálás időpontja</th>';
    html += ' <th>Saját márka</th>';
    html += '<th>Balesetek száma</th>';
    html += '<th>Esemény</th>';
    html += '<th>Időpont</th>';
    html += '</tr>';
    $.each(response.data, function (index, value) {
        html += '<tr class="car-row">';
        html += '<td class="car-id">';
        html += '<a car-id="' + value.car_id + '" client-id="' + clientId + '" class="car-id-link" href="#">' + value.car_id + '</a>';
        html += '</td>';
        html += '<td class="car-type">' + value.type + '</td>';
        html += '<td class="car-registered">' + value.registered + '</td>';
        html += '<td class="car-ownbrand">' + value.ownbrand + '</td>';
        html += '<td class="car-accidentd">' + value.accident + '</td>';
        html += '<td class="car-accidentd">' + value.type + '</td>';
        html += '<td class="car-accidentd">' + value.registered + '</td>';
        html += '</tr>';
    });
    html += '</table>';
    html += '<div id ="client-' + clientId + '-car-services"></div>';
    return html;
}

/* A járműhöz tartozó adatok megjelenítése sikeres találat esetén*/
function displayCarServices(response) {
    let html = "";

    if (response.data.length === 0) {
        return '<p>Ehhez a járműhöz nem tartozik szervíz bejegyzés!</p>';
    }

    html += '<table class="table table-sm car-services-table" style="display: none;">';
    html += '<tr>';
    html += '<th>Alkalom sorszáma</th>';
    html += '<th>Esemény neve</th>';
    html += '<th>Esemény időpontja</th>';
    html += ' <th>Munkalap azonosító</th>';
    html += '</tr>';
    $.each(response.data, function (index, value) {

        let eventtime = value.eventtime;

        if (eventtime === null) {
            eventtime = value.registered;
        }

        html += '<tr class="car-row">';
        html += '<td class="service-lognumber">' + value.lognumber + '</td>';
        html += '<td class="service-event">' + value.event + '</td>';
        html += '<td class="service-eventtime">' + eventtime + '</td>';
        html += '<td class="service-document_id">' + value.document_id + '</td>';
        html += '</tr>';
    });
    html += '</table>';
    return html;
}

/* Kliens adatok megjelenítése sikeres találat esetén */
function displayClientData(response) {
    let html = "";

    if (response.data.length === 0) {
        return '<p>A megadott adatok alapján nincs találat!</p>';
    }

    html += '<h3>Keresés eredménye</h3>';

    html += '<table class="table table-sm client-data-table" style="display: none;">';
    html += '<tr>';
    html += '<th>Ügyfél azonosító</th>';
    html += '<th>Ügyfél neve</th>';
    html += '<th>Ügyfél okmányazonosítója</th>';
    html += ' <th>Autóinak darabszáma</th>';
    html += '<th>Összes szervíznapló bejegyzések száma</th>';
    html += '</tr>';
    $.each(response.data, function (index, value) {
        html += '<tr class="car-row">';
        html += '<td class="client-id">' + value.id + '</td>';
        html += '<td class="client-name">' + value.name + '</td>';
        html += '<td class="client-idcard">' + value.idcard + '</td>';
        html += '<td class="client-count-cars">' + value.countCars + '</td>';
        html += '<td class="client-count-services">' + value.countServices + '</td>';
        html += '</tr>';
    });
    html += '</table>';
    return html;
}

/* Számokat nem lehet bevinni az idcard mezőbe. */
$('#idcard-search-input').keypress(function (e) {

    let charCode = (e.which) ? e.which : event.keyCode

    if (String.fromCharCode(charCode).match(/[^0-9]/g))

        return false;
});
