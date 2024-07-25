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
    /* color: #ffff;
    background: #262625;
    border-radius: 0;
    height: fit-content;
    position: relative;
    width:fit-content; */
    color: #fff; /* Changed from #ffff to #fff for correct hex color format */
    background: #262625;
    border-radius: 0;
    height: fit-content;
    position: absolute; /* Change position to absolute */
    top: 50%; /* Center vertically */
    left: 50%; /* Center horizontally */
    transform: translate(-50%, -50%); /* Centering trick */
    width: fit-content;
  }

  #dateTimeModal .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    width: 30px;
    height: 30px;
    line-height: 20px;
    text-align: center;
    cursor: pointer;
    margin-top: 1vh;
  }

  #dateTimeModal .modal-title {
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.2em;
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
    min-height: fit-content;
    max-height: fit-content;
    margin-left: 2em;
    margin-top: -0.5em;
    border: 1px solid #4B413E;
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
  padding: 10px;
  margin-top: -20px;
}

.oneCard {
  width: 33%;
  display: inline-block;
  padding: 10px;
  margin-top: -20px;
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
    background-color: var(--primary-color) !important;
}
.flatpickr-day.selected {
    background-color: var(--primary-color) !important;
    border-color:var(--primary-color) !important;
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
      <button id="datePickerClose"  name="datePickerClose" class="close-button" style="font-size: larger; background-color: var(--primary-color)">&times;</button>
      <div class="modal-title">
        <div class="warning-container" style = "margin-left: 30px;">
            <h4>SELECTED DATES</h4>&nbsp;
            <p class="warning-title " style="color: var(--primary-color)"><b><span id="date_selected"></span></b></p>

        </div>
      </div>
      <div class="warningCard" style="display: flex; ">
        <div class="oneCard" style="width: 50%">
        <div style="text-align: center;margin-bottom: 10px">Start</div>
         <input type="text" hidden id="datepickerDiv" style="text-align: center;">
        </div>
        <div class="twoCard" style="width: 50%">
        <div style="text-align: center;margin-bottom: 10px">End</div>
        <input type="text" hidden id="datepickerDiv2" style="text-align: center;">
       </div>
      </div>
      <div class="btnsContainer">
        <button id="cancelDateTime" class="custom_btns" style="margin-right:10px">Cancel</button>
        <button class="custom_btns okBtnDates" id = "btn_datePeriodSelected">Ok</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#datePickerClose, #cancelDateTime').on('click', function () {
      $('#dateTimeModal').hide();
  });

  function formatDate(date) 
  {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${month}/${day}/${year}`;
  }
  flatpickr("#datepickerDiv", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function (selectedDates, dateStr, instance) {
        const datepickerDiv2 = document.getElementById("datepickerDiv2");
        const instance2 = datepickerDiv2._flatpickr;
        instance2.set("minDate", selectedDates[0]);

        const startDate = selectedDates[0];
        const endDate = instance2.selectedDates[0] || startDate;
        document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }
});

flatpickr("#datepickerDiv2", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function (selectedDates, dateStr, instance) {
        const datepickerDiv = document.getElementById("datepickerDiv");
        const instance1 = datepickerDiv._flatpickr;
        instance1.set("maxDate", selectedDates[0]);

        const endDate = selectedDates[0];
        const startDate = instance1.selectedDates[0] || endDate;
        document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }
});
</script>