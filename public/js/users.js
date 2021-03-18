/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
$('#tblUsers').on('click', '.btnDeleteUser', function (e) {
  var user = $(this);
  $.confirm({
    title: 'Eliminar usuario',
    content: '¿Esta seguro de eliminar este usuario?',
    type: 'blue',
    typeAnimated: true,
    useBootstrap: false,
    boxWidth: '400px',
    buttons: {
      tryAgain: {
        text: 'Eliminar',
        btnClass: 'btn-blue',
        action: function action() {
          $.ajax({
            url: user.data('route-delete'),
            type: 'delete',
            dataType: 'json'
          }).done(function (response) {
            var total = parseInt($('#totalUsers').text()) - 1;
            $('#totalUsers').text(total);
            user.closest('tr').fadeOut();
            notification({
              type: 'success',
              title: '&#x2705; &nbsp; Buen trabajo',
              message: response.message
            });
          });
        }
      },
      close: {
        text: 'Cancelar'
      }
    }
  });
});
$('#tblUsers').on('click', '.btnEditProvider', function (e) {
  var provider = $(this);
  window.location.href = provider.data('route-edit');
});
/******/ })()
;