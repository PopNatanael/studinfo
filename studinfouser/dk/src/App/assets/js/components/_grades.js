$(document).ready(function () {
    $('#years').change(function (e) {
        var year = $('#years').find(":selected").val();
        window.location.href="/grades/studentGrades/"+year;
    });
});