<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

/**
 * Clase base para manejar los filtros en solicitudes http
 * @author Juan U.
 * @method array transform(Request $request)
 */
class PayFilter extends ApiFilter
{

    protected $safeParams = [
        'id' => ['eq', 'ne'],
        'name' => ['eq', 'ne', 'lk'],
        'description' => ['eq', 'ne', 'lk'],
        'payment_amount' => ['eq', 'ne'],
        'user_id' => ['eq', 'ne'],
        'status' => ['eq', 'ne'],
        'payment_date' => ['eq', 'ne'],
        // 'payment_method' => ['eq', 'ne'],
    ]; //Parametros para filtros de modelos
    protected $columMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'payment_amount' => 'amount',
        'user_id' => 'user_id',
        'status' => 'state_id',
        'payment_date' => 'payment_date',
    ]; //Mapea las columnas a como queremos que se filtren

    /**
     *eq:  Equal                 (=).  Significa "igual a".
     *lt:  Less Than             (<).  Significa "menor que".
     *lte: Less Than or Equal    (<=). Significa "menor o igual que".
     *gt:  Greater Than          (>).  Significa "mayor que".
     *gte: Greater Than or Equal (>=). Significa "mayor o igual que".
     *ne:  Not Equal             (!=). Significa "no igual a".
     */
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',
        'lk' => 'like',
    ]; //Creamos los mapeos de operadores
}
