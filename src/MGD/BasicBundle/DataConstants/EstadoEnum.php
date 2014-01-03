<?php
/**
 * Created by lol.
 * User: PC
 * Date: 26/07/13
 * Time: 18:41
 */

namespace MGD\BasicBundle\DataConstants;


class EstadoEnum {

    const PendientePago = -1; // useless

    const Cola = 1;
    const Esperando = 2;
    const Fallido = 3;
    const Procesando = 4;
    const Finalizado = 5;

}