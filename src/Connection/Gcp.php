<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Adapter\Gcp\Connection;

use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;
use Google\Cloud\Core\ServiceBuilder;

/**
 * Gcp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org/
 */
class Gcp implements ConnectionInterface
{
    public function getName(): string
    {
        return 'Gcp';
    }

    public function getConnection(ParametersInterface $config): ServiceBuilder
    {
        $params = [
            'projectId' => $config->get('projectId'),
        ];

        $keyFile = $config->get('keyFile');
        if (!empty($keyFile)) {
            $params['keyFile'] = json_decode($keyFile, true);
        }

        return new ServiceBuilder($params);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
        $builder->add($elementFactory->newInput('projectId', 'Project-Id', 'The project ID from the Google Developers Console'));
        $builder->add($elementFactory->newTextArea('keyFile', 'Key-File', 'json', 'The contents of the service account credentials .json file retrieved from the Google Developers Console.'));
    }
}
