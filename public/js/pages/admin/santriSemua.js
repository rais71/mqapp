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

let idVal="admin/santri/" + $("#modal-delete").attr("value");

$("#modal-delete").fireModal({
  title: 'Konfirmasi Hapus',
  body: '<p>Apakah anda yakin ingin menghapus data ini?</p>',
  created: function(modal) {
    modal.find('.modal-footer').prepend(
      "<div class='mr-auto'><form action='{{ " + idVal +" }}' method='post'> @method('delete') @csrf <button type='submit'>Saya yakin, Hapus!</button></form></div>"
      );
  },
  buttons: [
    {
      text: 'Tidak jadi',
      // submit: true,
      class: 'btn btn-primary btn-shadow',
      handler: function(modal) {
        $('.close').trigger("click");
      }
    }
  ], center: true
});
