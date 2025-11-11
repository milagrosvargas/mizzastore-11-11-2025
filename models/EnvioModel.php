<?php
require_once 'models/Conexion.php';

class EnvioModel
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->Conectar();
    }

    // ==========================================================
    // 🧩 SELECCIÓN TEMPORAL (ANTES DE CREAR PEDIDO)
    // ==========================================================

    /**
     * Guarda temporalmente la selección del método de envío en la sesión.
     * @param string   $tipoEnvio     'retiro' | 'domicilio'
     * @param int|null $idDomicilio   ID del domicilio (solo si domicilio)
     */
    public function guardarSeleccionTemporal(string $tipoEnvio, ?int $idDomicilio = null): void
    {
        require_once 'core/Sesion.php';
        Sesion::iniciar();

        $_SESSION['envio_seleccion'] = [
            'tipo_envio'   => $tipoEnvio,
            'id_domicilio' => $idDomicilio,
            'estado'       => 'pendiente',
            'timestamp'    => time()
        ];
    }

    /**
     * Devuelve la selección temporal almacenada en la sesión (o null si no existe).
     * @return array|null
     */
    public function obtenerSeleccionTemporal(): ?array
    {
        require_once 'core/Sesion.php';
        Sesion::iniciar();
        return $_SESSION['envio_seleccion'] ?? null;
    }

    /**
     * Limpia la selección temporal de envío de la sesión.
     */
    public function limpiarSeleccionTemporal(): void
    {
        require_once 'core/Sesion.php';
        Sesion::iniciar();
        unset($_SESSION['envio_seleccion']);
    }

    // ==========================================================
    // 📦 CREACIÓN DE ENVÍO FINAL (DESPUÉS DE CREAR PEDIDO)
    // ==========================================================

    /**
     * Inserta un registro definitivo en la tabla 'envio' asociado a un pedido real.
     * @param int      $idPedido
     * @param int|null $idDomicilio
     * @return int ID autoincremental del envío creado
     * @throws Exception si falla la inserción
     */
    public function crearEnvioFinal(int $idPedido, ?int $idDomicilio = null): int
    {
        try {
            $sql = "INSERT INTO envio (id_pedido, id_domicilio, estado, fecha_envio)
                    VALUES (:id_pedido, :id_domicilio, 'pendiente', NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);

            if ($idDomicilio !== null) {
                $stmt->bindParam(':id_domicilio', $idDomicilio, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':id_domicilio', null, PDO::PARAM_NULL);
            }

            $stmt->execute();
            return (int)$this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creando envío final: " . $e->getMessage());
            throw new Exception("No se pudo registrar el envío.");
        }
    }

    // ==========================================================
    // 🏠 OBTENER DOMICILIO COMPLETO DEL USUARIO AUTENTICADO
    // ==========================================================

    /**
     * Obtiene el domicilio completo del usuario logueado recorriendo:
     * usuario → persona → domicilio → barrio → localidad → provincia → pais
     *
     * NOTA: No se asume relación directa con 'cliente'. Se usa la relación
     *       a través de persona (coherente con la sesión que expone 'relacion_persona').
     *
     * @param int $idUsuario
     * @return array|null
     */
    public function obtenerDomicilioPorUsuario(int $idUsuario): ?array
    {
        try {
            $sql = "SELECT 
                        d.id_domicilio,
                        d.calle_direccion,
                        d.numero_direccion,
                        d.piso_direccion,
                        d.info_extra_direccion,
                        b.nombre_barrio,
                        l.nombre_localidad,
                        p.nombre_provincia,
                        pa.nombre_pais,
                        CONCAT(
                            d.calle_direccion, ' ',
                            COALESCE(d.numero_direccion, ''), 
                            CASE 
                                WHEN d.piso_direccion IS NOT NULL AND d.piso_direccion <> '' 
                                THEN CONCAT(', Piso ', d.piso_direccion) 
                                ELSE '' 
                            END,
                            CASE 
                                WHEN d.info_extra_direccion IS NOT NULL AND d.info_extra_direccion <> '' 
                                THEN CONCAT(' (', d.info_extra_direccion, ')') 
                                ELSE '' 
                            END
                        ) AS direccion_completa
                    FROM usuario u
                    INNER JOIN persona per   ON per.id_persona   = u.relacion_persona
                    INNER JOIN domicilio d   ON d.id_domicilio   = per.id_domicilio
                    INNER JOIN barrio b      ON b.id_barrio      = d.id_barrio
                    INNER JOIN localidad l   ON l.id_localidad   = b.id_localidad
                    INNER JOIN provincia p   ON p.id_provincia   = l.id_provincia
                    INNER JOIN pais pa       ON pa.id_pais       = p.id_pais
                    WHERE u.id_usuario = :id_usuario
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            $dom = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dom) {
                // Texto formateado para mostrar directo en el modal
                $dom['texto_formateado'] = sprintf(
                    "%s, %s, %s, %s, %s",
                    trim($dom['direccion_completa']),
                    $dom['nombre_barrio'],
                    $dom['nombre_localidad'],
                    $dom['nombre_provincia'],
                    $dom['nombre_pais']
                );
            }

            return $dom ?: null;
        } catch (PDOException $e) {
            error_log("Error obteniendo domicilio por usuario: " . $e->getMessage());
            return null;
        }
    }
}
