document.addEventListener('DOMContentLoaded', function() {
    var submitButton = document.getElementById('item_add_submit');
    var resetButton = document.querySelector('input[type="button"][value="Hasierara itzuli"]');

    submitButton.addEventListener('click', function() {
        datuakEgiaztatu();
    });

    resetButton.addEventListener('click', function() {
        location.href = '/';
    });
});

function datuakEgiaztatu() {
    var id = document.item_add_form.id.value;
    var izena = document.item_add_form.izena.value;
    var mota = document.item_add_form.mota.value;
    var tamaina = document.item_add_form.tamaina.value;
    var prezioa = document.item_add_form.prezioa.value;

    if (id == "" || izena == "" || mota == "" || tamaina == "" || prezioa == "") {
        window.alert("Zerbait hutsik dago");
        return false;
    }

    if (isNaN(id) || id < 0) {
        window.alert("Id zenbaki bat izan behar da.");
        return false;
    }

    if (isNaN(prezioa) || prezioa < 0) {
        window.alert("Prezioa zenbaki bat izan behar da.");
        return false;
    }

    document.item_add_form.bidalita.value = '1';
    document.item_add_form.submit();
}
