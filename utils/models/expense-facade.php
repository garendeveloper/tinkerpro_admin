<?php
class ExpenseFacade extends DBConnection 
{
    public function get_allExpenses()
    {
        $sql = $this->connect()->prepare("SELECT expenses.*, uom.uom_name, supplier.supplier
                                        FROM expenses
                                        INNER JOIN supplier ON supplier.id = expenses.supplier
                                        LEFT JOIN uom ON uom.id = expenses.uom_id
                                        ORDER BY expenses.id DESC;");
        $sql->execute();
        $expenses = $sql->fetchAll(PDO::ASSOC);
    }
    public function save_expense($formdata)
    {
        $response = [
            'success' => false,
            'errors' => [],
            'data' => [],
        ];

        $item_name = isset($formdata['item_name']) ? trim($formdata['item_name']) : '';
        $date_of_transaction = isset($formdata['date_of_transaction']) ? trim($formdata['date_of_transaction']) : '';
        $billable_receipt_no = $formdata['billable_receipt_no'];
        $expense_type = isset($formdata['expense_type']) ? trim($formdata['expense_type']) : '';
        $qty = isset($formdata['qty']) ? trim($formdata['qty']) : '';
        $uom_id = isset($formdata['uomID']) ? trim($formdata['uomID']) : '';
        $supplier_id = isset($formdata['supplier_id']) ? trim($formdata['supplier_id']) : '';
        $invoice_number = $formdata['invoice_number'];
        $uom_id = $formdata['price'];
        $discount = $formdata['discount'];
        $total_amount = $formdata['total_amount'];

        $response['errors']['item_name'] = $this->validate_required($item_name, 'Item Name');
        $response['errors']['date_of_transaction'] = $this->validate_required($date_of_transaction, 'Date of Transaction');
        $response['errors']['billable_receipt_no'] = $this->validate_required($item_name, 'Billable');
        $response['errors']['qty'] = $this->validate_required($qty, 'Qty');

        if(!empty($response['errors']))
        {
            $response['success'] = true;
            $response['data'] = [
                'item_name' => $item_name,
                'date_of_transaction' => $date_of_transaction,
                'billable_receipt_no' => $billable_receipt_no,
                'qty' => $qty
            ];
        }

        return $response;
    }
    function validate_required($field, $name) 
    {
        if (empty($field)) 
        {
            return "$name is required.";
        }
        return '';
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
