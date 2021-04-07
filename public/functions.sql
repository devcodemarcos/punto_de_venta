DELIMITER $$

CREATE
    /*[DEFINER = { user | CURRENT_USER }]*/
    TRIGGER `punto_de_venta`.`updateStock` AFTER INSERT
    ON `punto_de_venta`.`sale_details`
    FOR EACH ROW BEGIN
	UPDATE `products`
	SET `stock` = stock - NEW.quantity
	WHERE `id` = new.`product_id`;
    END$$

DELIMITER ;