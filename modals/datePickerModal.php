<style>
 #dateTimeModal .modal-dialog {
  max-width: 1200px; 
  min-width: 500px; 
}

@media (max-width: 1000px) {
  #dateTimeModal .modal-dialog {
    max-width: 90vw; 
  }
}


  #dateTimeModal .modal-content {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    height: fit-content;
    position: relative;
  }

  #dateTimeModal .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: #FF6900;
    color: #fff;
    border: none;
    width: 40px;
    height: 40px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
    margin-top: 1vh;
  }

  #dateTimeModal .modal-title {
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    display: flex;
    align-items: center;
  }

  #dateTimeModal .warning-container {
    display: flex;
    align-items: center;
  }

  #dateTimeModal .warning-container svg {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1em;
    margin-top: -0.5em;
  }

   .warningCard {
    min-width: fit-content;
    min-height: 420px;
    max-height: 420px;
    margin-left: 2em;
    border: 2px solid #4B413E;
    border-radius: 0;
    padding: 1.5vw;
    box-sizing: border-box;
    background: #262625;
    margin-right: 2em;
    flex-shrink: 0;
    position: relative;
    display: flex;
  }

 
  .warning-title{
    font-family: Century Gothic;
    font-size: large;
  }
  .custom_btns{
    border-color: #333333 !important;
    width: 150px;
    height: 45px;

  }
  .btnsContainer{
    width: 100%;
    display: flex;
    align-items: right;
    justify-content: right;
    margin-bottom: 20px;
    margin-top: 10px;
    padding-right: 2em;
  }
 .twoCard, .thirdCard {
  width: 33%;
  padding: 20px;
}

.oneCard {
  width: 33%;
  display: inline-block;
  padding: 20px;
}


.flatpickr-calendar {
  width: 100%;
  position: absolute;
  z-index: 9999;
  margin: 0;
  padding: 0;
  font-size: 14px; 
  border-radius: 0 !important;
  background: transparent !important;
  border-color:  #333333 !important;
}
.flatpickr-calendar .flatpickr-day, .flatpickr-calendar .flatpickr-month, .flatpickr-calendar .numInputWrapper, .flatpickr-calendar .flatpickr-weekday, .flatpickr-calendar .flatpickr-prev-month, .flatpickr-calendar .flatpickr-next-month {
    color: white !important;
}
.flatpickr-prev-month svg, .flatpickr-next-month svg {
    fill: white !important;
}

.flatpickr-prev-month svg, .flatpickr-next-month svg,
.flatpickr-prev-year svg, .flatpickr-next-year svg,
.flatpickr-prev-decade svg, .flatpickr-next-decade svg {
    fill: white !important;
}

.flatpickr-day.selected:hover {
    background-color: #FF6900 !important;
}
.flatpickr-day.selected {
    background-color: #FF6900 !important;
    border-color:#FF6900 !important;
}
@media (max-width: 600px) {
  .flatpickr-calendar {
    font-size: 12px; 
  }
}

@media (max-width: 400px) {
  .flatpickr-calendar {
    font-size: 10px;
  }
}

.flatpickr-input {
  width: calc(100% - 20px); 
  padding: 10px;
  box-sizing: border-box;
}

.flatpickr-monthDropdown-months option,
.flatpickr-yearDropdown-years option {
  color: black !important;
}
.flatpickr-prev-year,
.flatpickr-next-year {
  color: white !important; 
}
</style>

<div class="modal" id="dateTimeModal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="datePickerClose"  name="datePickerClose" class="close-button" style="font-size: larger;">&times;</button>
      <div class="modal-title">
      <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5" id="Warning">
            <defs>
              <clipPath id="a">
                <path d="M0 38h38V0H0v38Z" fill="#000000" class="color000000 svgShape"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)" fill="#000000" class="color000000 svgShape">
              <path fill="#b50604" d="M0 0c-1.842 0-2.654 1.338-1.806 2.973l15.609 30.055c.848 1.635 2.238 1.635 3.087 0L32.499 2.973C33.349 1.338 32.536 0 30.693 0H0Z" transform="translate(3.653 2)" class="colorffcc4d svgShape"></path>
              <path fill="#131212" d="M0 0c0 1.302.961 2.108 2.232 2.108 1.241 0 2.233-.837 2.233-2.108v-11.938c0-1.271-.992-2.108-2.233-2.108-1.271 0-2.232.807-2.232 2.108V0Zm-.187-18.293a2.422 2.422 0 0 0 2.419 2.418 2.422 2.422 0 0 0 2.419-2.418 2.422 2.422 0 0 0-2.419-2.419 2.422 2.422 0 0 0-2.419 2.419" transform="translate(16.769 26.34)" class="color231f20 svgShape"></path>
            </g>
          </svg>
          <p class="warning-title"><b>SELECT DATES</b></p>&nbsp;
          <p hidden class="warning-title selectedDates" style="color:#FF6900"><b>[<span id="dateFrom"></span>-<span id="dateTo"></span></span>]</b></p>
          <p hidden class="warning-title selectedsDates" style="color:#FF6900"><b>[<span id="dateSlcted"></span>]</b></p>
        </div>
      </div>
      <div class="warningCard" style="display: flex;">
        <div class="oneCard" style="width: 33%">
        <div style="text-align: center;margin-bottom: 10px">Start</div>
         <input type="text" hidden id="datepickerDiv" style="text-align: center;">
        </div>
        <div class="twoCard" style="width: 33%">
        <div style="text-align: center;margin-bottom: 10px">End</div>
        <input type="text" hidden id="datepickerDiv2" style="text-align: center;">
       </div>
        <div class="thirdCard" style="width: 33%">
            <input hidden class="predefinedDates" id="predefinedDates"/>
            <input hidden class="predefinedDouble" id="predefinedDouble"/>
            <div style="text-align: center;margin-bottom: 30px">Predefined Period</div>
            <div style="display: flex; text-align: center; justify-content: center; margin-bottom: 20px ">
                <button class="custom_btns dateToday" style="margin-right: 10px">Today</button>
                <button class="custom_btns dateYesterday">Yesterday</button>
            </div>
            <div style="display: flex; text-align: center; justify-content: center;margin-bottom: 20px ">
                <button class="custom_btns dateThisWeek" style="margin-right: 10px">This week</button>
                <button class="custom_btns lastWeek">Last week</button>
            </div>
            <div style="display: flex; text-align: center; justify-content: center;margin-bottom: 20px ">
                <button class="custom_btns thisMonth" style="margin-right: 10px">This month</button>
                <button class="custom_btns lastMonth">Last Month</button>
            </div>
            <div style="display: flex; text-align: center; justify-content: center; ">
                <button class="custom_btns thisYear" style="margin-right: 10px">This year</button>
                <button class="custom_btns lastYear">Last Year</button>
            </div>
       </div>
    </div>
    <div class="btnsContainer">
     <button id="cancelDateTime" class="custom_btns" style="margin-right:10px">Cancel</button>
     <button class="custom_btns okBtnDates">Ok</button>
    </div>
    </div>
  </div>
</div>
<script>
$('.lastYear').on('click', function() {
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
 document.querySelector('.selectedsDates').setAttribute('hidden',true);
    var currentDate = new Date();
    var startOfYear = new Date(currentDate.getFullYear() - 1, 0, 1); 
    var endOfYear = new Date(currentDate.getFullYear(), 0, 0); 

    var startYear = startOfYear.getFullYear();
    var startMonth = String(startOfYear.getMonth() + 1).padStart(2, '0');
    var startDay = String(startOfYear.getDate()).padStart(2, '0');
    var endYear = endOfYear.getFullYear();
    var endMonth = String(endOfYear.getMonth() + 1).padStart(2, '0');
    var endDay = String(endOfYear.getDate()).padStart(2, '0');

    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
    const formattedDate = selectedDate.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateFrom').text(formattedDate);
const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateTo').text(formattedDate1);

    document.querySelector('.selectedDates').removeAttribute('hidden')
});

$('.thisYear').on('click', function() {
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
 document.querySelector('.selectedsDates').setAttribute('hidden',true);
    var currentDate = new Date();
    var startOfYear = new Date(currentDate.getFullYear(), 0, 1); 
    var endOfYear = new Date(currentDate.getFullYear() + 1, 0, 0); 

    var startYear = startOfYear.getFullYear();
    var startMonth = String(startOfYear.getMonth() + 1).padStart(2, '0');
    var startDay = String(startOfYear.getDate()).padStart(2, '0');
    var endYear = endOfYear.getFullYear();
    var endMonth = String(endOfYear.getMonth() + 1).padStart(2, '0');
    var endDay = String(endOfYear.getDate()).padStart(2, '0');

    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
    const formattedDate = selectedDate.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateFrom').text(formattedDate);
const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateTo').text(formattedDate1);

    document.querySelector('.selectedDates').removeAttribute('hidden')
});

$('.lastMonth').on('click', function() {
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
document.querySelector('.selectedsDates').setAttribute('hidden',true);
    var currentDate = new Date();
    var firstDayOfCurrentMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    var firstDayOfLastMonth = new Date(firstDayOfCurrentMonth);
    firstDayOfLastMonth.setMonth(firstDayOfLastMonth.getMonth() - 1);

    var lastDayOfLastMonth = new Date(firstDayOfCurrentMonth);
    lastDayOfLastMonth.setDate(0); 

    var startYear = firstDayOfLastMonth.getFullYear();
    var startMonth = String(firstDayOfLastMonth.getMonth() + 1).padStart(2, '0');
    var startDay = String(firstDayOfLastMonth.getDate()).padStart(2, '0');
    var endYear = lastDayOfLastMonth.getFullYear();
    var endMonth = String(lastDayOfLastMonth.getMonth() + 1).padStart(2, '0');
    var endDay = String(lastDayOfLastMonth.getDate()).padStart(2, '0');

    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
    const formattedDate = selectedDate.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateFrom').text(formattedDate);
const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateTo').text(formattedDate1);

    document.querySelector('.selectedDates').removeAttribute('hidden')

    
});

$('.thisMonth').on('click', function() {
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
document.querySelector('.selectedsDates').setAttribute('hidden',true);
    var currentDate = new Date(); 
    var startOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    var endOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

    var startYear = startOfMonth.getFullYear();
    var startMonth = String(startOfMonth.getMonth() + 1).padStart(2, '0');
    var startDay = String(startOfMonth.getDate()).padStart(2, '0');
    var endYear = endOfMonth.getFullYear();
    var endMonth = String(endOfMonth.getMonth() + 1).padStart(2, '0');
    var endDay = String(endOfMonth.getDate()).padStart(2, '0');

    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    
const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
    const formattedDate = selectedDate.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateFrom').text(formattedDate);
const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateTo').text(formattedDate1);

    document.querySelector('.selectedDates').removeAttribute('hidden')
});

$('.lastWeek').on('click', function(){
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
 document.querySelector('.selectedsDates').setAttribute('hidden',true);
    var currentDate = new Date(); 
    var currentDay = currentDate.getDay(); 
    var diff = currentDay - 1; 

    currentDate.setDate(currentDate.getDate() - diff);
    currentDate.setDate(currentDate.getDate() - 7); 

    var startDate = new Date(currentDate);
    var endDate = new Date(currentDate);
    endDate.setDate(endDate.getDate() + 6);

    var startYear = startDate.getFullYear();
    var startMonth = String(startDate.getMonth() + 1).padStart(2, '0');
    var startDay = String(startDate.getDate()).padStart(2, '0');
    var endYear = endDate.getFullYear();
    var endMonth = String(endDate.getMonth() + 1).padStart(2, '0');
    var endDay = String(endDate.getDate()).padStart(2, '0');

    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    document.querySelector('.selectedDates').removeAttribute('hidden')

const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
    const formattedDate = selectedDate.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateFrom').text(formattedDate);
const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit"
    });
    $('#dateTo').text(formattedDate1);
})
$('.dateThisWeek').on('click', function() {
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
  document.querySelector('.selectedsDates').setAttribute('hidden',true);

    var currentDate = new Date(); 
    var currentDay = currentDate.getDay(); 
    var diff = currentDay - 1; 

  
    currentDate.setDate(currentDate.getDate() - diff);
    var startDate = new Date(currentDate);
    var endDate = new Date(currentDate);
    endDate.setDate(endDate.getDate() + 6); 

  
    var startYear = startDate.getFullYear();
    var startMonth = String(startDate.getMonth() + 1).padStart(2, '0');
    var startDay = String(startDate.getDate()).padStart(2, '0');
    var endYear = endDate.getFullYear();
    var endMonth = String(endDate.getMonth() + 1).padStart(2, '0');
    var endDay = String(endDate.getDate()).padStart(2, '0');

 
    var dateRange = startYear + '-' + startMonth + '-' + startDay + ' - ' + endYear + '-' + endMonth + '-' + endDay;
    $('.predefinedDouble').val(dateRange);

    document.querySelector('.selectedDates').removeAttribute('hidden')

    const selectedDate = new Date(startYear + '-' + startMonth + '-' + startDay); 
        const formattedDate = selectedDate.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateFrom').text(formattedDate);
   const selectedDate1 = new Date(endYear + '-' + endMonth + '-' + endDay); 
    const formattedDate1 = selectedDate1.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateTo').text(formattedDate1);
    
});

$('.dateYesterday').on('click', function(){
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
  document.querySelector('.selectedDates').setAttribute('hidden', true)
  var yesterday = new Date(); 
   yesterday.setDate(yesterday.getDate() - 1); 
   var dd = String(yesterday.getDate()).padStart(2, '0'); 
   var mm = String(yesterday.getMonth() + 1).padStart(2, '0'); 
   var yyyy = yesterday.getFullYear(); 

   var yesterdayString = yyyy + '-' + mm + '-' + dd;
   $('.predefinedDates').val(yesterdayString);

   
   const selectedDate = new Date(yesterdayString); 
        const formattedDate = selectedDate.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateSlcted').text(formattedDate);
        document.querySelector('.selectedsDates').removeAttribute('hidden');
})

$('.dateToday').on('click', function(){
  document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
  document.querySelector('.selectedDates').setAttribute('hidden', true)
   var today = new Date(); 
   var dd = String(today.getDate()).padStart(2, '0'); 
   var mm = String(today.getMonth() + 1).padStart(2, '0'); 
   var yyyy = today.getFullYear();
   var dateString = yyyy + '-' + mm + '-' + dd;
   $('.predefinedDates').val(dateString);

   const selectedDate = new Date(dateString); 
        const formattedDate = selectedDate.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateSlcted').text(formattedDate);
        document.querySelector('.selectedsDates').removeAttribute('hidden');

});

 $('#datePickerClose').on('click', function(){
    $('#dateTimeModal').hide()
    clearFields()
 })
 $('#cancelDateTime').on('click', function(){
    // $('#dateTimeModal').hide()
    clearFields()
 })

 $('.okBtnDates').off('click').on('click', function() {
    var selectedDatePre = document.getElementById("predefinedDates").value;
    var predefinedDouble = document.getElementById("predefinedDouble").value;

    var dateFrom = document.getElementById("datepickerDiv").value;
    var dateTo = document.getElementById("datepickerDiv2").value;

    if (selectedDatePre !== "" || predefinedDouble !== "" || dateFrom !== "" || dateTo !== "") {
        if (selectedDatePre !== "" && predefinedDouble === "") {
            var date = new Date(selectedDatePre);
            const formattedDateSelected = date.toLocaleDateString("en-PH", {
                year: "numeric",
                month: "short",
                day: "2-digit"
            });
            document.getElementById('datepicker').value = formattedDateSelected;
        } else if (selectedDatePre === "" && predefinedDouble !== "") {
            var dates = predefinedDouble.split(" - ");
            var startDateString = dates[0];
            var endDateString = dates[1];

            var startDate = new Date(startDateString);
            var formattedStartDate = startDate.toLocaleDateString("en-PH", {
                year: "numeric",
                month: "short",
                day: "2-digit"
            });

            var endDate = new Date(endDateString);
            var formattedEndDate = endDate.toLocaleDateString("en-PH", {
                year: "numeric",
                month: "short",
                day: "2-digit"
            });

            var formattedDates = formattedStartDate + " - " + formattedEndDate;
            document.getElementById('datepicker').value = formattedDates;
        } else {
          var dateFrom = new Date(document.getElementById("datepickerDiv").value);
          var dateTo = new Date(document.getElementById("datepickerDiv2").value);
            const formattedDateFrom = dateFrom.toLocaleDateString("en-PH", {
                year: "numeric",
                month: "short",
                day: "2-digit"
            });
            const formattedDateTo = dateTo.toLocaleDateString("en-PH", {
                year: "numeric",
                month: "short",
                day: "2-digit"
            });

            var selectedDates = formattedDateFrom + " - " + formattedDateTo;
            document.getElementById('datepicker').value = selectedDates;
        }
    } else {
        document.getElementById('datepicker').value = "";
    }

    $('#dateTimeModal').hide();
    $('.predefinedDates').val("");
    $('.predefinedDouble').val("");
    clearFields();
});



 function clearFields(){
   document.querySelector('.selectedDates').setAttribute('hidden', true)
   document.querySelector('.selectedsDates').setAttribute('hidden',true);
   document.getElementById("datepickerDiv").value = "";
   document.getElementById("datepickerDiv2").value = "";
   document.querySelectorAll('.flatpickr-day.selected').forEach(day => {
    day.classList.remove('selected');
   
});
$('.predefinedDates').val("")
    $('.predefinedDouble').val("");
 }
 flatpickr("#datepickerDiv", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function(selectedDates, dateStr, instance) {
         const selectedDate = new Date(dateStr); 
        const formattedDate = selectedDate.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateFrom').text(formattedDate);
        document.querySelector('.selectedDates').removeAttribute('hidden');
        
        const datepickerDiv2 = document.getElementById("datepickerDiv2");
        const instance2 = datepickerDiv2._flatpickr;
        
        instance2.clear();
        
        const nextDay = new Date(selectedDate);
        nextDay.setDate(selectedDate.getDate());
        instance2.set("minDate", nextDay);
    }
});

flatpickr("#datepickerDiv2", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function(selectedDates, dateStr, instance) {
        document.querySelector('.selectedsDates').setAttribute('hidden',true);
        const datepickerDiv = document.getElementById("datepickerDiv");
        const datepickerDiv2 = document.getElementById("datepickerDiv2");
        const selectedDate1 = new Date(dateStr);

        if (datepickerDiv.value) {
        const formattedDate = selectedDate1.toLocaleDateString("en-PH", {
            year: "numeric",
            month: "short",
            day: "2-digit"
        });
        $('#dateTo').text(formattedDate);
            const selectedDateDiv = new Date(datepickerDiv.value);
            const selectedDateDiv2 = datepickerDiv2.value ? new Date(datepickerDiv2.value) : null;

            if (selectedDateDiv && selectedDateDiv2) {
                if (selectedDateDiv.getTime() <= selectedDateDiv2.getTime()) {
                    const nextDay = new Date(selectedDateDiv);
                    nextDay.setDate(selectedDateDiv.getDate());
                    instance.set("minDate", nextDay);
                } else {
                    instance.set("minDate", null);
                }
            }
        } else {
            instance.set("minDate", new Date(9999, 11, 21)); 
            datepickerDiv2.removeAttribute("disabled");
        }
    }
});


</script>