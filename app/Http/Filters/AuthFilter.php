<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;


/**
 * Clase base para manejar los filtros en solicitudes http
 * @author Juan U.
 * @method array transform(Request $request)
 */
class AuthFilter extends ApiFilter
{
    protected $safeParams   = [
        'email'     => ['eq', 'ne'],
        'password'  => ['eq', 'ne'],
    ]; //Parametros para filtros de modelos
    protected $columMap     = [
        'email' => 'email',
        'password' => 'password',
    ]; //Mapea las columnas a como queremos que se filtren


    /**
     *eq:  Equal                 (=).  Significa "igual a".
     *lt:  Less Than             (<).  Significa "menor que".
     *lte: Less Than or Equal    (<=). Significa "menor o igual que".
     *gt:  Greater Than          (>).  Significa "mayor que".
     *gte: Greater Than or Equal (>=). Significa "mayor o igual que".
     *ne:  Not Equal             (!=). Significa "no igual a".
     */
    protected $operatorMap  = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',


    ]; //Creamos los mapeos de operadores

}
