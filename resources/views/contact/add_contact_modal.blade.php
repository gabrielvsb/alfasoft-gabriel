<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addContactLabel">Add Contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addContactForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="idPearson">
                        <label for="countryCodeSelect" class="form-label">Country Code</label>
                        <input type="text" list="datalistOptions" class="form-control" id="countryCodeSelect">
                        <datalist id="datalistOptions">

                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label">Number</label>
                        <input type="text" class="form-control" maxlength="9" minlength="9" id="contactNumber" name="contactNumber">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnAddContact" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
