<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/logo.png')}}"/>
                                <br/>
                                <label class="form-label">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">

                                <input type="text" class="" id="updateID" placeholder="ID"> <br>
                                <input type="text" class="" id="filePath" placeholder="File Path">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn btn-sm btn-success" >Update</button>
            </div>

        </div>
    </div>
</div>



<script>
  
    fillUpTheCategoryDropdown();
    async function fillUpTheCategoryDropdown(){
        showLoader();
        let allCat =await axios.get('/category-list');
        hideLoader();

        allCat.data.forEach(function(item){
            let option = `
            <option value="${item['id']}">${item['name']}</option>
            `

            $("#productCategoryUpdate").append(option);
        })
       
    }

        async function fillupUpdatedForm(id, filePath){
            document.getElementById('updateID').value=id;
            document.getElementById('filePath').value=filePath;
            document.getElementById('oldImg').src=filePath;

            showLoader();
            await fillUpTheCategoryDropdown();
            let allProduct = await axios.post('/product-by-id', {"id":id});
            hideLoader();

            document.getElementById('productNameUpdate').value = allProduct.data['name'];
            document.getElementById('productPriceUpdate').value = allProduct.data['price'];
            document.getElementById('productUnitUpdate').value = allProduct.data['unit'];
            document.getElementById('productCategoryUpdate').value = allProduct.data['category_id'];
          
        }

        async function update(){
            let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
            let productNameUpdate = document.getElementById('productNameUpdate').value;
            let productPriceUpdate = document.getElementById('productPriceUpdate').value;
            let productUnitUpdate = document.getElementById('productUnitUpdate').value;
            let productImgUpdate = document.getElementById('productImgUpdate').value;
            let updateID = document.getElementById('updateID').value;
            let filePath = document.getElementById('filePath').value;

            if (productCategoryUpdate.length === 0) {
                errorToast("Product Category Required !")
            }
            else if(productNameUpdate.length===0){
                errorToast("Product Name Required !")
            }
            else if(productPriceUpdate.length===0){
                errorToast("Product Price Required !")
            }
            else if(productUnitUpdate.length===0){
                errorToast("Product Unit Required !")
            }else{
                document.getElementById('update-modal-close').click();

                let formData=new FormData();
                formData.append('img',productImgUpdate)
                formData.append('id',updateID)
                formData.append('name',productNameUpdate)
                formData.append('price',productPriceUpdate)
                formData.append('unit',productUnitUpdate)
                formData.append('category_id',productCategoryUpdate)
                formData.append('file_path',filePath)

                const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/product-update",formData,config)
            hideLoader();

            if(res.status===200 && res.data['status']==='Success'){
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await getProductList();
            }
            else{
                errorToast("Request fail !")
            }

            }

           
          
        }

</script>