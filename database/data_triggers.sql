USE mizzastore;
/* ╔═══════════════════════════════════════════════════════════════╗
   ║  TRIGGER AUTOMÁTICO DE AUDITORÍA                              ║
   ╚═══════════════════════════════════════════════════════════════╝ */
DELIMITER $$

CREATE TRIGGER trg_auditoria_cambio_password
AFTER UPDATE ON usuario
FOR EACH ROW
BEGIN
    -- Solo registrar si el password realmente cambió
    IF (OLD.password_usuario <> NEW.password_usuario) THEN
        INSERT INTO auditoria_contrasenas (id_usuario, fecha_cambio)
        VALUES (NEW.id_usuario, NOW());
    END IF;
END $$

DELIMITER ;
