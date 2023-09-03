<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    async function VerifyOtp(){
        let otp = document.getElementById('otp').value;

        if(otp.length !== 4){
            errorToast("Wrong OTP Code");
        }else{
            let URL = '/otp-varify';
            let formInfo = {
                "otp":otp,
                "email":sessionStorage.getItem('email')
            }

            showLoader();
            let response = await axios.post(URL, formInfo)
            hideLoader();

            if(response.status == 200 && response.data['status'] == 'Success'){
                successToast(response.data['message'])
                sessionStorage.clear();
                setTimeout(() => {
                    window.location.href='/resetPassword'
                }, 1000);

            }else{
                errorToast(response.data['message']);
            }
        }
    }

</script>