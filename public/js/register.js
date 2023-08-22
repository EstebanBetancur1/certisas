document.addEventListener('DOMContentLoaded',()=>{
    var signupForm = document.querySelector('#signup-form');
    var alert = signupForm.querySelector('.alert');
    signupForm.addEventListener('submit',(event) => {
        signupForm.removeAttribute('class');
        alert.classList.remove('d-none');
        alert.classList.add('d-flex','align-items-center');
        signupForm.querySelectorAll('.invalid-feedback').forEach((elem) => {elem.remove()});
        signupForm.querySelectorAll('input').forEach((elem) => {elem.classList.remove('is-invalid')});
        var formData = new FormData(signupForm);
        fetch(signupForm.getAttribute('action'),{
            method:signupForm.getAttribute('method'),
            headers:{'Accept':'application/json'},
            redirect:'follow',
            body:formData
        }).then(response=>{
            return response.json();
        }).then(data=>{
            alert.classList.remove('d-flex', 'align-items-center');
            alert.classList.add('d-none');
            if(data.errors) {
                signupForm.classList.add('was-validated')
                for(const key in data.errors) {
                    var elem = document.getElementById('signup-'+key);
                    elem.classList.add('is-invalid');
                    var message = document.createElement('label');
                    message.classList.add('invalid-feedback');
                    elem.parentElement.appendChild(message);
                    message.textContent = data.errors[key].toString();
                }
            } else if(data.success) {
                new Notyf({delay:3000}).success(data.success);
                setTimeout(()=>{window.location.reload()},3000)
            } else if (data.error) {
                new Notyf({delay:3000}).error(data.error);
            }
        });
        event.preventDefault();
        event.stopPropagation();
    });
});
