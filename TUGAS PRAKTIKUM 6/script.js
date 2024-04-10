const semuaInput = document.querySelectorAll('form input[type="text"], form input[type="email"], form input[type="password"], form input[type="number"], form input[type="url"], form select[name="gender"]')

const dataForm = {}

const tombolSubmit = document.querySelector('#submitForm');
tombolSubmit.setAttribute('disabled', 'true')

const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const polaNomorTelepon = /^08\d{10}$/;
const polaUrl = /^(?:https?|www)\:\/\/[^\s\/$.?#].[^\s]*$/;

function periksaInput() {
  let semuaInputTerisi = true;

  semuaInput.forEach((input) => {
    if(!input.value.trim()) {
      semuaInputTerisi = false;
    }

    if(input.type === 'url' && !polaUrl.test(input.value)) {
      semuaInputTerisi = false;
      return;
    } 
  })

  return semuaInputTerisi;
}

semuaInput.forEach((input) =>  {
  input.addEventListener('change', () => {
    const isError = tampilkanError(input);

    if(!isError) {
      dataForm[input.name] = input.value;
    } else {
      delete dataForm[input.name];
    }

    if(!periksaInput()) {
      tombolSubmit.setAttribute('disabled', 'true');
    } else {
      tombolSubmit.removeAttribute('disabled');
    }
  });

  input.addEventListener('focus', () => {
    const isError = tampilkanError(input);

    if(isError) {
      delete dataForm[input.name];
    }

    if(!periksaInput()) {
      tombolSubmit.setAttribute('disabled', 'true');
    } else {
      tombolSubmit.removeAttribute('disabled');
    }
  });
});

tombolSubmit.addEventListener('click', (e) => {
  e.preventDefault();
  alert('Data berhasil');
  console.log(dataForm);
});

function tampilkanError(input) {
  const pesanKesalahan = input.nextElementSibling;

  if(input.value === '') {
    pesanKesalahan.innerHTML = "Wajib diisi";
    return true;
  }   
  
  if(input.type === 'email' && !polaEmail.test(input.value)) {
    pesanKesalahan.innerHTML = "Format email tidak valid";
    return true;
  } 

  if(input.type === 'password' && input.value.length < 6) {
    pesanKesalahan.innerHTML = "Password minimal 6 karakter";
    return true;
  } 

  if(input.type === 'number' && !polaNomorTelepon.test(input.value)) {
    if(input.value.length !== 12) {
      pesanKesalahan.innerHTML = "Nomor telepon harus terdiri dari 12 digit";
      return true;
    }
    pesanKesalahan.innerHTML = "Nomor telepon tidak valid";
    return true;
  }  

  if(input.type === 'url' && !polaUrl.test(input.value)) {
    pesanKesalahan.innerHTML = "URL tidak valid";
    return true;
  } 

  pesanKesalahan.innerHTML = "";
  return false;
}
