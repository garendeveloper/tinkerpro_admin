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
  border-radius: none;
  border-color: #33557F;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: var(--primary-color); 
    color: #fefefe !important; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    
}
.table-border{
    border-collapse: collapse;
    border: 1px solid white;
}

.table-border th, td {
  border: 1px solid white;
  padding: 8px;
}
.table-border th{
  background-color: none;
}


.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 600px;

   
}

.table-responsive table {
    width: 100px;
    border-collapse: collapse;
}
.card {
  background-color: #151515;
  border-color: #242424;
  height: 200px;
overflow: hidden;
  border-radius: 8px;
  padding: 16px;
}


.deleteBtn {
  background: transparent;
  border-radius: 0;
}

button.btn.btn-secondary.deleteBtn.deleteProductItem {
  border: 1px solid var(--border-color);

}

  .highlighteds{
     border: 2px solid #00B050 !important; 
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
  color: var(--primary-color);
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
    padding: 5px 10px;
    margin: 2px;
    border: 1px solid #ddd;
    color: #000;
}
.paginationTag:hover {
    background-color: #f0f0f0;
}
.paginationTag.active {
    background-color: #00B050;
    color: white;
    outline: none;
}

#responsive-data {
  overflow-x: hidden;
  max-height: 78vh;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
}


#responsive-data{
    width: 100%;
  }
    #responsive-data thead {
        display: table; 
        width: calc(100% - 4px);
    }

    #responsive-data tbody {
        display: block; 
        max-height: 72vh; 
        overflow-y: scroll;
    }

    #responsive-data th, td {
        width: auto;
        overflow-wrap: break-word; 
        box-sizing: border-box;
    }
    #responsive-data tr {
        display: table;
        width: 100%;
    }
    #responsive-data, table, thead, tbody{
      border: 1px solid #292928;
    }
    #responsive-data table{
        background-color: #1e1e1e;
        border: 1px solid #262626;
        height: 5px;
        padding: 10px 10px;
    }
  @media (max-width: 1200px) {
      #responsive-data th, #responsive-data td {
          width: 9%; 
      }
  }

  @media (max-width: 992px) {
      #responsive-data th, #responsive-data td {
          width: 8%; 
      }
  }

  @media (max-width: 768px) {
      #responsive-data th, #responsive-data td {
          width: 7%;
      }
  }

  @media (max-width: 768px) {
      #responsive-data {
          display: block;
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
      }
  }
#responsive-data tbody::-webkit-scrollbar {
    width: 4px; 
}
#responsive-data tbody::-webkit-scrollbar-track {
    background: #151515;
}
#responsive-data tbody::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 50px; 
}





.productHeader tr th {
  background: none;

 }


 .productBTNs  {
  border: 1px solid transparent; 
  width: 3vw; 
  border-radius: 0;
  height: 35px;
 }


/* #responsive-data {
  max-height: 700px;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
 
}

#responsive-data thead {
  display: block;
}

#responsive-data tbody {
  display: block;
  max-height: 600px;
  overflow-y: auto; 
  max-width: fit-content;
}
 */
.font-size{
  font-size: 12px !important;
}

    /*
.main-panel {
     -webkit-user-select: none; 
    -moz-user-select: none;   
    -ms-user-select: none;  
    user-select: none;  
}  */


.search_design {
 width: 100%; 
 height: 35px; 
 font-style: italic; 
 border-top-left-radius: 100px;
 border-bottom-left-radius: 100px;
 margin-right: 0;
}

.searchIconD {
  background: #7C7C7C;

}


.addProducts {

  background: #7C7C7C;
  border-top-right-radius : 100px;
  border-bottom-right-radius : 100px;
}
 .addProducts.productBTNs {
  width: 1550px;
}






</style>