import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/production-category';
import Title from '../../components/Title';
import ProductionCategoryCollection from '../../collections/ProductionCategory/ProductionCategoryCollection';

export default function ProductionCategoryIndexPage() {
    return (
        <div>
            <Title>Modalidades</Title>

            <ProductionCategoryCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
