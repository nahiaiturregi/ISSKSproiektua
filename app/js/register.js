document.addEventListener('DOMContentLoaded', function() {
    var submitButton = document.getElementById('register_submit');
    var resetButton = document.querySelector('input[type="button"][value="Hasierara itzuli"]');
    
    submitButton.addEventListener('click', function() {
        datuakEgiaztatu();
    });

    resetButton.addEventListener('click', function() {
        location.href = '/'; 
    });
});

function datuakEgiaztatu() {
    const form = document.forms["register_form"];
    const name = form["name"].value.trim();
    const nan = form["nan"].value.trim();
    const email = form["email"].value.trim();
    const phone = form["phone"].value.trim();
    const jaiotze_data = form["jaiotze_data"].value.trim();
    const password = form["password"].value.trim();

    if (name === "" || nan === "" || email === "" || phone === "" || jaiotze_data === "" || password === "") {
        alert("Eremu guztiak bete behar dira.");
        return false;
    }

    const nanRegex = /^\d{8}-[A-Z]$/;
    if (!nanRegex.test(nan)) {
        alert("DNI formatu baliogabea. 8 zenbaki, gidoia eta letra bat izan behar ditu.");
        return false;
    }
    const [zenbakiak, letra] = nan.split('-');
    const dni = parseInt(zenbakiak, 10);
    const letraIndex = dni % 23;
    const letrak = "TRWAGMYFPDXBNJZSQVHLCKET";
    const letrakalkulatua = letrak[letraIndex];
    if (letra !== letrakalkulatua) {
        alert(`DNI letra ez da zuzena.`);
        return false;
    }

    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(jaiotze_data)) {
        alert("Data formatu baliogabea(uuuu-hh-ee).");
        return false;
    }

    const phoneRegex = /^\d{9}$/;
    if (!phoneRegex.test(phone)) {
        alert("Telefono zenbaki baliogabea");
        return false;
    }

    const emailRegex = /^.+@.+\..+$/;
    if (!emailRegex.test(email)) {
        alert("Posta elektroniko baliogabea");
        return false;
    }

    document.register_form.bidalita.value = '1';
    document.register_form.submit();
    return true;
}
