$(function () {
    var sTemplate = document.querySelector('#s-template');

    $('#s-company').on("change", function(){
        var input = $(this);

        var url = input.attr("data-url");

        var html = '<option value="">Seleccione</option>';
        var company = input.val();

        if (company !== '' && company !== undefined && company !== null) {
            fetch(url, {
                method: 'post',
                headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
                body: '{"data":"options","company":' + company + ', "_token":"xxx"}'
            }).then(function(response){

                if (!response.ok) {
                    new Notyf({delay: 3000}).error('Error al realizar la solicitud.');
                }else{
                    new Notyf({delay: 3000}).success('Se ha cambiado de entidad correctamente.');
                    return response.json();
                }

            }).then(function(data){
                location.href ='/backoffice/switch/company';
            });

        } else {
            sTemplate.innerHTML = html;
            new Notyf({delay: 3000}).error('Debes seleccionar un(a) usuario/empresa.');
        }

        console.log("input", input);
    });
});

/*

document.addEventListener('DOMContentLoaded', () = > {
    var sCompany = document.querySelector('#s-company');

    sCompany.addEventListener('change', () = > {
        var html = '<option value="">Seleccione</option>';
        var company = sCompany.value;

        if (company !== '' && company !== undefined && company !== null) {
            fetch(filterForm.getAttribute('action'), {
                method: 'post',
                headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
                body: '{"data":"options","company":' + company + ', "_token":"' + filterForm.querySelector('[name="_token"]').value + '"}'
            }).then(response = > {

                if (!response.ok) {
                    new Notyf({delay: 3000}).error('Error al realizar la solicitud.');
                }else{
                    new Notyf({delay: 3000}).success('Se ha cambiado de entidad correctamente.');
                    return response.json();
                }

            }).then(data = > {
                for(var item of data){
                    html += '<option value="' + item.id + '">' + item.nombre + '</option>';
                }

                sTemplate.innerHTML = html;
            });
        } else {
            sTemplate.innerHTML = html;
            new Notyf({delay: 3000}).error('Debes seleccionar un(a) usuario/empresa.');
        }
    });
});
*/