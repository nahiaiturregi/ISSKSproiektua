document.addEventListener('DOMContentLoaded', function() {
    var submitButton = document.getElementById('login_submit');
    var resetButton = document.getElementById('reset_button');

    submitButton.addEventListener('click', function() {
        datuakEgiaztatu(); 
    });

    resetButton.addEventListener('click', function() {
        location.href = '/'; 
    });
});

function datuakEgiaztatu() {
    var erabiltzailea = document.login_form.erabiltzailea.value;
    var pasahitza = document.login_form.pasahitza.value;
    if (erabiltzailea == "" || pasahitza == "") {
        window.alert("Erabiltzailea edo pasahitza hutsik dago");
    } else {
        document.login_form.submit();
    }
}
