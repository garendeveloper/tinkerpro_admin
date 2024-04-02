<style>
  #topBar{
  background-color:#262626
}
.content-wrapper{
    background-color: #262626;
  
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
  margin-left: 240px; /* Adjust the left margin to push the footer content to the right of the sidebar */
}

.btn-control {
  width: 160px; /* Adjust the button width as needed */
  height: 45px; /* Adjust the button height as needed */
  margin-right: 10px; /* Adjust the margin between buttons as needed */
}
button:hover {
  background-color: #FF6900; /* Background color on hover */
  color: #ffffff; /* Text color on hover */
}
button{
  border-color:  #FF6900;
}
button:active {
  background-color: #FF6900; /* Background color when button is clicked */
  color: #ffffff; /* Text color when button is clicked */
}
/* .sidebar {
    min-height: calc(100vh - 60px);
    background: #1E1C11;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    padding: 0;
    width: 200px;
    color: white;
    z-index: 11;
    transition: width 0.25s ease, background 0.25s ease;
    -webkit-transition: width 0.25s ease, background 0.25s ease;
    -moz-transition: width 0.25s ease, background 0.25s ease;
    -ms-transition: width 0.25s ease, background 0.25s ease;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    border-right: 1px solid #e3e3e3;
}
.navbar .navbar-brand-wrapper {
    background: #1E1C11;
    border-bottom: 1px solid #e3e3e3;
    transition: width 0.25s ease, background 0.25s ease;
    -webkit-transition: width 0.25s ease, background 0.25s ease;
    -moz-transition: width 0.25s ease, background 0.25s ease;
    -ms-transition: width 0.25s ease, background 0.25s ease;
    width: 200px;
    height: 60px;
    border-right: 1px solid #e3e3e3;
} */



</style>