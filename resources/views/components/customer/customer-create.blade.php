<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Add New Customer</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="customerEmail">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" class="form-control" id="customerPhone">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="addCustomer()" id="save-btn" class="btn btn-sm  btn-success" >Add Customer</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function addCustomer(){
        let name = document.getElementById('customerName').value;
        let email = document.getElementById('customerEmail').value;
        let phone = document.getElementById('customerPhone').value;

        if(name.length === 0){
            errorToast('Customer Name is required');
        }else if(email.length === 0){
            errorToast('Email Address is required');
        }else if(phone.length === 0){
            errorToast('Phone number is required');
        }else{
            document.getElementById('modal-close').click();

            showLoader();
            let response = await axios.post('/customer-create', {
                'name':name,
                'email':email,
                'phone':phone
            })
            hideLoader();

            if(response.status == 200 && response.data['status'] === 'success'){
                successToast('Customer has been created successfully');
                document.getElementById("save-form").reset();
                await  gettingCustomerList();
            }else{
                errorToast('Request fail to create new customer');
            }
        }
    }

</script>