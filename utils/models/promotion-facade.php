<?php 

class PromotionFacade extends DBConnection 
{
    public function get_allData()
    {
        $sql = $this->connect()->prepare("SELECT promotions.*, products.*, promotions.id as promotion_id, promotions.barcode as promotion_barcode
                                                FROM promotions
                                                INNER JOIN products ON promotions.product_id = products.id
                                                ORDER BY promotions.id DESC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_promotionDetails($promotion_id)
    {
        $sql = $this->connect()->prepare("SELECT promotions.*, products.*, promotions.id as promotion_id, promotions.barcode as promotion_barcode
                                        FROM promotions
                                        INNER JOIN products ON promotions.product_id = products.id
                                        WHERE promotions.id = $promotion_id");
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    public function deletePromotion($id)
    {
        $sql = $this->connect()->prepare("DELETE FROM promotions WHERE id = :id");
        $sql->execute([':id' => $id]);
        return [
            'success'=>true,
            'message'=>'Item has been successfully deleted.'
        ];
    }
    public function save($formData)
    {
        $bundledData = $formData['bundledData'];
        $serializedFormData = $formData['formData'];
        $formdata = [];
        parse_str($serializedFormData, $formdata);
        
        $response = [
            'success' => false,
            'message'=> '',
            'errors' => [],
            'data' => [],
        ];

        $fields_to_validate = ['product_id', 'qty', 'newprice',  'newbarcode'];
        $field_labels = [
            'product_id' => 'Product',
            'qty' => 'QTY',
            'newprice' => 'Price',
            'newbarcode' => 'Barcode',
        ];
        foreach ($fields_to_validate as $field)
        {
            $value = isset($formdata[$field]) ? trim($formdata[$field]) : '';
            if (empty($value)) {
                $response['errors'][$field] = $this->validate_required($value, $field_labels[$field]);
            }
            $response['data'][$field] = $value;
        }

        if (empty(array_filter($response['errors']))) 
        {
            $promotion_id = $formdata['promotion_id'];
            $promotion_type = $formdata['promotion_type'];
            switch($promotion_type)
            {
                case 1:
                    if(empty($promotion_id))
                    {
                        $sql = $this->connect()->prepare("INSERT INTO promotions (product_id, promotion_type, qty, newprice, barcode, promo_period)
                        VALUES (?, ?, ?, ?, ?, ?)");
                        $sql->execute([$response['data']['product_id'], $promotion_type, $response['data']['qty'], $response['data']['newprice'], $response['data']['newbarcode'], "2024-07-31" ]);
                        $response['success'] = true;
                        $response['message'] = "Data has been successfully saved";
                    }
                    else
                    {
                        $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode WHERE id = :promotion_id");
                        $sql->execute([
                            ':qty' => $response['data']['qty'],
                            ':newprice' => $response['data']['newprice'],
                            ':newbarcode' => $response['data']['newbarcode'],
                            ':promotion_id' => $promotion_id,
                        ]);
                        $response['success'] = true;
                        $response['message'] = "Data has been successfully saved";
                    }
                    break;
                case 2: 
                    if(empty($promotion_id))
                    {
                        $sql = $this->connect()->prepare("INSERT INTO promotions (product_id, promotion_type, qty, newprice, barcode, promo_period, promotion_items)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $sql->execute([
                            $response['data']['product_id'], 
                            $promotion_type, 
                            $response['data']['qty'], 
                            $response['data']['newprice'], 
                            $response['data']['newbarcode'], 
                            "2024-07-31",
                            $bundledData, 
                        ]);
                        $response['success'] = true;
                        $response['message'] = "Data has been successfully saved";
                    }
                    else
                    {
                        $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode, promotion_items = :promotion_items WHERE id = :promotion_id");
                        $sql->execute([
                            ':qty' => $response['data']['qty'],
                            ':newprice' => $response['data']['newprice'],
                            ':newbarcode' => $response['data']['newbarcode'],
                            ':promotion_items' => $bundledData,
                            ':promotion_id' => $promotion_id,
                        ]);
                        $response['success'] = true;
                        $response['message'] = "Data has been successfully saved";
                    }
                    break;
                default: break;
            }
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