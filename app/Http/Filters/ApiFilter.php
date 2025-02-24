<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;

/**
 * Clase base para manejar los filtros en solicitudes http
 * @author Juan U.
 * @method array transform(Request $request)
 * - eq:  Equal                 (=).  Significa "igual a".
 * - lt:  Less Than             (<).  Significa "menor que".
 * - lte: Less Than or Equal    (<=). Significa "menor o igual que".
 * - gt:  Greater Than          (>).  Significa "mayor que".
 * - gte: Greater Than or Equal (>=). Significa "mayor o igual que".
 * - ne:  Not Equal             (!=). Significa "no igual a".
 */
class ApiFilter{
    /**
     * Parámetros seguros para filtros de modelos.
     *
     * @var array
     */
    protected $safeParams   = [];
    /**
     * Mapea las columnas a como queremos que se filtren.
     *
     * @var array
     */
    protected $columMap     = [];
    /**
     * Crea los mapeos de operadores.
     *
     * @var array
     */
    protected $operatorMap  = []; //Creamos los mapeos de operadores


    /**
     * Transforma parametros  de la request en condiciones de Eloquent
     * @param Request $request  objeto que captura la peticion
     * @return array
     */
    public function transform(Request $request){

        $eloQuery = [];

        foreach ($this->safeParams as $parm => $operators) {
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }

            $column = $this->columMap[$parm]?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column,$this->operatorMap[$operator],$query[$operator]];
                }
            }

        }
        return $eloQuery;
    }

    /**
     * Mapea los campos de la solicitud a las columnas de la base de datos y filtra los valores nulos.
     *
     * @param array $data
     * @return array
     */
    public function mapAndFilter(array $data): array
    {
        $mappedData = [];

        foreach ($data as $key => $value) {
            if (isset($this->columMap[$key])) {
                $column = $this->columMap[$key];
                if ($value !== null) {
                    $mappedData[$column] = $value;
                }
            }
        }

        return $mappedData;
    }


}
