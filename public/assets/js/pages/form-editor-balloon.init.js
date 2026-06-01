/*
Template Name: HR System & Dashboard Template
Author: HR System
Website: https://HR System.in/
Contact: HR System@gmail.com
File: Form editor balloon Js File
*/

var ckClassicEditor = document.querySelectorAll(".ckeditor-balloon")
if (ckClassicEditor) {
    Array.from(ckClassicEditor).forEach(function () {
        BalloonEditor
            .create(document.querySelector('.ckeditor-balloon'))
            .catch(function (error) {
                console.error(error);
            });
    });
}