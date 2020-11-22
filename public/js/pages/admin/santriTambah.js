"use strict";

// GET META CONTENT AND UBAH JADI ARRAY  -------------------------------------------------------------------------------
let metaArr = $('meta[name=var]').attr('content');
let metaContent = metaArr.split(',')

// CLAVE JS FORMAT NOMOR TELPON  -------------------------------------------------------------------------------
$('.phone-number').toArray().forEach(function (field) {
    new Cleave(field, {
        numericOnly: true,
        delimiters: ['-', '-', '-'],
        blocks: [4, 4, 5],
    })
});

// DYNAMIC DROPDOWN LOKASI TEMPAT LAHIR  -------------------------------------------------------------------------------
$('#provinsi-lahir').on('change', function (e) {
    console.log(e);
    var provinsi_id = e.target.value;
    $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
        console.log(data);
        $('#kabupaten-lahir').empty();
        $('#kabupaten-lahir').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');

        $.each(data, function (index, kabupatenObj) {
            $('#kabupaten-lahir').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
        })
    });
});

// DYNAMIC DROPDOWN LOKASI DOMISILI  -------------------------------------------------------------------------------
$('#provinsi-domisili').on('change', function (e) {
    // console.log(e);
    var oldKabDomisili = metaContent[1];
    if (oldKabDomisili == '') {
        var provinsi_id = e.target.value;
        $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
            // console.log(data);
            $('#kabupaten-domisili').empty();
            $('#kabupaten-domisili').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');

            $('#kecamatan-domisili').empty();
            $('#kecamatan-domisili').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');
            $('#kecamatan-domisili').append('<option value="0" disabled>Pilih Kabupaten terlebih dahulu.</option>');

            $.each(data, function (index, kabupatenObj) {
                $('#kabupaten-domisili').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
            })
        });
    }
});

$('#kabupaten-domisili').on('change', function (e) {
    // console.log(e);
    var oldKecDomisili = metaContent[2];
    if (oldKecDomisili == '') {
        var kabupaten_id = e.target.value;
        $.get('/json-kecamatan?kabupaten_id=' + kabupaten_id, function (data) {
            // console.log(data);
            $('#kecamatan-domisili').empty();
            $('#kecamatan-domisili').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');

            $.each(data, function (index, kecamatanObj) {
                $('#kecamatan-domisili').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama + '</option>');
            })
        });
    }
});

// DYNAMIC DROPDOWN LOKASI SEKOLAH  -------------------------------------------------------------------------------
$('#provinsi-sekolah').on('change', function (e) {
    // console.log(e);
    var oldKabDomisili = metaContent[3];
    if (oldKabDomisili == '') {
        var provinsi_id = e.target.value;
        $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
            // console.log(data);
            $('#kabupaten-sekolah').empty();
            $('#kabupaten-sekolah').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');

            $('#kecamatan-sekolah').empty();
            $('#kecamatan-sekolah').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');
            $('#kecamatan-sekolah').append('<option value="0" disabled>Pilih Kabupaten terlebih dahulu.</option>');

            $.each(data, function (index, kabupatenObj) {
                $('#kabupaten-sekolah').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
            })
        });
    }
});

$('#kabupaten-sekolah').on('change', function (e) {
    // console.log(e);
    var oldKecDomisili = metaContent[4];
    if (oldKecDomisili == '') {
        var kabupaten_id = e.target.value;
        $.get('/json-kecamatan?kabupaten_id=' + kabupaten_id, function (data) {
            // console.log(data);
            $('#kecamatan-sekolah').empty();
            $('#kecamatan-sekolah').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');

            $.each(data, function (index, kecamatanObj) {
                $('#kecamatan-sekolah').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama + '</option>');
            })
        });
    }
});

$(document).ready(function () {

    // DYNAMIC DROPDOWN LOKASI TEMPAT LAHIR - OLD INPUT  -------------------------------------------------------------------------------
    var provLahir = $("#provinsi-lahir option:selected").val();
    var oldKabLahir = metaContent[0];
    if (oldKabLahir != '') {
        console.log(provLahir);
        var provinsi_id = provLahir;
        $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
            console.log(data);
            $('#kabupaten-lahir').empty();
            $('#kabupaten-lahir').append('<option value="" disabled selected>Pilih Kabupaten/Kota ...</option>');
            $.each(data, function (index, kabupatenObj) {
                if (kabupatenObj.id == oldKabLahir) {
                    $('#kabupaten-lahir').append(
                        '<option value="' + kabupatenObj.id + '" selected>' + kabupatenObj.nama + '</option>');
                } else {
                    $('#kabupaten-lahir').append(
                        '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
                }
            })
        });
    }

    if (provLahir != 0 && oldKabLahir == "") {
        $('#provinsi-lahir').trigger('change');
    }

    // DYNAMIC DROPDOWN LOKASI DOMISILI - OLD INPUT -------------------------------------------------------------------------------
    var provDomisili = $("#provinsi-domisili option:selected").val();
    var kabDomisili;
    var oldKabDomisili = metaContent[1];
    var oldKecDomisili = metaContent[2];
    if (oldKabDomisili != '') {
        // console.log(provDomisili);
        var provinsi_id = provDomisili;
        $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
            // console.log(data);
            $('#kabupaten-domisili').empty();
            $('#kabupaten-domisili').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');
            $.each(data, function (index, kabupatenObj) {
                if (kabupatenObj.id == oldKabDomisili) {
                    $('#kabupaten-domisili').append(
                        '<option value="' + kabupatenObj.id + '" selected>' + kabupatenObj.nama + '</option>');
                } else {
                    $('#kabupaten-domisili').append(
                        '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
                }
            })

            // console.log(kabDomisili);
            // console.log(oldKecDomisili);
            if (kabDomisili != 0 && oldKecDomisili == "") {
                $('#kabupaten-domisili').trigger('change');
            } else {
                kabDomisili = $("#kabupaten-domisili option:selected").val();
                var kabupaten_id = kabDomisili;
                // console.log(kabDomisili);
                $.get('/json-kecamatan?kabupaten_id=' + kabupaten_id, function (data) {
                    // console.log(data);
                    $('#kecamatan-domisili').empty();
                    $('#kecamatan-domisili').append('<option value="0" disabled selected>Pilih Kecamatan...</option>');

                    $.each(data, function (index, kecamatanObj) {
                        if (kecamatanObj.id == oldKecDomisili) {
                            $('#kecamatan-domisili').append(
                                '<option value="' + kecamatanObj.id + '" selected>' + kecamatanObj.nama + '</option>');
                        } else {
                            $('#kecamatan-domisili').append(
                                '<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama + '</option>');
                        }
                    })
                });
            }
        });
    }

    // KABUPATEN DOMISILI - OLD INPUT CHANGE -------------------------------------------------------------------------------
    if (provDomisili != 0 && oldKabDomisili == "") {
        $('#provinsi-domisili').trigger('change');
    }

    // DYNAMIC DROPDOWN LOKASI SEKOLAH - OLD INPUT  -------------------------------------------------------------------------------
    var provSekolah = $("#provinsi-sekolah option:selected").val();
    var kabSekolah;
    var oldKabSekolah = metaContent[3];
    if (oldKabSekolah != '') {
        // console.log(oldKabSekolah);
        var provinsi_id = provSekolah;
        $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
            // console.log(data);
            $('#kabupaten-sekolah').empty();
            $('#kabupaten-sekolah').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');
            $.each(data, function (index, kabupatenObj) {
                if (kabupatenObj.id == oldKabSekolah) {
                    $('#kabupaten-sekolah').append(
                        '<option value="' + kabupatenObj.id + '" selected>' + kabupatenObj.nama + '</option>');
                } else {
                    $('#kabupaten-sekolah').append(
                        '<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
                }
            })

            // console.log(kabSekolah);
            var oldKecSekolah = metaContent[4];
            if (kabSekolah != 0 && oldKecSekolah == "") {
                $('#kabupaten-sekolah').trigger('change');
            } else {
                kabSekolah = $("#kabupaten-sekolah option:selected").val()
                var kabupaten_id = kabSekolah;
                $.get('/json-kecamatan?kabupaten_id=' + kabupaten_id, function (data) {
                    // console.log(data);
                    $('#kecamatan-sekolah').empty();
                    $('#kecamatan-sekolah').append('<option value="0" disabled selected>Pilih Kecamatan...</option>');

                    $.each(data, function (index, kecamatanObj) {
                        if (kecamatanObj.id == oldKecSekolah) {
                            $('#kecamatan-sekolah').append(
                                '<option value="' + kecamatanObj.id + '" selected>' + kecamatanObj.nama + '</option>');
                        } else {
                            $('#kecamatan-sekolah').append(
                                '<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama + '</option>');
                        }
                    })
                });
            }
        });
    }

    if (provSekolah != 0 && oldKabSekolah == "") {
        $('#provinsi-sekolah').trigger('change');
    }

    // DYNAMIC DROPDOWN TAHUN LULUS  -------------------------------------------------------------------------------
    let today = new Date();
    let nowYear = today.getFullYear();
    let maxYear = today.getFullYear() + 1;
    let minYearTL = today.getFullYear() - 10;
    // console.log(minYearTL);

    $('#tahun-lulus').empty();
    $('#tahun-lulus').append('<option value="0" disabled selected>Pilih Tahun Lulus ...</option>');

    for (let i = maxYear; i > minYearTL; i--) {
        if (metaContent[5] == i) {
            console.log(i);
            $('#tahun-lulus').append('<option value="' + i + '" selected>' + i + '</option>');
        } else {
            $('#tahun-lulus').append('<option value="' + i + '">' + i + '</option>');
        }
    }

    $('#tahun-lulus').selectric('refresh');

    // DYNAMIC DROPDOWN TAHUN MASUK  -------------------------------------------------------------------------------
    let minYearTM = today.getFullYear() - 6;
    $('#tahun-masuk').empty();
    $('#tahun-masuk').append('<option value="0" disabled selected>Pilih Tahun Masuk ...</option>');

    for (let i = maxYear; i > minYearTM; i--) {
        if (metaContent[6] == i) {
            $('#tahun-masuk').append('<option value="' + i + '" selected>' + i + '</option>');
        } else {
            $('#tahun-masuk').append('<option value="' + i + '">' + i + '</option>');
        }
    }

    $('#tahun-masuk').selectric('refresh');

    // WALI LOGIC HIDDEN SHOW  ------------------------------------------------------------------------------------------------
    var wali = document.getElementById("wali");
    var x = "#" + this.id;
    $('#wali').change(function dataWali() {
        if ($(x).val() != '') {
            $(x).parent().parent().removeClass("is-invalid");
            $(x).parent().parent().find('span.text-danger').remove();
        }
        if (wali.value == 3) {
            $('.siapa-wali').addClass('col-md-6 col-lg-6');
            setTimeout(function () {
                $('.data-wali').show(500);
                $('.data-wali').removeClass('hidden');
            }, 500);
        } else {
            $('.data-wali').hide(10);
            setTimeout(function () {
                $('.data-wali').addClass('hidden');
            }, 10);
            $('.siapa-wali').removeClass('col-md-6 col-lg-6');
        }
    });
    if (wali.value != "") {
        $('#wali').trigger('change');
    }
});

// DYNAMIC DROPDOWN LOKASI INSTANSI PENDIDIKAN  -------------------------------------------------------------------------------
$('#provinsi-sekolah').on('change', function (e) {
    // console.log(e);
    var provinsi_id = e.target.value;
    $.get('/json-kabupaten?provinsi_id=' + provinsi_id, function (data) {
        // console.log(data);
        $('#kabupaten-sekolah').empty();
        $('#kabupaten-sekolah').append('<option value="0" disabled selected>Pilih Kabupaten/Kota ...</option>');

        $('#kecamatan-sekolah').empty();
        $('#kecamatan-sekolah').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');
        $('#kecamatan-sekolah').append('<option value="0" disabled>Pilih Kabupaten terlebih dahulu.</option>');

        $.each(data, function (index, kabupatenObj) {
            $('#kabupaten-sekolah').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama + '</option>');
        })
    });
});

$('#kabupaten-sekolah').on('change', function (e) {
    // console.log(e);
    var kabupaten_id = e.target.value;
    $.get('/json-kecamatan?kabupaten_id=' + kabupaten_id, function (data) {
        console.log(data);
        $('#kecamatan-sekolah').empty();
        $('#kecamatan-sekolah').append('<option value="0" disabled selected>Pilih Kecamatan ...</option>');

        $.each(data, function (index, kecamatanObj) {
            $('#kecamatan-sekolah').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama + '</option>');
        })
    });
});

// TANGGAL LAHIR SANTRI -------------------------------------------------------------------------------
$('.datepicker').datepicker({
  format: 'dd/mm/yyyy',
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

// FILE NAME CHANGE  -------------------------------------------------------------------------------
$('.custom-file-input').on('change', function (e) {
  // console.log(e);
  var x = "label[for='" + this.id + "']";
  var nilai = e.target.value;

  $(x).text(nilai.split(/(\\|\/)/g).pop());
});
