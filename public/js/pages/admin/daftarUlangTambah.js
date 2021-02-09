"use strict";

// GET META CONTENT AND UBAH JADI ARRAY  -------------------------------------------------------------------------------
let metaArr = $('meta[name=var]').attr('content');
// console.log(metaArr);
// let metaContent = metaArr.split(',')

$(document).ready(function () {

    // DYNAMIC DROPDOWN TAHUN AJARAN MASUK  -------------------------------------------------------------------------------
    let today = new Date();
    let maxYear = today.getFullYear() + 1;
    let minYearTM = today.getFullYear() - 8;
    console.log(maxYear);

    $('#tahun-ajaran').empty();
    $('#tahun-ajaran').append('<option value="0" disabled selected>Pilih Tahun Masuk ...</option>');

    for (let i = maxYear; i > minYearTM; i--) {
        let ip1 = i + 1;
        if (metaArr == i) {
            $('#tahun-ajaran').append('<option value="' + i + '" selected>' + i + "/" + ip1 + '</option>');
        } else {
            $('#tahun-ajaran').append('<option value="' + i + '">' + i + "/" + ip1 + '</option>');
        }
    }

    $('#tahun-ajaran').selectric('refresh');
});

// TANGGAL LAHIR SANTRI -------------------------------------------------------------------------------
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    language: 'id'
});

// REMOVE INVALID ON CHANGE  -------------------------------------------------------------------------------
$(".is-invalid:not(div)").change(function () {
    var x = "#" + this.id;
    var d = new Date($.now());
    var today = d.getDate() + "/" + ('0' + (d.getMonth() + 1)).slice(-2) + "/" + d.getFullYear();
    console.log(x);
    if ($(x).val() != '' && $(x).val() != today) {
        $(x).removeClass("is-invalid");
        $(x).parent().find('span.text-danger').remove();
        $(x).parent().parent().find('span.text-danger').remove();
    }
});

$("div .is-invalid select, input[type='date']").change(function () {
    var x = "#" + this.id;
    var date = new Date();
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var today = date.getFullYear() + "-" + (month) + "-" + (day);
    console.log($(x).val());
    if ($(x).val() != '' && $(x).val() != today) {
        $(x).parent().removeClass("is-invalid");
        $(x).parent().parent().parent().removeClass("is-invalid");
        $(x).parent().parent().parent().find('span.text-danger').remove();
    }
});

// function DoSubmit(){
//   let tglLahirArr = $("#tgl-lahir-santri").val().split('/');
//   // console.log(tglLahirArr);
//   let tglLahir = tglLahirArr[2] + "-" + tglLahirArr[1] + "-" + tglLahirArr[0];
//   $("#tgl-lahir-santri").val(tglLahir);
//   return true;
// }
