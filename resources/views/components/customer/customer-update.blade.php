<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customNameUpdate">

                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customEmailUpdate">

                                <label class="form-label">Customer Phone *</label>
                                <input type="text" class="form-control" id="customPhoneUpdate">

                                <input class="" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="UpdateCustomer()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>

    async function fillUpCustomerUpdateForm(id){
        document.getElementById("updateID").value = id;

        showLoader();
        let singleCustomer = await axios.post('/customer-by-id', {id:id});
        hideLoader();

        document.getElementById("customNameUpdate").value = singleCustomer.data['name'];
        document.getElementById("customEmailUpdate").value = singleCustomer.data['email'];
        document.getElementById("customPhoneUpdate").value = singleCustomer.data['phone'];
    }

    async function UpdateCustomer(){
        let ud_name = document.getElementById('customNameUpdate').value;
        let ud_email = document.getElementById('customEmailUpdate').value;
        let ud_phone = document.getElementById('customPhoneUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if(ud_name.length === 0){
            errorToast("Customer name is required !")
        }else if(ud_email.length === 0){
            errorToast("Email address is required !")
        }else if(ud_phone.length === 0){
            errorToast("Phone number is required !")
        }else{
            document.getElementById('update-modal-close').click();

            showLoader();
            let ud_response = await axios.post('/customer-update', {
                name:ud_name,
                email:ud_email,
                phone:ud_phone,
                id:updateID
            })
            hideLoader();

            if(ud_response.status === 200 && ud_response.data['status'] === 'success'){
                successToast("Request success to update customer !");
                document.getElementById("update-form").reset();
                await  gettingCustomerList();
            }else{
                errorToast('Request Failed')
            }
        }
    }

</script>