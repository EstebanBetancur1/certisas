document.addEventListener('DOMContentLoaded',()=> {
    var resetForm = document.querySelector('#reset-password-form');
    var alert = resetForm.querySelector('.alert');
    resetForm.addEventListener('submit',(event) => {
        resetForm.removeAttribute('class');
        alert.classList.remove('d-none');
        alert.classList.add('d-flex','align-items-center');
        resetForm.querySelectorAll('.invalid-feedback').forEach((elem) => {elem.remove()});
        resetForm.querySelectorAll('input').forEach((elem) => {elem.classList.remove('is-invalid')});
        var formData = new FormData(resetForm);
        fetch(resetForm.getAttribute('action'),{
            method:resetForm.getAttribute('method'),
            headers:{'Accept':'application/json'},
            redirect:'follow',
            body:formData
        }).then(response=>{
            return response.json();
        }).then(data=>{
            alert.classList.remove('d-flex', 'align-items-center');
            alert.classList.add('d-none');
            if(data.errors) {
                resetForm.classList.add('was-validated')
                for(const key in data.errors) {
                    var elem = document.getElementById('reset-'+key);
                    elem.classList.add('is-invalid');
                    var message = document.createElement('label');
                    message.classList.add('invalid-feedback');
                    elem.parentElement.appendChild(message);
                    message.textContent = data.errors[key].toString();
                }
            } else if(data.success) {
                new Notyf({delay:3000}).success(data.success);
                setTimeout(()=>{window.location.replace('/')},3000)
            } else if (data.error) {
                new Notyf({delay:3000}).error(data.error);
            }
        });
        event.preventDefault();
        event.stopPropagation();
    });
});
