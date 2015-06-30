<?php
/**
 * Created by MGDSoftware. 21/06/15
 */

namespace MGD\BasicBundle\Entity;


class AbstractPrice
{
    public function calculateRealPrice(PrecioRango $precioRango = null, $nReferidos=0, Cuenta $cuenta = null, CuponDescuento $cuponDescuento = null)
    {
        if (!$precioRango && !$cuenta) {
            return null;
        }

        if ($cuenta)
        {
            $valor = $cuenta->getPrecio();
        }
        else
            $valor = $precioRango->getPrecio() * $nReferidos;

        if ($cuponDescuento) {
            if ($cuponDescuento->getPorcentajeBoo()) {
                $valor -= ($valor * $cuponDescuento->getValor() / 100);
            } else {
                $valor -= $cuponDescuento->getValor();
            }
        }

        // min value 5€
        if ($valor < 2) {
            $total = 2;

        } else {
            $total = $valor;
        }

        return number_format($total, 2, '.', '');

    }
}