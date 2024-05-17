<style>
  #topBar{
  background-color:#262626
}
body{
  font-family: 'Calibri', sans-serif;
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
    background-color: #151515; /* Change the background color as needed */
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
    border-color: #FF6700; 
    color: #fff; 
  }
  /* .btn-control:hover, button:hover {
    background-color: #FF6700; 
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
    background-color: #FF6700; 
    color: #ffff; 
}
.active {
  background-color: #FF6900; 
  color: #ffffff;
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


/* .fContainer_bottom {
    position: absolute;
    bottom: 0;
    width: 100%;
    margin-right: 10px;
} */
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
.tbl_buttonsContainer {
    display: flex; 
  }
  .division {
      flex-grow: 1; 
      margin: 0 10px;
  }
  .grid-container {
      display: grid;
      grid-template-columns: repeat(3, auto); 
      gap: 10px; 
  }
  .grid-item{
    height: 35px;
    border-radius: 10px;
    border: 1px solid #595959;
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
        background-color: #FF6900;
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
  </style>