document.addEventListener('DOMContentLoaded',()=>{
    var sCompany = document.querySelector('#s-company');
    var sTemplate = document.querySelector('#s-template');
    var sType = document.querySelector('#s-type');
    var sYear = document.querySelector('#s-year');
    var btnCleanFilters = document.querySelector('#btn-clean-filters');
    var filterForm = document.querySelector('#filter-form');
    var deleteButton = document.querySelector('#delete-button');
    var selectedRows = [];
    var table = $('#list-items').DataTable({
        filter: true,
        searching: true,
        responsive: true,
        columnDefs: [{targets: 0, checkboxes: {selectRow: true}},{targets: 5, data: null, defaultContent: '<button class="btn btn-primary">Editar</button>'}],
        select: {style:'multi'},
        order: [['1', 'asc']],
        columns: [{data: 'id'}, {data: 'nit'}, {data: 'nombre'}, {data: 'documento'}, {data: 'concepto'}],
        ordering: false,
        language: {url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
    });

    btnCleanFilters.addEventListener('click', (event) => {
        sType.value = '';
        sYear.value = '';
        sTemplate.value = '';
        event.preventDefault();
        event.stopPropagation();
    });

    filterForm.addEventListener('submit', (event) => {
        var formData = new FormData(filterForm);
        formData.append('company',sCompany.value);
        fetch(filterForm.getAttribute('action'), {
            method: 'post',
            headers: {'Accept':'application/json'},
            body:formData
        }).then(response => {
            if (!response.ok) new Notyf({delay:3000}).error('Error al realizar la solicitud.')
            return response.json();
        }).then(data => {
            if (data.errors) {
                filterForm.classList.add('was-validated')
                for(const key in data.errors) {
                    var elem = document.getElementById('s-'+key);
                    elem.classList.add('is-invalid');
                    var message = document.createElement('label');
                    message.classList.add('invalid-feedback');
                    elem.parentElement.appendChild(message);
                    message.textContent = data.errors[key].toString();
                }
            } else {
                table.clear();
                table.rows.add(data).draw();
            }
        }).catch(error => {
            new Notyf({delay:3000}).error(error);
        });
        event.preventDefault();
        event.stopPropagation();
    });

    $('#list-items tbody').on('click', 'button', function (event) {
        var data = table.row($(this).parents('tr')).data();
        window.location.replace('/backoffice/templates/'+data.id+'/edit');
        event.preventDefault();
        event.stopPropagation();
    });

    table.on('select', (e, dt, type, indexes) => {
        var rows = table.rows( indexes ).data().toArray();
        console.log(rows);
        for (var row of rows) {
            selectedRows.push(row);
        }
        if (selectedRows.length>0) deleteButton.classList.remove('d-none');
    }).on('deselect', (e, dt, type, indexes) => {
        var rows = table.rows( indexes ).data().toArray();
        for (var row of rows) {
            var index = selectedRows.indexOf(row);
            selectedRows.splice(index,1);
        }
        if (selectedRows.length===0) deleteButton.classList.add('d-none');
    });

    deleteButton.addEventListener('click', (event) => {
        if (selectedRows.length>0) {
            for(var row of selectedRows) {

            }
            $('#deleteModal').modal('show');

        } else new Notyf({delay:3000}).warn('Ningún registro seleccionado.');
        event.preventDefault();
        event.stopPropagation();
    });

    $('#deleteModal #confirm-delete').click((event) => {
        if (selectedRows.length>0) {
            var json = '[';
            for(var row of selectedRows) {
                table.data().row(row).remove();
                json += row.id+',';
            } json = json.substring(0,(json.length-1))+']';
            var form = document.querySelector('#deleteModal form');
            var token = (new FormData(form)).get('_token');
            fetch($('#deleteModal form').attr('action'), {
                method: 'post',
                headers: {'Accept':'application/json', 'Content-Type': 'application/json'},
                body:'{"_token":"'+token+'","templates":'+json+'}'
            }).then(response => {
                if (response.ok) {
                    deleteButton.classList.add('d-none');
                    selectedRows = [];
                    table.draw();
                    $('#deleteModal').modal('hide');
                }
                return response.json();
            }).then(data => {
                if (data.error) new Notyf({delay:3000}).error(data.error);
                else if (data.message) new Notyf({delay:3000}).success(data.message);
            }).catch(error => {
                new Notyf({delay:3000}).error(error);
            });
            $('#deleteModal').modal('show');
        } else new Notyf({delay:3000}).warn('Ningún registro seleccionado.');
        event.preventDefault();
        event.stopPropagation();
    });
});
