import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/production-role';
import Title from '../../components/Title';
import ProductionRoleCollection from '../../collections/ProductionRoleCollection';

export default function ProductionRoleIndexPage() {
    return (
        <div>
            <Title>Funções</Title>

            <ProductionRoleCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
