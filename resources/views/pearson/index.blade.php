@extends('default')

@section('content')
    @if(empty($persons))
        <div class="mt-5">
            <span>No records to show!</span>
        </div>
        <div>
            <button class="btn btn-primary addPearsonModal">Add Pearson</button>
        </div>
    @else
        <div class="mt-3">
            <h4>List of Persons</h4>
        </div>
        <div>
            <button class="btn btn-primary addPearsonModal">Add Pearson</button>
        </div>
        <div class="mt-5">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($persons as $pearson)
                    <tr>
                        <th scope="row">{{$pearson['id']}}</th>
                        <td>{{$pearson['name']}}</td>
                        <td>{{$pearson['email']}}</td>
                        <td>
                            <button data-id="{{$pearson['id']}}" title="Add Contact" class="btnAddContactModal btn btn-primary"><i class="bi bi-telephone-plus-fill"></i></button>
                            <button data-id="{{$pearson['id']}}" title="Edit Pearson" class="btnEditPearsonModal btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button data-id="{{$pearson['id']}}" title="List Contacts" class="btnListContactsModal btn btn-secondary"><i class="bi bi-list"></i></button>
                            <button data-id="{{$pearson['id']}}" title="Delete Pearson" class="btnDeletePearson btn btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    @endif
@endsection

@include('contact.add_contact_modal')
@include('contact.list_contact_modal')
@include('pearson.edit_pearson_modal')
@include('pearson.add_pearson_modal')

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    $( document ).ready(function() {

        $('.btnAddContactModal').on('click', function (){
            $('#countryCodeSelect').val('');
            $('#contactNumber').val('');
            let id = $(this).data('id');
            $('#idPearson').val(id);

            let modal = new bootstrap.Modal(document.getElementById('addContactModal'))
            modal.show();
        });

        $('.addPearsonModal').on('click', function (){
            let modal = new bootstrap.Modal(document.getElementById('addPearsonModal'))
            modal.show();
        });

        $('.btnEditPearsonModal').on('click', function (){
            let id = $(this).data('id');
            let urlRoute = '{{ route("getPearson", ":id") }}';
            urlRoute = urlRoute.replace(':id', id);
            $.ajax({
                url: urlRoute,
                method: 'GET',
                success: function(result){
                    $('#name').val(result.name);
                    $('#email').val(result.email);
                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });


            $('#idPearson').val(id);
            let modal = new bootstrap.Modal(document.getElementById('editPearsonModal'))
            modal.show();
        });

        $('.btnDeletePearson').on('click', function (){
            if(confirm('Do you really want delete this pearson?')){
                let id = $(this).data('id');
                let urlRoute = '{{ route("deletePearson") }}';

                const dataForm = new FormData();

                dataForm.append('idPearson', id);
                dataForm.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: urlRoute,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: dataForm,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(result){
                        alert(result);
                        window.location.reload();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {

                    }
                });
            }

        });


        $('.btnListContactsModal').on('click', function (){
            let table = $('#tableContacts');
            let tbody = $('#tbodyContacts');
            let loader = $('.loader');
            let id = $(this).data('id');
            let urlRoute = '{{ route("getPearsonContacts", ":id") }}';

            urlRoute = urlRoute.replace(':id', id);

            loader.show();
            table.hide();

            $.ajax({
                url: urlRoute,
                method: 'GET',
                success: function(result){
                    let html = '';
                    $.each(result, function( index, value ) {
                        html += '<tr>';
                        html += '<td>' + value.country_code + '</td>';
                        html += '<td>' + value.number + '</td>';
                        html += '<td><button data-id="' + value.id + '" title="Delete Contact" class="btnDeleteContact btn btn-sm btn-danger">Delete</button></td>';
                        html += '</tr>';
                    });
                    tbody.html(html);
                    table.show();
                    loader.hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });


            $('#idPearson').val(id);
            let modal = new bootstrap.Modal(document.getElementById('listContactModal'))
            modal.show();
        });

        $('.btnDeleteContact').on('click', function (){
            console.log('teste');
        })

        $('#countryCodeSelect').on('keyup', function (){
            let text = $('#countryCodeSelect').val()
            let datalist = $('#datalistOptions');
            if(text === ''){
                return;
            }
            $.ajax({
                url: "https://restcountries.com/v2/name/" + text,
                method: 'GET',
                success: function(result){
                    let options = '';
                    $.each(result, function( index, value ) {
                        let nameCountry = value.name;
                        let callingCode = value.callingCodes[0];
                        options += '<option value="' + nameCountry + ' ('+ callingCode +')">';

                    });
                    datalist.html(options);
                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });
        })

        $('#btnAddContact').on('click', function(){
            let countryCodeInput = $('#countryCodeSelect').val();
            let numberInput = $('#contactNumber').val();
            let idPearson = $('#idPearson').val();

            if(countryCodeInput === '' || numberInput === ''){
                alert('Country Code and Number are required!');
                return;
            }

            if(numberInput.length != 9){
                alert('Number must have 9 digits!');
                return;
            }

            let countryCode = formatCountryCodeString(countryCodeInput);

            const dataForm = new FormData();

            dataForm.append('countryCode', countryCode);
            dataForm.append('number', numberInput);
            dataForm.append('idPearson', idPearson);
            dataForm.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: '{{ route('storeContact') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: dataForm,
                processData: false,
                cache: false,
                contentType: false,
                success: function( data ) {
                    alert(data);
                    window.location.reload();
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
            return false;
        });

        $('#btnEditPearson').on('click', function(){
            let name = $('#name').val();
            let email = $('#email').val();
            let idPearson = $('#idPearson').val();

            if(name === '' || name === ''){
                alert('Name and Email are required!');
                return;
            }

            const dataForm = new FormData();

            dataForm.append('name', name);
            dataForm.append('email', email);
            dataForm.append('idPearson', idPearson);
            dataForm.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: '{{ route('editPearson') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: dataForm,
                processData: false,
                cache: false,
                contentType: false,
                success: function( data ) {
                    alert(data);
                    window.location.reload();
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
            return false;
        });

        $('#btnAddPearson').on('click', function(){
            let name = $('#nameStore').val();
            let email = $('#emailStore').val();

            if(name === '' || name === ''){
                alert('Name and Email are required!');
                return;
            }

            const dataForm = new FormData();

            dataForm.append('name', name);
            dataForm.append('email', email);
            dataForm.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: '{{ route('storePearson') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: dataForm,
                processData: false,
                cache: false,
                contentType: false,
                success: function( data ) {
                    alert(data);
                    window.location.reload();
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
            return false;
        });

        function formatCountryCodeString(countryCode){
            let words = countryCode.split('(');
            words = words[1].split(')');
            return words[0]
        }
    });

</script>
