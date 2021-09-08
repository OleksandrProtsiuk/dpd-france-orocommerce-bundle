<?php

declare(strict_types=1);

namespace Dnd\Bundle\DpdFranceShippingBundle\EventListener;

use Dnd\Bundle\DpdFranceShippingBundle\Condition\ShippableWithDpdFrance;
use Dnd\Bundle\DpdFranceShippingBundle\Method\DpdFranceShippingMethodProvider;
use Oro\Bundle\CheckoutBundle\Entity\Checkout;
use Oro\Bundle\SaleBundle\Entity\QuoteDemand;
use Oro\Bundle\ShippingBundle\Event\ApplicableMethodsEvent;
use Oro\Bundle\ShippingBundle\Method\ShippingMethodViewCollection;

/**
 * Class ShippingMethodsListener
 *
 * @package   Dnd\Bundle\DpdFranceShippingBundle\EventListener
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2004-present Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class ShippingMethodsListener
{
    /**
     * Description $shippableWithDpdFranceCondition field
     *
     * @var ShippableWithDpdFrance $shippableWithDpdFranceCondition
     */
    protected ShippableWithDpdFrance $shippableWithDpdFranceCondition;

    /**
     * ShippingMethodsListener constructor
     *
     * @param ShippableWithDpdFrance $shippableWithDpdFranceCondition
     */
    public function __construct(ShippableWithDpdFrance $shippableWithDpdFranceCondition)
    {
        $this->shippableWithDpdFranceCondition = $shippableWithDpdFranceCondition;
    }

    /**
     * Ensures that DPD france shipping services meet conditions
     *
     * @param ApplicableMethodsEvent $event
     *
     * @return void
     */
    public function enforceDpDFranceValidations(ApplicableMethodsEvent $event): void
    {
        /** @var ShippingMethodViewCollection $methodCollection */
        $methodCollection = $event->getMethodCollection();

        /** @var Checkout|QuoteDemand $methodCollection */
        $sourceEntity = $event->getSourceEntity();

        if (!$sourceEntity instanceof Checkout || $sourceEntity->getSourceEntity() instanceof QuoteDemand) {
            return;
        }

        /**
         * @var string  $shippingMethodName
         * @var mixed[] $methodTypes
         */
        foreach ($methodCollection->getAllMethodsTypesViews() as $shippingMethodName => &$methodTypes) {
            if (DpdFranceShippingMethodProvider::isDpdFrShippingMethod($shippingMethodName)) {
                /**
                 * @var string  $methodTypeId
                 * @var mixed[] $methodTypesView
                 */
                foreach ($methodTypes as $methodTypeId => &$methodTypesView) {
                    $methodTypeView =$methodCollection->getMethodTypeView($shippingMethodName, $methodTypeId);
                    $methodTypeView['logo'] = 'logo.png'; //@TODO fetch it from shippingService
                    $methodCollection->removeMethodTypeView($shippingMethodName, $methodTypeId);
                    $methodCollection->addMethodTypeView($shippingMethodName, $methodTypeId, $methodTypeView);
                    if ($this->shippableWithDpdFranceCondition->isValid($methodTypesView, $sourceEntity) !== true) {
                        $methodCollection->removeMethodTypeView($shippingMethodName, $methodTypeId);
                    }
                }
            }
        }

    }
}
