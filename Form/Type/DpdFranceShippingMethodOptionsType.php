<?php

declare(strict_types=1);

namespace Dnd\Bundle\DpdFranceShippingBundle\Form\Type;

use Dnd\Bundle\DpdFranceShippingBundle\Method\DpdFranceShippingMethod;
use Oro\Bundle\FlatRateShippingBundle\Form\Type\FlatRateOptionsType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class DpdFranceShippingMethodOptionsType
 *
 * @package   Dnd\Bundle\DpdFranceShippingBundle\Form\Type
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2004-present Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class DpdFranceShippingMethodOptionsType extends FlatRateOptionsType
{
    /**
     * Description BLOCK_PREFIX constant
     *
     * @var string BLOCK_PREFIX
     */
    public const BLOCK_PREFIX = 'dpd_france_shipping_config_options';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(DpdFranceShippingMethod::OPTION_SURCHARGE, NumberType::class, [
            'required'      => true,
            'label'         => 'dnd_dpd_france_shipping.form.shipping_method_config_options.surcharge.label',
            'scale'         => $this->roundingService->getPrecision(),
            'rounding_mode' => $this->roundingService->getRoundType(),
            'attr'          => [
                'data-scale' => $this->roundingService->getPrecision(),
                'class'      => 'method-options-additional-cost',
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
