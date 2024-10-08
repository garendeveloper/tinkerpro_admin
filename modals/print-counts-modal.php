<style>
    #printcount_modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #printcount_modal .modal-content {
        background-color: #1E1C11;
        margin: 10% auto;
        max-width: 500px;
        height: 25%;
        max-height: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #printcount_modal .modal-content {
            margin: 30% auto;
        }
    }

    #printcount_modal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #printcount_modal .modal-header,
    .modal-body {
        border: none;
    }

    #printcount_modal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    }

    #btn_ic_bondpaper,
    #btn_ic_thermal {
        width: 300px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding-bottom: 3px;
    }

    #btn_ic_bondpaper {
        border: 1px solid greenyellow;
    }

    #btn_ic_bondpaper:hover,
    #btn_ic_thermal:hover {
        background-color: #151515;
        border: 1px solid greenyellow;
    }

    #printcount_modal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #printcount_modal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #1E1C11;
    }

    #printcount_modal #btn_cancel:hover {
        background-color: red;
    }

    #printcount_modal #btn_print:hover {
        background-color: green;
    }

    #printcount_modal .action-button {
        position: absolute;
        right: 180px;
    }

    #printcount_modal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #printcount_modal p {
        font-weight: normal;
    }
</style>

<div id="printcount_modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h6> <i class="bi bi-printer"></i> Print Count Sheet </h6>
            <span>
                <button id="close-modal">X</button>
            </span>
        </div>
        <div class="modal-body">
            <input type="hidden" id="active_print" value="1">
            <input type="hidden" value = "0" id = "inv_id">
            <div class="firstCard">
                <button id="btn_ic_bondpaper">
                    <h6>Print on Bond Paper Size</h6>
                    <p>A4,Letter,Legal</p>
                </button>
                <button id="btn_ic_thermal">
                    <h6>Print on Thermal Paper Size</h6>
                    <p>58mm, 80mm</p>
                </button>
                <div class="action-button">
                    <button id="btn_cancel">Cancel</button>
                    <button id="btn_print">Print</button>
                </div>
            </div>
            <div class="secondCard">
                <div class="image">
                    <img src="assets/img/bond-papersize.png" id="ic_img_preview" alt="Thermal Paper Rolls">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#printcount_modal #close-modal, #btn_cancel").on("click", function () {
            $("#printcount_modal").hide();
        })
        $("#btn_ic_bondpaper").on("click", function () {
            $("#ic_img_preview").attr("src", "assets/img/bond-papersize.png");
            $("#btn_ic_thermal").css('border', '1px solid #ccc');
            $(this).css('border', '1px solid greenyellow');
            $("#active_print").val("1");
        });
        $("#btn_ic_thermal").on("click", function () {
            $("#ic_img_preview").attr("src", "assets/img/thermal-paper.jpg");
            $("#btn_ic_bondpaper").css('border', '1px solid #ccc');
            $(this).css('border', '1px solid greenyellow');
            $("#active_print").val("2");
        });
        $("#printcount_modal #btn_print").on("click", function () {
            var inventory_id = $("#inv_id").val();
            var type = $("#active_print").val();
            $('#show_purchasePrintModal').show()
            $("#show_purchasePrintModal .warning-title").text("SHOW INVENTORY COUNT REPORT");
            if($('#show_purchasePrintModal').is(":visible"))
            {
                var loadingImage = document.getElementById("loadingImage");
                loadingImage.removeAttribute("hidden");
                var pdfFile= document.getElementById("pdfFile");
                pdfFile.setAttribute('hidden',true);

                $.ajax({
                    url: "./toprint/printcount_sheet.php",
                    method: "GET",
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        type: type,
                        inv_id: inventory_id,
                    },
                    success: function (response) 
                    {
                  
                        loadingImage.setAttribute("hidden",true);
                        var pdfFile = document.getElementById("pdfFile");
                        pdfFile.removeAttribute('hidden')
                        if( loadingImage.hasAttribute('hidden')) 
                        {
                            var newBlob = new Blob([response], { type: 'application/pdf' });
                            var blobURL = URL.createObjectURL(newBlob);
                            $('#pdfViewer').attr('src', blobURL);
                        }
                        // if(type === "1")
                        // {
                        //     loadingImage.setAttribute("hidden",true);
                        //     var pdfFile = document.getElementById("pdfFile");
                        //     pdfFile.removeAttribute('hidden')
                        //     if( loadingImage.hasAttribute('hidden')) 
                        //     {
                        //         var newBlob = new Blob([response], { type: 'application/pdf' });
                        //         var blobURL = URL.createObjectURL(newBlob);
                        //         $('#pdfViewer').attr('src', blobURL);
                        //     }
                        // }
                        // else
                        // {
                            // var response = response.pdfContent;
                            // loadingImage.setAttribute("hidden",true);
                            // var pdfFile = document.getElementById("pdfFile");
                            // pdfFile.removeAttribute('hidden')
                            // if( loadingImage.hasAttribute('hidden')) 
                            // {
                            //     console.log(response)
                            //     var newBlob = new Blob([response], { type: 'application/pdf' });
                            //     var blobURL = URL.createObjectURL(newBlob);
                            //     $('#pdfViewer').attr('src', newBlob);
                            // }
                            // if(response.success)
                            // {
                            //     var pdfContent = response.pdfContent;
                            //     var pdfData = 'data:application/pdf;base64,' + pdfContent;
                            //     $('#pdfViewer').attr('src', pdfData);
                            //     $('#pdfFile').removeAttr('hidden');
                            //     $('#loadingImage').attr('hidden', true);
                            // }
                        //     var pdfContent = atob(response.pdfContent);

                        //     // Load PDF content into iframe for preview
                        //     var iframe = document.getElementById('pdfViewer');
                        //     iframe.src = 'data:application/pdf;base64,' + response.pdfContent;
                        // }
                    },
                    error: function (xhr, status, error) {
                        alert("Printing failed: " + xhr.responseText);
                    }
                });
            }
        })
    });
</script>