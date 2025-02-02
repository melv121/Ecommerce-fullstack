<?php
require_once __DIR__ . '/../includes/database.php';

class Article {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM articles";
        $result = $conn->query($sql);
        $articles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }

    public static function getArticlesWithPromotions() {
        global $conn;
        $sql = "SELECT *, 
                CASE 
                    WHEN promotion_start <= CURRENT_DATE AND promotion_end >= CURRENT_DATE 
                    THEN price * (1 - reduction/100) 
                    ELSE price 
                END as final_price 
                FROM articles 
                WHERE reduction > 0 
                AND promotion_start <= CURRENT_DATE 
                AND promotion_end >= CURRENT_DATE";
        
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function calculateDiscountedPrice($price, $reduction) {
        return $price * (1 - ($reduction/100));
    }
}
?>
