<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }

    .group {
        display: inline-block;
        margin-right: 3px;
    }

    strong {
        color: #FF6900;
    }

    #tbl_expirationItems {
        margin-left: 10px;
    }

    #tbl_expirationItems thead {
        color: #ffff;
        border-collapse: collapse;
        border: 1px solid #FF6900;
    }

    #tbl_expirationItems tbody td,
    thead th {
        border: 1px solid #ffff;
        font-size: 12px;
        height: 8px;
    }

    #tbl_expirationItems tbody {
        border: none;
        border-collapse: collapse;
        border: 1px solid #ffff;
    }

    .italic-placeholder::placeholder {
        font-style: italic;
    }

    .custom-checkbox {
        width: 12px;
        height: 15px;
        border: 2px solid #ffff;
        cursor: pointer;
        text-align: center;
        display: inline-block;
    }

    .checked {
        background-color: #FF6900;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28A745;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #28A745;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .slider.round:before {
        height: 16px;
        width: 16px;
    }

    #tbl_expirationItems {
        height: 3px;
    }

    #tbl_expirationItems td:nth-child(1) {
        width: 5px;
        height: 8px;
    }

    #tbl_expirationItems td:nth-child(2) {
        width: 100px;
        height: 8px;
    }

    #tbl_expirationItems td:nth-child(3) {
        display: flex;
        align-items: center;
        justify-content: center
    }
</style>
<div class="fcontainer" id="expiration_div" style="display: none;">
    <form id="expiration_form">
        <div>
            <div class="fieldContainer">
                <div class="group">
                    <label for=""><strong style="color: #ffff;">EXPIRATION NOTIFICATION</strong></label>
                    <label class="switch">
                        <input type="checkbox" name="expiration_notification" id="expiration_notification" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <table id="tbl_expirationItems" class="text-color ">
                <thead>
                    <tr>
                        <th style="background-color: #1E1C11;">DESCRIPTION</th>
                        <th style="background-color: #1E1C11;">NOTIFY BEFORE</th>
                        <th style="background-color: #1E1C11; width: 5px;">STATUS</th>
                    </tr>
                </thead>
                <tbody style="border-collapse: collapse; ">
                    <tr>
                        <td>1<sup>st</sup> Notification</td>
                        <td>30 DAYS</td>
                        <td class="center-switch">
                            <label class="switch">
                                <input type="checkbox" name="first_expiration" id="first_expiration" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>2<sup>nd</sup> Notification</td>
                        <td>15 DAYS</td>
                        <td class="center-switch">
                            <label class="switch">
                                <input type="checkbox" name="second_expiration" id="second_expiration" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>3<sup>rd</sup> Notification</td>
                        <td>5 DAYS</td>
                        <td class="center-switch">
                            <label class="switch">
                                <input type="checkbox" name="third_expiration" id="third_expiration" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>4<sup>th</sup> Notification</td>
                        <td>0 DAYS</td>
                        <td class="center-switch">
                            <label class="switch">
                                <input type="checkbox" name="fourth_expiration" id="fourth_expiration" checked>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        show_expiration();
        $("#expiration_notification").on("change", function () {
            var is_all_checked = $(this).prop("checked");
            if (is_all_checked) {
                $("#tbl_expirationItems tbody").find("input[type=checkbox]").prop("checked", true);
            }
            else {
                $("#tbl_expirationItems tbody").find("input[type=checkbox]").prop("checked", false);
            }
        })
        function show_expiration()
        {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_expirationNotification',
                success: function(data){
                    $("#tbl_expirationItems tbody").find("input[type=checkbox]").prop("checked", false);
                    for(var i = 0; i<data.length; i++)
                    {
                        switch(data[i].notify_before)
                        {
                            case 30:
                                if(data[i].is_active === 1)
                                {
                                    $("#first_expiration").prop("checked", true);
                                }
                                break;
                            case 15:
                                if(data[i].is_active === 1)
                                {
                                    $("#second_expiration").prop("checked", true);
                                }
                                break;
                            case 5:
                                if(data[i].is_active === 1)
                                {
                                    $("#third_expiration").prop("checked", true);
                                }
                                break;
                            case 0:
                                if(data[i].is_active === 1)
                                {
                                    $("#fourth_expiration").prop("checked", true);
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            })
        }
    })
</script>