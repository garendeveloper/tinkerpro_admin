<style>
.period_reports {
    display: flex; 
    justify-content: center; 
    align-items: center; 
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.4);
}

.period_reports_content{
    background-color: #1E1C11;
    color: #fff;
    margin: auto;
    height: 300px;
    padding: 20px;
    border: 1px solid #fff;
    width: 100%;
}
#r_message{
    color: #FF6900;
}
.close {
    color: #fff;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #FF6900;
    text-decoration: none;
    cursor: pointer;
}
h3{
    color: #ffff;
}
/* .predefined-periods {
    display: grid;
    grid-template-columns: repeat(2, 2fr); 
    gap: 10px;
    padding: 20px;
    margin: center;
    text-align:center;
   
}
.predefined-periods button {
    padding: 3px 3px;
    border: 1px solid #ffff;
    background-color: transparent;
    color: #fff;
    width: 180px;
    cursor: pointer;
} */
.predefined-periods {
    display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 10px;
    margin-top: 1px;
    text-align:center;
}

.predefined-periods button {
    padding: 3px 3px;
    border: 1px solid #ffff;
    background-color: transparent;
    color: #fff;
    width: 180px;
    cursor: pointer;
}

.predefined-periods button:hover {
    background-color: #FF6900;
}
</style>
<div id="period_reports" class="period_reports" style="display: none;">
    <div class="period_reports_content ">
        <h3 style=" text-align: center;">Period</h3>
        <div class="predefined-periods" style="margin-top: 1px;display: flex; justify-content: flex-end ">
            <button id="last_month">Last Month</button>
            <button id="this_year">This Year</button>
            <button id="last_year">Last Year</button>
            <button id="today">Today</button>
            <button id="yesterday">Yesterday</button>
            <button id="this_week">This Week</button>
            <button id="last_week">Last Week</button>
            <button id="this_month">This Month</button>
        </div>
        <div id="dateRangePicker" class="datepicker" style="z-index: 9999; text-align:center; margin-top: 10px;" style = "top: 0">
            <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style = "width: 200px; border: 1px solid #ffff"/>
        </div>
    </div>
</div>



<script>
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'center'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});
</script>