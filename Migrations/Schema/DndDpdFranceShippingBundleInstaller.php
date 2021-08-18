<?php

namespace Dnd\Bundle\DpdFranceShippingBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Dnd\Bundle\DpdFranceShippingBundle\Migrations\Schema\v1_0\DndDpdFranceShippingBundle as DndDpdFranceShippingBundle_v1_O;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * Class DndDpdFranceShippingBundleInstaller
 *
 * @package   Dnd\Bundle\DpdFranceShippingBundle\Migrations\Schema
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2004-present Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class DndDpdFranceShippingBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        DndDpdFranceShippingBundle_v1_O::addStationFTPTransportColumns($schema);
        DndDpdFranceShippingBundle_v1_O::addGeneralDpdTransportColumns($schema);
        DndDpdFranceShippingBundle_v1_O::addDpdMethodsTransportColumns($schema);
    }
}
