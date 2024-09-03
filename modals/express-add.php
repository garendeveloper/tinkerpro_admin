

<style>

    .close-receive {
        background: none;
        box-shadow: none;
        border: none;
    }

    .close-receive i{
        font-size: medium;
    }

    .close-receive:hover {
        background: none;
        box-shadow: none;
    }

    .modal-body {
        color: var(--text-color);
        background: var(--background-color);
        border-radius: 5px;
    }

    .express-entry {
        border-radius: 5px;
    }

    .express-search,  .express-enter{
        border: none;
        background: var(--primary-color);
        box-shadow: none;
        outline: none;
    }

    .express-cancel {
        box-shadow: none;
        outline: none;
        border: none;
    }

    .express-search:hover, .express-enter:hover { 
        background: var(--primary-color);
        box-shadow: none;
    }
    
    .express-label {
        font-size: medium;
    }

    .product_detail_text, .empty-details {
        align-content: center;
    }

    .empty-details {
        text-align: center;
        color: gray;
        max-height: 200px;
        min-height: 200px;
    }

    .product_image {
        text-align: center;
        max-height: 200px;
    }

    .product_image img{
        max-height: 200px;
    }

    #search-results  {
        padding-left: 10px;
        padding-right: 10px;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        z-index: 200;
        background: #333;
        border: none;
        color: #ffff;
        font-family: Century Gothic;
    }

    /* .express-entry {
        max-width : 28.4vw;
        min-width : 28.4vw;
    } */

</style>

<div class="modal" id = "express_add_modal" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5)">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 100%;">
        <div class="modal-content" style = "width: 650px; margin: auto;">
            <div class="modal-body" style = "border: none" >
                <div class="express-add-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="color: var(--primary-color)">EXPRESS PRODUCT ENTRY</h5>
                        <button class="btn btn-secondary close-receive closeModalExpress"><i style="color: var(--primary-color)" class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="row w-100 justify-content-even align-items-center mt-2 ">

                        <div class="col-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                            </svg>
                        </div>

                        <div class="col-9" style="padding: 0px 8px; max-width: 25.5vw; min-width: 25.5vw">
                            <input autocomplete="off" style="border: 1px solid var(--border-color);" placeholder="SEARCH PRODUCT NAME / BARCODE" type="text" class=" express-entry w-100 ps-2">
                            <div id="search-results" style="outline: none;" tabindex="0"></div>
                        </div>
                        
                        <div class="col-1" style="padding: 0px 0px;">
                            <button class="btn btn-secondary express-search">SEARCH</button>
                        </div>
                        
                    </div>


                    <div class="express-details m-3">
                        <div class="row" style="max-height: 200px;">

                            <div class="col-12 empty-details">
                                <h4>SEARCH PRODUCT NAME / BARCODE</h4>
                            </div>

                            <!-- <div class="col-6 pe-2 product_detail_text">
                                <p class="express-label">Product Name: <span id="PRODUCT_NAME"></span></p> 
                                <p class="express-label">Barcode: <span id="BARCODE"></span></p> 
                                <p class="express-label">SKU: <span id="PRODUCT_SKU"></span></p>
                            </div>

                            <div class="col-6 ps-2 product_image">
                                <img src="./assets/products/1KL.png" alt="productImg">
                            </div> -->
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-secondary express-cancel me-2" style="width: 200px" >[ESC] CANCEL</button>
                        <button class="btn btn-secondary express-enter w-100">[ENTER] ADD TO PRODUCT LIST</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    let selectedProdIndex = 0;
    function highlightSelectedResult(result, selected_result) {
        var p_color = 'var(--primary-color)';
        result.removeClass(selected_result).css('background-color', '');
        if (selectedProdIndex >= 0 && selectedProdIndex < result.length) {
            result.eq(selectedProdIndex).addClass(selected_result).css('background-color', p_color);
        }
    }


    $(".express-entry").off("keydown").on("keydown", function (e) {
        if (e.which === 38) 
        { // Up arrow key
            e.preventDefault();
            selectedProdIndex = Math.max(selectedProdIndex - 1, 0);
            highlightSelectedResult($(".result-item"));
        }
        else if (e.which === 40) 
        { // Down arrow key
            e.preventDefault();
            selectedProdIndex = Math.min(selectedProdIndex + 1, $(".result-item").length - 1);
            highlightSelectedResult($(".result-item"));
        }

        else if (e.which === 13 && ($('.express-entry').val() == '' || $('.express-entry').val() != '')) 
        { 
            console.log($("#search-results").is(':visible'));
            if (!$("#search-results").is(':visible') && $('.express-entry').val() != '') 
            {
                console.log('Hello World');

                // var searchInputVal = $('.express-entry');
                // $('#searchValNotFound').text(searchInputVal.val())
                // searchInputVal.val('').blur();
                // $('#productNotFoundModal').show().focus();
                
                // $('#productNotFoundModal').off('keydown').on('keydown', function(e) {
                //     if(e.which == 13) {
                //     $('.continueTOClose').click();
                //     }
                // })

                // $('.continueTOClose').off('click').on('click', function() {
                //     $('#productNotFoundModal').hide();
                //     searchInputVal.focus();
                // })
                $("#search-results").hide();
                return;
            }
        }
    })


    function showResults(result) {
        var resultsContainer = $("#search-results");
        resultsContainer.empty();

        $.each(result, function(index, data) {
            var resultItem = $("<div class='result-item' data-allresult='" + data + "'>" + data.prod_desc +
            " <span class='product_price' style='float: right'> &#8369;" +
            parseFloat(data.prod_price).toFixed(2) +
            "</span></div>");


            resultItem.on("mouseover", function () {
                selectedProdIndex = index;
                highlightSelectedResult($(".result-item"))
            });

            resultItem.on("mouseout", function () {
                selectedProdIndex = -1;
                highlightSelectedResult($(".result-item"))
            });

            resultsContainer.append(resultItem);  
        })

        resultsContainer.show();
    }

    var products_coypy = [];
    axios.get('api.php?action=getCopyOfProduct')
    .then(function (response) {
        products_coypy = response.data.map(function (product) {
            return (product);
        });
    })
    .catch(function(error) {
        console.log(error);
    })

    $('.express-cancel, .closeModalExpress').click(function() {
        $('#express_add_modal').hide();
    })


    $(".express-entry").on("input", function () {
        var searchTerm = $(this).val().toLowerCase();
        if (searchTerm === '') {
            $("#search-results").hide();
            return;
        }

    selectedProdIndex = 0;
    var filteredResults = products_coypy.filter(function(product) {
      var regexPattern = searchTerm
          .replace(/_/g, '.') 
          .replace(/%/g, '.*'); 
      var regex = new RegExp('^' + regexPattern, 'i'); 
      for (var prop in product) {
        if (product.hasOwnProperty(prop) && typeof product[prop] === 'string' && (product[prop].toLowerCase().includes(searchTerm) || regex.test(product[prop]))) {
          return true;
        }
      }
      return false;
    }).slice(0, 10);
    showResults(filteredResults);
  });
    
</script>
