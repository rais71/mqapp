"use strict";

$("[data-checkboxes]").each(function () {
    var me = $(this),
        group = me.data('checkboxes'),
        role = me.data('checkbox-role');

    me.change(function () {
        var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
            checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
            dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
            total = all.length,
            checked_length = checked.length;

        if (role == 'dad') {
            if (me.is(':checked')) {
                all.prop('checked', true);
            } else {
                all.prop('checked', false);
            }
        } else {
            if (checked_length >= total) {
                dad.prop('checked', true);
            } else {
                dad.prop('checked', false);
            }
        }
    });
});

// FILE NAME CHANGE  -------------------------------------------------------------------------------
$('.custom-file-input').on('change', function (e) {
    // console.log(e);
    var x = "label[for='" + this.id + "']";
    var nilai = e.target.value;

    $(x).text(nilai.split(/(\\|\/)/g).pop());
});

// $('#hapusDataTerpilih').on('click', function (e) {
//     e.preventDefault();
//     var allids = [];
//     $('input:checkbox[name=duid]:checked').each(function () {
//         allids.push($(this).val());
//     });

//     $.ajax({
//         url: '/admin/santri/du/hapus_terpilih',
//         type: 'DELETE',
//         data: {
//             ids: allids,
//             _token: $('input[name=_token]').val()
//         },
//         success: function (response) {
//             $.each(allids, function (key, val) {
//                 $('#duid' + val).remove();
//             })
//         }
//     });
// });
