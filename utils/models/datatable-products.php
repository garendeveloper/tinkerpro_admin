<?php
    class DatatableProductFacade extends DBConnection
    {
        public function get_datatableProducts()
        {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; 
            $columnIndex = $_POST['order'][0]['column']; 
            $columnName = $_POST['columns'][$columnIndex]['data']; 
            $columnSortOrder = $_POST['order'][0]['dir']; 
            $searchValue = $_POST['search']['value']; 

            $searchArray = array();

            $searchQuery = " ";
            if($searchValue != '')
            {
                $searchQuery = " AND (category_name LIKE :category_name ) ";
                $searchArray = array( 
                    'category_name'=>"%$searchValue%",
                );
            }

            $stmt = $this->connect()->prepare("SELECT COUNT(*) AS allcount FROM category ");
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            $stmt = $this->connect()->prepare("SELECT COUNT(*) AS allcount FROM category WHERE 1 ".$searchQuery);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            $stmt = $this->connect()->prepare("SELECT * FROM category WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

            foreach ($searchArray as $key=>$search) 
            {
                $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $stmt->execute();
            $empRecords = $stmt->fetchAll();

            $data = array();

            foreach ($empRecords as $row) 
            {
                $data[] = array(
                    "category_name"=>$row['category_name'],
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );

            return $response;
        }
    }
?>