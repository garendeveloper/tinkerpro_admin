<?php
class ExpenseFacade extends DBConnection 
{
    public function get_data()
    {
        $stmt = $this->connect()->prepare("SELECT expenses.*, uom.uom_name, supplier.supplier, DATE_FORMAT(expenses.date_of_transaction, '%b %e, %Y') AS dot,
                                        COUNT(*) OVER() as total_count 
                                        FROM expenses
                                        INNER JOIN supplier ON supplier.id = expenses.supplier
                                        LEFT JOIN uom ON uom.id = expenses.uom_id
                                        ORDER BY expenses.id ASC"); 
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $data;
    }
    public function get_allExpensesDatatable($requestData, $start_date, $end_date)
    {
        $columns = [
            0 => 'expenses.id',
            1 => 'item_name',
            2 => 'date_of_transaction',
            3 => 'billable_receipt_no',
            4 => 'expense_type',
            5 => 'quantity',
            6 => 'supplier',
            7 => 'invoice_number',
            8 => 'price',
            9 => 'discount',
            10 => 'total_amount'
        ];
    
        if(empty($start_date) && empty($end_date))
        {
            $sql = "SELECT expenses.*, uom.uom_name, supplier.supplier,
            COUNT(*) OVER() as total_count 
            FROM expenses
            INNER JOIN supplier ON supplier.id = expenses.supplier
            LEFT JOIN uom ON uom.id = expenses.uom_id";
    
            if (!empty($requestData['search']['value'])) 
            {
                $sql .= " WHERE 
                        expenses.item_name LIKE :search_value
                        OR supplier.supplier LIKE :search_value
                        OR uom.uom_name LIKE :search_value
                        OR expenses.billable_receipt_no LIKE :search_value
                        OR expenses.expense_type LIKE :search_value
                        OR expenses.invoice_number LIKE :search_value";
            }
    
            if (!empty($requestData['order'])) 
            {
                $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
            } 
            else 
            {
                $sql .= " ORDER BY expenses.id DESC";
            }
            
            $sql .= " LIMIT :limit OFFSET :offset";
            
            $stmt = $this->connect()->prepare($sql);
            if (!empty($requestData['search']['value'])) {
                $search_value = '%' . $requestData['search']['value'] . '%';
                $stmt->bindParam(':search_value', $search_value, PDO::PARAM_STR);
            }
            $stmt->bindParam(':limit', $requestData['length'], PDO::PARAM_INT);
            $stmt->bindParam(':offset', $requestData['start'], PDO::PARAM_INT);
            $stmt->execute();
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }
        else
        {
            $sql = "SELECT expenses.*, uom.uom_name, supplier.supplier,
                    COUNT(*) OVER() as total_count 
                    FROM expenses
                    INNER JOIN supplier ON supplier.id = expenses.supplier
                    LEFT JOIN uom ON uom.id = expenses.uom_id
                    WHERE expenses.date_of_transaction BETWEEN :start_date AND :end_date";

            if (!empty($requestData['search']['value'])) {
            $sql .= " AND (
                        expenses.item_name LIKE :search_value
                        OR supplier.supplier LIKE :search_value
                        OR uom.uom_name LIKE :search_value
                        OR expenses.billable_receipt_no LIKE :search_value
                        OR expenses.expense_type LIKE :search_value
                        OR expenses.invoice_number LIKE :search_value
                    )";
            }

            if (!empty($requestData['order'])) {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
            } else {
            $sql .= " ORDER BY expenses.id DESC";
            }

            $sql .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
            if (!empty($requestData['search']['value'])) {
            $search_value = '%' . $requestData['search']['value'] . '%';
            $stmt->bindParam(':search_value', $search_value, PDO::PARAM_STR);
            }
            $stmt->bindParam(':limit', $requestData['length'], PDO::PARAM_INT);
            $stmt->bindParam(':offset', $requestData['start'], PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
    }
    public function get_allExpenses($start_date, $end_date)
    {
        $requestData = $_REQUEST;
        $data = $this->get_allExpensesDatatable($requestData, $start_date, $end_date);
    
        $totalData = $totalFiltered = 0;
        if (count($data) > 0) {
            $totalData = $totalFiltered = $data[0]['total_count'];
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    
        return $json_data;
    }
    public function get_expenseDataById($expense_id)
    {
        $sql = "SELECT expenses.*, uom.uom_name, supplier.supplier, supplier.id as supplier_id, uom.id as uom_id,
                COUNT(*) OVER() as total_count 
                FROM expenses
                INNER JOIN supplier ON supplier.id = expenses.supplier
                LEFT JOIN uom ON uom.id = expenses.uom_id
                WHERE expenses.id = '".$expense_id."'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function delete_expense($expense_id)
    {
        $sql = "DELETE FROM expenses WHERE id = '".$expense_id."'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return  [
            'success'=>true,
            'message'=>'Expense has been successfully removed.'
        ];
    }
    public function save_expense($formdata)
    {
        $response = [
            'success' => false,
            'message'=> '',
            'errors' => [],
            'data' => [],
        ];

        $fields_to_validate = ['item_name', 'date_of_transaction',  'qty', 'expense_type', 'price'];
        $field_labels = [
            'item_name' => 'Item Name',
            'date_of_transaction' => 'Date of Transaction',
            'qty' => 'Qty',
            'expense_type' => 'Expense Type',
            'price' => 'Price'
        ];
        foreach ($fields_to_validate as $field)
        {
            $value = isset($formdata[$field]) ? trim($formdata[$field]) : '';
            if (empty($value)) {
                $response['errors'][$field] = $this->validate_required($value, $field_labels[$field]);
            }
            $response['data'][$field] = $value;
        }

      
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == UPLOAD_ERR_OK) 
        {
            $uploadDir = 'expenses_uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image_url']['name']);
            
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) 
            {
                $response['data']['image_url'] = $uploadFile;
            } 
            else 
            {
                $response['errors']['image_url'] = 'Failed to upload image';
            }
        } 
        else 
        {
            $response['data']['image_url'] = null; 
        }

        if (empty(array_filter($response['errors']))) 
        {
            $item_name = $response['data']['item_name'];
            $billable_receipt_no = $formdata['billable_receipt_no'];
            $qty = $response['data']['qty'];
            $expense_type = $response['data']['expense_type'];
            $uom_id = $formdata['uomID'];
            $supplier_id = $formdata['supplier_id'];
            $invoice_number = $formdata['invoice_number'];
            $price = $response['data']['price'];
            $discount = $formdata['discount'];
            $total_amount = $formdata['total_amount'];
            $description = $formdata['description'];
            $date_of_transaction = DateTime::createFromFormat('m-d-Y', $response['data']['date_of_transaction'])->format('Y-m-d');
            $invoice_photo_url = $response['data']['image_url'];

            if(empty($formdata['expense_id']))
            {
                $sql = $this->connect()->prepare("
                    INSERT INTO expenses (item_name, date_of_transaction, billable_receipt_no, expense_type, quantity, uom_id, supplier, invoice_number, price, discount, total_amount, description, invoice_photo_url)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $sql->bindParam(1, $item_name, PDO::PARAM_STR);
                $sql->bindParam(2, $date_of_transaction, PDO::PARAM_STR);
                $sql->bindParam(3, $billable_receipt_no, PDO::PARAM_STR);
                $sql->bindParam(4, $expense_type, PDO::PARAM_STR);
                $sql->bindParam(5, $qty, PDO::PARAM_INT);
                $sql->bindParam(6, $uom_id, PDO::PARAM_INT);
                $sql->bindParam(7, $supplier_id, PDO::PARAM_INT);
                $sql->bindParam(8, $invoice_number, PDO::PARAM_STR);
                $sql->bindParam(9, $price, PDO::PARAM_STR);
                $sql->bindParam(10, $discount, PDO::PARAM_STR);
                $sql->bindParam(11, $total_amount, PDO::PARAM_STR);
                $sql->bindParam(12, $description, PDO::PARAM_STR);
                $sql->bindParam(13, $invoice_photo_url, PDO::PARAM_STR);
                $sql->execute();

                $response['message'] = "Expense has been successfully saved!";
            }
            else
            {
                $id = $formdata['expense_id'];
                $sql = $this->connect()->prepare("
                    UPDATE expenses
                    SET item_name = ?, date_of_transaction = ?, billable_receipt_no = ?, expense_type = ?, quantity = ?, uom_id = ?, supplier = ?, invoice_number = ?, price = ?, discount = ?, total_amount = ?, description = ?, invoice_photo_url = ?
                    WHERE id = ?
                ");
                
                $sql->bindParam(1, $item_name, PDO::PARAM_STR);
                $sql->bindParam(2, $date_of_transaction, PDO::PARAM_STR);
                $sql->bindParam(3, $billable_receipt_no, PDO::PARAM_STR);
                $sql->bindParam(4, $expense_type, PDO::PARAM_STR);
                $sql->bindParam(5, $qty, PDO::PARAM_INT);
                $sql->bindParam(6, $uom_id, PDO::PARAM_INT);
                $sql->bindParam(7, $supplier_id, PDO::PARAM_INT);
                $sql->bindParam(8, $invoice_number, PDO::PARAM_STR);
                $sql->bindParam(9, $price, PDO::PARAM_STR);
                $sql->bindParam(10, $discount, PDO::PARAM_STR);
                $sql->bindParam(11, $total_amount, PDO::PARAM_STR);
                $sql->bindParam(12, $description, PDO::PARAM_STR);
                $sql->bindParam(13, $invoice_photo_url, PDO::PARAM_STR);
                $sql->bindParam(14, $id, PDO::PARAM_INT);
                $sql->execute();

                $response['message'] = "Expense has been successfully updated!";
            }
            $response['success'] = true;
        }
    
        return $response;
    }
    function validate_required($field, $name) 
    {
        if (empty($field)) 
        {
            return "$name is required.";
        }
    }
    
    function validate_length($field, $name, $min, $max) 
    {
        $length = strlen($field);
        if ($length < $min || $length > $max) 
        {
            return "$name must be between $min and $max characters.";
        }
        return '';
    }
    
    function validate_number($field, $name, $min = null, $max = null) 
    {
        if (!is_numeric($field)) 
        {
            return "$name must be a number.";
        }
        if (!is_null($min) && $field < $min) 
        {
            return "$name must be at least $min.";
        }
        if (!is_null($max) && $field > $max) 
        {
            return "$name must be at most $max.";
        }
        return '';
    }
}
