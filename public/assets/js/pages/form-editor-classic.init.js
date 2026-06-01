/*
Template Name: HR System & Dashboard Template
Author: HR System
Website: https://HR System.in/
Contact: HR System@gmail.com
File: Form editor Classic Js File
*/

// ckeditor Classic
var ckClassicEditor = document.querySelectorAll(".ckeditor-classic")
if (ckClassicEditor) {
    Array.from(ckClassicEditor).forEach(function () {
        ClassicEditor
            .create(document.querySelector('.ckeditor-classic'))
            .catch(function (error) {
                console.error(error);
            });
    });
}