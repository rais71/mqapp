"use strict";

// $(".pwstrength").pwstrength();

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
