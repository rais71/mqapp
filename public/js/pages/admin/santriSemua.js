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

// $("#sortable-table tbody").sortable({
//     handle: '.sort-handler'
// });

$('.tombol-konfirmasi-hapus').on('click', function(){
  let idVal="/admin/santri/" + $(this).attr("value");
  $('#form-konfirmasi-hapus').attr('action', idVal);
});

// $("#modal-delete").fireModal({
//   title: 'Konfirmasi Hapus',
//   body: '<p>Apakah anda yakin ingin menghapus data ini?</p>',
//   created: function(modal) {
//     modal.find('.modal-footer').prepend(
//       "<div class='mr-auto'><form action='{{ " + idVal +" }}' method='post'> <input type='hidden' name='_method' value='DELETE'> <input type='hidden' name='_token' value='{{ csrf_token() }}' /> <button type='submit' class='btn btn-delete btn-shadow'>Saya yakin, Hapus!</button></form></div>"
//       );
//   },
//   buttons: [
//     {
//       text: 'Tidak jadi',
//       // submit: true,
//       class: 'btn btn-primary btn-shadow',
//       handler: function(modal) {
//         $('.close').trigger("click");
//       }
//     }
//   ], center: true
// });
