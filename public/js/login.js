document.addEventListener('DOMContentLoaded',()=>{
    var loginForm = document.querySelector('#login-form');
    var alert = loginForm.querySelector('.alert');
    loginForm.addEventListener('submit',(event) => {
        loginForm.removeAttribute('class');
        alert.classList.remove('d-none');
        alert.classList.add('d-flex','align-items-center');
        loginForm.querySelectorAll('.invalid-feedback').forEach((elem) => {elem.remove()});
        loginForm.querySelectorAll('input').forEach((elem) => {elem.classList.remove('is-invalid')});
        var formData = new FormData(loginForm);
        fetch(loginForm.getAttribute('action'),{
            method:loginForm.getAttribute('method'),
            headers:{'Accept':'application/json'},
            redirect:'follow',
            body:formData
        }).then(response=>{
            if(!response.ok) return response.json();
            else window.location.replace(response.url);
        }).then(data=>{
            alert.classList.remove('d-flex', 'align-items-center');
            alert.classList.add('d-none');
            if(data.errors) {
                loginForm.classList.add('was-validated')
                for(const key in data.errors) {
                    var elem = document.getElementById('login-'+key);
                    elem.classList.add('is-invalid');
                    var message = document.createElement('label');
                    message.classList.add('invalid-feedback');
                    elem.parentElement.appendChild(message);
                    message.textContent = data.errors[key].toString();
                }
            }
        });
        event.preventDefault();
        event.stopPropagation();
    });
});
