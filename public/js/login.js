/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/login.js ***!
  \*******************************/
$('#frmLogin').validate({
  rules: {
    username: {
      required: true
    },
    password: {
      required: true
    }
  },
  messages: {
    username: {
      required: 'El nombre del usuario es obligatorio'
    },
    password: {
      required: 'La contraseña del usuario es obligatoria'
    }
  }
});
/******/ })()
;