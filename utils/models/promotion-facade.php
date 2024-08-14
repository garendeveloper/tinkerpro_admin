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
    public function verify_barcode($barcode, $promotion_id)
    {
        if(empty($promotion_id))
        {
            $sql = $this->connect()->prepare("SELECT * FROM promotions WHERE barcode = :barcode");
            $sql->execute([':barcode'=>$barcode]);
            return $sql->rowCount() > 0;
        }
        else
        {
            $sql = $this->connect()->prepare("SELECT * FROM promotions WHERE barcode = :barcode AND id != :exclude_id");
            $sql->execute([':barcode' => $barcode, ':exclude_id' => $promotion_id]);
            return $sql->rowCount() > 0;
        }
      
    }
    public function save($formData)
    {
        $bundledData = $formData['bundledData'];
        $promo_datePeriod = $formData['promo_datePeriod'];

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

            $response['success'] = 405;
            $response['message'] = "Cannot create the same barcode";

            if(!$this->verify_barcode($response['data']['newbarcode'], $promotion_id))
            {
                switch($promotion_type)
                {
                    case 1:
                        if(empty($promotion_id))
                        {
                            $sql = $this->connect()->prepare("INSERT INTO promotions (product_id, promotion_type, qty, newprice, barcode, promo_period)
                            VALUES (?, ?, ?, ?, ?, ?)");
                            $sql->execute([$response['data']['product_id'], $promotion_type, $response['data']['qty'], $response['data']['newprice'], $response['data']['newbarcode'], $promo_datePeriod]);
                            $response['success'] = true;
                            $response['message'] = "Data has been successfully saved";
                        }
                        else
                        {
                            $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode, promo_period = :promo_period WHERE id = :promotion_id");
                            $sql->execute([
                                ':qty' => $response['data']['qty'],
                                ':newprice' => $response['data']['newprice'],
                                ':newbarcode' => $response['data']['newbarcode'],
                                ':promo_period' => $promo_datePeriod,
                                ':promotion_id' => $promotion_id,
                            ]);
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
                                $promo_datePeriod,
                                $bundledData, 
                            ]);
                        }
                        else
                        {
                            $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode, promotion_items = :promotion_items, promo_period = :promo_period WHERE id = :promotion_id");
                            $sql->execute([
                                ':qty' => $response['data']['qty'],
                                ':newprice' => $response['data']['newprice'],
                                ':newbarcode' => $response['data']['newbarcode'],
                                ':promotion_items' => $bundledData,
                                ':promo_period' => $promo_datePeriod,
                                ':promotion_id' => $promotion_id,
                            ]);
                        }
                        break;
                    case 3: 
                            if(empty($promotion_id))
                            {
                                $sql = $this->connect()->prepare("INSERT INTO promotions (product_id, promotion_type, qty, newprice, barcode, promo_period, totalPrice)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
                                $sql->execute([
                                    $response['data']['product_id'], 
                                    $promotion_type, 
                                    $response['data']['qty'], 
                                    $response['data']['newprice'], 
                                    $response['data']['newbarcode'], 
                                    $promo_datePeriod,
                                    $formdata['totalPrice'], 
                                ]);
                            }
                            else
                            {
                                $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode, totalPrice = :totalPrice, promo_period = :promo_period WHERE id = :promotion_id");
                                $sql->execute([
                                    ':qty' => $response['data']['qty'],
                                    ':newprice' => $response['data']['newprice'],
                                    ':newbarcode' => $response['data']['newbarcode'],
                                    ':totalPrice' => $formdata['totalPrice'],
                                    ':promo_period' => $promo_datePeriod,
                                    ':promotion_id' => $promotion_id,
                                ]);
                            }
                            break;
                    case 4: 
                            if(empty($promotion_id))
                            {
                                $sql = $this->connect()->prepare("INSERT INTO promotions (product_id, promotion_type, qty, newprice, barcode, promo_period, points)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
                                $sql->execute([
                                    $response['data']['product_id'], 
                                    $promotion_type, 
                                    $response['data']['qty'], 
                                    $response['data']['newprice'], 
                                    $response['data']['newbarcode'], 
                                    $promo_datePeriod,
                                    $formdata['points'], 
                                ]);
                            }
                            else
                            {
                                $sql = $this->connect()->prepare("UPDATE promotions SET qty = :qty, newprice = :newprice, barcode = :newbarcode, points = :points, promo_period = :promo_period WHERE id = :promotion_id");
                                $sql->execute([
                                    ':qty' => $response['data']['qty'],
                                    ':newprice' => $response['data']['newprice'],
                                    ':newbarcode' => $response['data']['newbarcode'],
                                    ':points' => $formdata['points'],
                                    ':promo_period' => $promo_datePeriod,
                                    ':promotion_id' => $promotion_id,
                                ]);
                            }
                            break;
                    default: break;
                }
                $response['success'] = true;
                $response['message'] = "Data has been successfully saved";
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
    public function check_promotion($promotionType)
    {
        $promotionType = (int) $promotionType;
        $sql = $this->connect()->prepare("SELECT * FROM promotions WHERE promotion_type = $promotionType");
        $sql->execute();
        $hasData = $sql->rowCount() > 0;

        return $hasData;
    }
    public function get_allPriceList()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM pricelist ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function verify_priceList($pricelist_name, $id)
    {
        if(!empty($id))
        {
            $sql = $this->connect()->prepare("SELECT * FROM pricelist WHERE price_list_name = ? AND id <> ?");
            $sql->execute([$pricelist_name, $id]);
            return $sql->rowCount() > 0;
        }
        else
        {
            $sql = $this->connect()->prepare("SELECT * FROM pricelist WHERE price_list_name = ?");
            $sql->execute([$pricelist_name]);
            return $sql->rowCount() > 0;
        }
    }
    public function save_priceList($formData)
    {
        $pricelist_name = $formData['priceListName'];
        $rule = $formData['rule'];
        $type = $formData['type'];
        $priceAdjustment = $formData['priceAdjustment'];

        $priceList_id = $formData['priceList_id'];
        if($this->verify_priceList($pricelist_name, $priceList_id))
        {
            return [
                'success'=>false,
                'message'=>'Price List already exists.'
            ];
        }
        else
        {
            if(isset($priceList_id) && !empty($priceList_id))
            {
                $stmt = $this->connect()->prepare("UPDATE pricelist SET price_list_name = ?, rule = ?, type = ?, adjustment = ? WHERE id = ?");
                $stmt->execute([$pricelist_name, $rule, $type, $priceAdjustment, $priceList_id]);
                return [
                    'success'=>true,
                    'message'=>'Price List has been updated successfully.'
                ];
            }
            else
            {
                $stmt = $this->connect()->prepare("INSERT INTO pricelist (price_list_name, rule, type, adjustment) VALUES (?, ?, ?, ?)");
                $stmt->execute([$pricelist_name, $rule, $type, $priceAdjustment]);
                return [
                    'success'=>true,
                    'message'=>'Price List has been added successfully.'
                ];
            }
        }
    }
}