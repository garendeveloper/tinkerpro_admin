<style>
  #topBar{
  background-color:#262626
}
.content-wrapper{
  position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #262626;
    padding: 20px; /* Optional: Add padding to the container */
    box-sizing: border-box; /* Ensure padding is included in the width */
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
    color: #FF6900; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    width: 100%;
    border: collapse;
    
}
#d_welcome{
    color: #FF6900;
}
.table-border{
    border-collapse: collapse;
    width: 100%;
    border: 1px solid white;
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
.card
{
    width: 550px; /* Set the fixed width of the card */
    max-width: 100%; /* Ensure the card can't exceed the width of its container */
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color:#151515;
    border-color: #242424;
  }
  @keyframes slideOutRight {
    from {
      transform: translateX(0);
    }
    to {
      transform: translateX(100%);
    }
  }
  .slideOutRight {
    animation: slideOutRight 0.5s forwards;
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
  .btn-control:hover, button:hover {
    background-color: #FF6700; 
    color: #ffff; 
  }
  button{
    border-color:  #FF6900;
  }
button:active {
  background-color: #FF6900; /* Background color when button is clicked */
  color: #ffffff; /* Text color when button is clicked */
}
.active {
  background-color: #FF6900; /* Background color when button is clicked */
  color: #ffffff; /* Text color when button is clicked */
}
.main-panel {
    position: absolute;
    top: 30px;
    left: 190px; 
    right: 0;
    bottom: 0;
    overflow-y: auto; 
    width: calc(100% - 190px); */
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


</style>