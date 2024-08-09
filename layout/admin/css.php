<style>


:root {
    --primary-color: #ff6700;
    --secondary-color: #262626;
    --accent-color: #e74c3c;
    --text-color: #fff;
    --background-color: #333333;
    --font-family: Century Gothic, sans-serif;
    --border-color: #4B413E;
}

  #topBar{
  background-color:#262626
}
body{
    font-family: Century Gothic;
    font-size: 16px;
    font-weight: 400; /* Regular weight */
    line-height: 1.5;
}
.content-wrapper{
  position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #262626;
    padding: 12px; /* Optional: Add padding to the container */
    box-sizing: border-box; /* Ensure padding is included in the width */
}
.container-scroller{
    height: 100%;
}
  .searchProducts{
    background-color: #7C7C7C;
  }
  .text-color::placeholder {
  color: #ffff;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: 10px;
  border-color: #33557F;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: #FF6900; 
    color: #fff; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    width: 100%;
    border: collapse;
    
}
#paginationDropdown{
  background-color: #262626; 
  font-size: 13px;
  border-color: #FF6900;
}
select option {
    background-color: #262626; 
    color: white; 
}

select option:hover {
  background-color: #FF6900; 
  color: white; 
}
#d_welcome{
    color: #FF6900;
}
.table-border{
    border-collapse: collapse;
    width: 100%;
    border: 1px solid white;
}
td, th {
    border: 1px solid white;
    padding: 8px; 
}
.table{
  border-collapse: collapse; 
}
.table-border th, td {
  border: 1px solid white;
  padding: 8px;
}
.table-border th{
  background-color: #FF6900;
}
.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 700px;
    width: 200%; 
   
}

.table-responsive table {
    width: 100%;
    border-collapse: collapse;
}
.inventoryCard
{
    width: 550px;
    max-width: 100%; 
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #262626;
    color: #fff;
    border-color: #242424;
  }
  @keyframes slideOutRightss {
    from {
      transform: translateX(0);
    }
    to {
      transform: translateX(100%);
    }
  }
  .slideOutRight {
    animation: slideOutRightss 0.5s forwards;
  }
  footer {
    background-color: #1e1e1e; /* Change the background color as needed */
    padding: 20px; /* Adjust the padding as needed */
  }

  .footer-content {
    max-width: calc(100% - 240px); /* Adjust the maximum width of the footer content to fit the main content area beside the sidebar */
    margin-left: 190px; /* Adjust the left margin to push the footer content to the right of the sidebar */
  }

  .btn-control {
    width: 160px; /* Adjust the button width as needed */
    height: 45px; /* Adjust the button height as needed */
    margin-right: 10px; /* Adjust the margin between buttons as needed */
  }
  .btn-control:hover{
    border-color: var(--primary-color); 
    color: #fff; 
  }
  /* .btn-control:hover, button:hover {
    background-color: var(--primary-color); 
    color: #ffff; 
  } */
  /*
  /* button{
    border-color:  #FF6900;
  } */
button:active {
  background-color: #FF6900; 
  color: #ffffff;
 
}
button:hover {
    background-color: var(--primary-color); 
    color: #ffff; 
}
.active {
  background-color: #FF6900; 
  color: #ffffff;
  border-color: 1px solid #ffffff;
}
.button-cancel:hover{
  background-color: red;
}

.main-panel {
    position: relative;
    top: 0px;
    left: 190px; 
    right: 0;
    bottom: 0;
    overflow: auto;
    height: 60vh;
    background-color: #262626;
    width: calc(100% - 190px); 
    display: flex;
    flex-wrap: wrap;
  }

  @media (max-width: 100%) {
      .sidebar {
          width: 100px;
      }
      .main-panel {
          margin-left: 100px;
          width: calc(100% - 190px);
      }
  }

.icon-button {
    display: inline-flex; /* Use flexbox */
    align-items: center; /* Align items vertically */
    justify-content: center; /* Align items horizontally */
    color: #fff; /* Button text color */
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    height: 35px;
    margin-right: 5px; 
}

.search-icon {
    width: 20px; /* Icon width */
    height: 20px; /* Icon height */
    background-image: url('assets/img/search-icon.ico'); /* Path to your icon image */
    background-size: cover;
    margin-right: 10px; /* Spacing between icon and text */
}
.plus-icon {
    width: 20px; /* Icon width */
    height: 20px; /* Icon height */
    background-image: url('assets/img/plus-icon.ico'); /* Path to your icon image */
    background-size: cover;
    margin-right: 10px; /* Spacing between icon and text */
}
.has-error{
  border: 1px solid red;
}
/* .tbl_buttonsContainer {
    display: flex; 
  }
  .division {
      flex-grow: 1; 
      margin: 0 10px;
  } */
  .purchase-grid-container {
      display: grid;
      grid-template-columns: repeat(3, auto); 
      gap: 10px; 
      padding: 10px;
      margin-top: -20px;
      margin-bottom: 5px;
  }
  .purchase-grid-item{
    height: 35px;
    border-radius: 10px;
    border: 1px solid #595959;
  }
  .grid-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between; 
  }

  .grid-item {
      text-align: center;
      padding: 10px;
      border-color: #33557F !important;
      border-radius: 5px;
      color: #ffffff;
      font-size: 14px;
      margin-bottom: 10px; 
      flex-basis: calc(16.66% - 20px); 
  }
  @media only screen and (max-width: 600px) {
      .grid-item {
          font-size: 12px; 
          flex-basis: calc(50% - 20px); 
      }
  }
  .switch-error {
      border: 2px solid red;
      border-radius: 10px;
      padding: 8px;
  }
  .badge-success{
    color: #90EE90;
  }
  .badge-danger{
    color: #FFB6C1;
  }
  .ui-datepicker-prev, .ui-datepicker-next {
    position: absolute;
    top: 2px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    background-color: #f8f9fa;
    border: none;
    border-radius: 3px;
  }
  .ui-datepicker-prev::before, .ui-datepicker-next::before {
      font-family: "Bootstrap Icons";
      font-size: 1.2rem;
      color: black;
    }
  .ui-datepicker-prev {
    left: 2px;
  }
  .ui-datepicker-next {
    right: 2px;
  }
  table thead tr th{
        background-color: transparent;
        color: white;
        border-color: 1px solid #ccc;
    }
</style>
<style>
    .swal2-popup {
      padding: 0.2rem; 
    }
    .swal2-title {
      font-size: 0.5rem; 
    }
    .main{
      display: grid;
      grid-template-areas: 
        "head head head"
        "side content content"
        "foot foot foot";
      grid-template-columns: 10px auto 10px;
    }
    header{  grid-area: head; }
    .main-panel {grid-area: content; }
    .sidebar { grid-area: side;}
    footer { grid-area: foot;}
    .dataTables_filter {
            display: none; /* Hide the default search box */
        }
     
  .highlighteds{
    background: var(--primary-color);
  }
  .highlighteds:hover{
    background: var(--primary-color) !important;
  }
  .highlightedss {
      background: var(--primary-color);
  }
  .highlightedss:hover {
      background: var(--primary-color) !important;
  }
  .table-row:hover {
    background: #292928;
  }
  .highlighted-row{
    background-color: var(--primary-color);
  }
  .highlighted-row:hover {
      background-color: var(--primary-color) !important;
  }
.card {
  background-color: #1e1e1e;
  border-color: #242424;
  height: 200px;
  /* overflow-x: auto; 
  overflow-y: auto; */
  border-radius: 8px;
  padding: 16px;
}

.icon-container {
  display: flex;
  align-items: center; 
  justify-content: center; 
}
.icon-button{

  display: flex;
  align-items: center; 
  justify-content: center; 
  gap: -50px;
}
.icon-button:hover{
  color: var(--primary-color);

}
.text-right{
  text-align: right;  
}
.icon-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    padding: 1px 1px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    height: 35px;
    margin-right: 5px;
}
.badge-danger{
  color: red;
}
.bi-trash:hover{
  color: red;
}
.badge-success{
  color: lightgreen;
}
.pos-setting:hover {
    background-color: var(--hover-bg-color);
}
.pos-setting.active{
  background-color: var(--active-bg-color);
}
.purchase-grid-item.active{
  background-color: var(--active-bg-color);
}
.purchase-grid-item:hover{
  background-color: var(--hover-bg-color);
}
button.active{
  background-color: var(--active-bg-color);
}
button:hover{
  background-color: var(--hover-bg-color);
}




.paginactionClass{
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }


  .paginationTag {
    text-decoration: none; 
    border: 1px solid #fefefe;
    margin-right: 1px; 
    width: 40px;
    height: 40px;
    display: inline-flex; 
    justify-content: center;
    align-items: center; 
    background-color: #888888;
    color: #fefefe;
  }

  .paginationTag:hover{
    color: #FF6900;
  }


  .clear-button {
    height: 35px;
    width: 35px; 
    cursor: pointer;
    color: var(--primary-color);
    font-size: 25px;
    background: #7C7C7C;
  }



  .searchAdd {
    height: 35px; 
    border: 1px solid transparent; 
    box-shadow: none; 
    background: #7C7C7C; 
  }

  .searchInputs {
    height: 35px; 
    border-radius: 20px 0 0 20px;
    font-style: italic;
  }


.scrollable::-webkit-scrollbar {
    width: 4px; 
}
.scrollable::-webkit-scrollbar-track {
    background: #1e1e1e;
}
.scrollable::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 20px; 
}
.close-button{
  background-color: var(--primary-color);
}
.container-scroller{
  background-color: #262626;
}

.ui-datepicker {
    background: #262626;
    border: 1px solid #292928;
}

.ui-datepicker-header {
    background: #333;
    color: #fff;
}

.ui-datepicker-calendar .ui-state-default {
    background: #262626;
    color: #fff;
}

.ui-datepicker-calendar .ui-state-active {
    background: #555;
    color: #fff;
}

.ui-datepicker-calendar .ui-state-hover {
    background: var(--primary-color);
    color: #fff;
}

/* Change the background color of navigation buttons */
.ui-datepicker-prev, .ui-datepicker-next {
    background: #333;
    color: #fff;
}

.ui-datepicker-calendar thead  tr th{
    background-color: #262626 !important;
}
.ui-datepicker-calendar tbody td{
  border: 1px solid #292928;
}
.ui-datepicker-calendar thead th {
    color: #fff;
}


/* 
.progress-text {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      height: 30px;
      line-height: 30px;
      text-align: center;
      color: #333;
  } */

.adminTableHead{
  border: 1px solid var(--primary-color) !important; 
  padding: 8px 8px; 
  line-height: 0.5
}

/* .ui-tooltip {
      background: var(--primary-color) !important;
      color: white;
      border: 1px solid var(--primary-color) !important;
      width: 200px;
      font-size: 12px;
      font-family: Century Gothic;
  } */

.ui-tooltip {
  background: var(--primary-color) !important;
  color: white;
  font-weight: bold;
  border: 1px solid var(--primary-color);
  width: 200px;
  font-size: 12px;
  font-family: Century Gothic;
  position: relative;
}
.ui-tooltip::after {
    content: "";
    position: absolute;
    bottom: 100%; 
    left: 90%;
    margin-left: -5px; 
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent var(--primary-color) transparent; 
}


.deleteIcon:hover{
  color: red !important;
}
.normalIcon:hover{
  color: var(--primary-color) !important;
}
</style>
