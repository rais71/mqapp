"use strict";

let acara = [];
// let isiAcara = {};

// function fetchData() {
//     fetch('/kaldik/data')
//         .then(response => {
//             if (!response.ok) {
//                 throw Error("ERROR");
//             }
//             return response.json();
//         })
//         .then(data => {
//             acara.push(data);
//         })
//         .catch(error => {
//             console.log(error);
//         })
// }

// fetchData();
// console.log(acara[0].judul[0]);

async function getAcara() {
    let response = await fetch('/kaldik/data');
    let data = await response.json()
    return data
}

function renderCalendar() {
    var calendarEl = document.getElementById('acara')
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            start: 'title', // will normally be on the left. if RTL, will be on the right
            center: '',
            end: 'prev,next' // will normally be on the right. if RTL, will be on the left
        },
        height: "auto",
        // initialView: $(window).width() < 765 ? 'listMonth' : 'dayGridMonth',
        locale: 'id',
        eventSources: [{
            events: acara,
            borderColor: "#00423e"
        }],

        eventClick: function (info) {
            $('#info-acara-modal').modal('show');
            $('#judul-acara-modal').text(info.event.title);
            $('#form-hapus-acara-modal').attr('action', '/kaldik/' + info.event.id);
            if (info.event.extendedProps.description != null) {
                $('#deskripsi-acara-modal').text(info.event.extendedProps.description);
            }
            if (info.event.end != null) {
                $('#waktuAcara').
                text(info.event.start.getDate() + '-' + info.event.start.getMonth() + '-' + info.event.start.getFullYear() + " sd. " +
                    info.event.end.getDate() + '-' + info.event.end.getMonth() + '-' + info.event.end.getFullYear());
            } else {
                $('#waktuAcara').
                text(info.event.start.getDate() + '-' + info.event.start.getMonth() + '-' + info.event.start.getFullYear());;
            }
        }
    })
    calendar.render()
}

getAcara().then(data => {
    for (let i = 0; i < data.length; i++) {
        acara.push({
            id: data[i].id,
            title: data[i].judul,
            start: data[i].awal,
            backgroundColor: data[i].warna,
            ...(data[i].ulang != 7 ? {
                daysOfWeek: data[i].ulang
            } : {}),
            ...(data[i].akhir != null ? {
                end: data[i].akhir
            } : {}),
            ...(data[i].url != null ? {
                url: data[i].url
            } : {}),
            ...(data[i].deskripsi != null ? {
                extendedProps: {
                    description: data[i].deskripsi
                }
            } : {}),

        });
    }
    renderCalendar();
});

console.log(acara);

// Datepicker -------------------------------------------------------------------------------
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    language: 'id'
});

$('#tgl-mulai').datepicker().on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#tgl-selesai').datepicker('setStartDate', minDate);
});

$('#tgl-selesai').datepicker().on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#tgl-mulai').datepicker('setEndDate', maxDate);
});

// Color Picker -------------------------------------------------------------------------------
$(".colorpickerinput").colorpicker({
    format: 'hex',
    component: '.input-group-append',
});

$('#warna-bg').on('change', function () {
    let warna = $(this).val();
    $(this).css("background-color", warna);

    function cekWarna(hexcolor) {
        hexcolor = hexcolor.replace("#", "");
        var r = parseInt(hexcolor.substr(0, 2), 16);
        var g = parseInt(hexcolor.substr(2, 2), 16);
        var b = parseInt(hexcolor.substr(4, 2), 16);
        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return (yiq >= 128) ? 'black' : 'white';
    }

    $(this).css("color", cekWarna(warna));

    if ($(this).val() == "#00423e") {
        $('#warna-dasar').prop("checked", true);
    } else {
        $('#warna-dasar').prop("checked", false);
    }
})

$('#warna-dasar').on('change', function () {
    if ($(this).is(':checked')) {
        $('#warna-bg').val("#00423e");
        $('#warna-bg').css("background-color", "#00423e");
        $('#warna-bg').css("color", "white");
        // $('#warna-bg').prop('disabled', true);
    } else {
        $('#warna-bg').prop('disabled', false);
    }
})

// Ulangi Hari -------------------------------------------------------------------------------
$('#ulangi-hari').on('change', function () {
    if ($(this).is(':checked')) {
        $('#tgl-selesai').val("");
        $('#tgl-selesai').prop('disabled', true);
    } else {
        $('#tgl-selesai').prop('disabled', false);
    }
})

// Batal Tambah -------------------------------------------------------------------------------
$('#batal-tambah').on('click', function () {
    $('#form-tambah').trigger('reset');
    $('#warna-dasar').trigger('click');
})

// ON WINDOW LOAD -------------------------------------------------------------------------------
$(window).on("load", function () {
    $('#warna-dasar').trigger('click');
});
