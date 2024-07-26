<style>
  #period_reports .modal-dialog {
    max-width: 100%;
    min-width: 50%;
    left: 0;
    top: 0;
    width: 100%;
    overflow: hidden;
  }

  @media (max-width: 1000px) {
    #period_reports .modal-dialog {
      max-width: 90vw;
    }
  }


  #period_reports .modal-content {
    /* color: #ffff;
    background: #262625;
    border-radius: 0;
    height: fit-content;
    position: relative;
    width: fit-content; */
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

  #period_reports .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    width: 40px;
    height: 40px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
    margin-top: 1vh;
  }

  #period_reports .modal-title {
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    display: flex;
    align-items: center;
  }

  #period_reports .warning-container {
    display: flex;
    align-items: center;
  }

  #period_reports .warning-container svg {
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


  .warning-title {
    font-family: Century Gothic;
    font-size: large;
  }

  .custom_btns {
    border-color: #333333 !important;
    width: 150px;
    height: 45px;

  }

  .btnsContainer {
    width: 100%;
    display: flex;
    align-items: right;
    justify-content: right;
    margin-bottom: 20px;
    margin-top: 10px;
    padding-right: 2em;
  }

  .twoCard,
  .thirdCard {
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
    border-color: #333333 !important;
  }

  .flatpickr-calendar .flatpickr-day,
  .flatpickr-calendar .flatpickr-month,
  .flatpickr-calendar .numInputWrapper,
  .flatpickr-calendar .flatpickr-weekday,
  .flatpickr-calendar .flatpickr-prev-month,
  .flatpickr-calendar .flatpickr-next-month {
    color: white !important;
  }

  .flatpickr-prev-month svg,
  .flatpickr-next-month svg {
    fill: white !important;
  }

  .flatpickr-prev-month svg,
  .flatpickr-next-month svg,
  .flatpickr-prev-year svg,
  .flatpickr-next-year svg,
  .flatpickr-prev-decade svg,
  .flatpickr-next-decade svg {
    fill: white !important;
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

  .date_range_period {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<div class="modal period_reports" id="period_reports" tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="datePickerClose" name="datePickerClose" class="close-button"
        style="font-size: larger;">&times;</button>
      <div class="modal-title">
        <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5"
            id="Warning">
            <defs>
              <clipPath id="a">
                <path d="M0 38h38V0H0v38Z" fill="#000000" class="color000000 svgShape"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)" fill="#000000"
              class="color000000 svgShape">
              <path fill="#b50604"
                d="M0 0c-1.842 0-2.654 1.338-1.806 2.973l15.609 30.055c.848 1.635 2.238 1.635 3.087 0L32.499 2.973C33.349 1.338 32.536 0 30.693 0H0Z"
                transform="translate(3.653 2)" class="colorffcc4d svgShape"></path>
              <path fill="#131212"
                d="M0 0c0 1.302.961 2.108 2.232 2.108 1.241 0 2.233-.837 2.233-2.108v-11.938c0-1.271-.992-2.108-2.233-2.108-1.271 0-2.232.807-2.232 2.108V0Zm-.187-18.293a2.422 2.422 0 0 0 2.419 2.418 2.422 2.422 0 0 0 2.419-2.418 2.422 2.422 0 0 0-2.419-2.419 2.422 2.422 0 0 0-2.419 2.419"
                transform="translate(16.769 26.34)" class="color231f20 svgShape"></path>
            </g>
          </svg>
          <p class="warning-title"><b>SELECT DATES</b></p>&nbsp;
        </div>
        <div class="date_range_period">
          <span id = "date_selected" style = "font-family: Century Gothic; "></span>
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
          <div style="text-align: center;margin-bottom: 30px">Predefined Period</div>
          <div style="display: flex; text-align: center; justify-content: center; margin-bottom: 20px ">
            <button class="custom_btns" style="margin-right: 10px">Today</button>
            <button class="custom_btns">Yesterday</button>
          </div>
          <div style="display: flex; text-align: center; justify-content: center;margin-bottom: 20px ">
            <button class="custom_btns" style="margin-right: 10px">This week</button>
            <button class="custom_btns">Last week</button>
          </div>
          <div style="display: flex; text-align: center; justify-content: center;margin-bottom: 20px ">
            <button class="custom_btns" style="margin-right: 10px">This month</button>
            <button class="custom_btns">Last Month</button>
          </div>
          <div style="display: flex; text-align: center; justify-content: center; ">
            <button class="custom_btns" style="margin-right: 10px">This year</button>
            <button class="custom_btns">Last Year</button>
          </div>
        </div>
      </div>
      <div class="btnsContainer">
        <button id="cancelDateTime" class="custom_btns" style="margin-right:10px">Cancel</button>
        <button class="custom_btns" id = "btn_datePeriodSelected">Ok</button>
      </div>
    </div>
  </div>
</div>

<script>
    function formatDate(date) 
    {
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
  }
  function setPredefinedPeriod(period) {
      const today = new Date();
      let startDate, endDate;

      switch (period) {
          case 'Today':
              startDate = endDate = today;
              break;
          case 'Yesterday':
              startDate = endDate = new Date(today.setDate(today.getDate() - 1));
              break;
          case 'This week':
              startDate = new Date(today.setDate(today.getDate() - today.getDay()));
              endDate = new Date(today.setDate(today.getDate() + (6 - today.getDay())));
              break;
          case 'Last week':
              startDate = new Date(today.setDate(today.getDate() - today.getDay() - 7));
              endDate = new Date(today.setDate(today.getDate() + 6));
              break;
          case 'This month':
              startDate = new Date(today.getFullYear(), today.getMonth(), 1);
              endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
              break;
          case 'Last Month':
              startDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
              endDate = new Date(today.getFullYear(), today.getMonth(), 0);
              break;
          case 'This year':
              startDate = new Date(today.getFullYear(), 0, 1);
              endDate = new Date(today.getFullYear(), 11, 31);
              break;
          case 'Last Year':
              startDate = new Date(today.getFullYear() - 1, 0, 1);
              endDate = new Date(today.getFullYear() - 1, 11, 31);
              break;
          default:
              return;
      }

      const instance1 = document.getElementById("datepickerDiv")._flatpickr;
      const instance2 = document.getElementById("datepickerDiv2")._flatpickr;
      instance1.setDate(startDate);
      instance2.setDate(endDate);

      document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
      $("#per_start_date").val(formatDate(startDate));
      $("#per_end_date").val(formatDate(endDate));
  }

  $('#datePickerClose').on('click', function () {
      $('#period_reports').hide();
  });

  $('#cancelDateTime').on('click', function () {
      $('#period_reports').hide();
  });

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


  $('.custom_btns').on('click', function () {
    var buttonText = $(this).text();
    setPredefinedPeriod(buttonText);  
  });
</script>