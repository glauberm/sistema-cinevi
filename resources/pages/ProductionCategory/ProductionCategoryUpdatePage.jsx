import React from 'react';
import { useParams } from 'react-router-dom';

import ProductionCategoryCreateOrUpdateForm from '../../forms/ProductionCategory/ProductionCategoryCreateOrUpdateForm';
import ProductionCategoryRemoveForm from '../../forms/ProductionCategory/ProductionCategoryRemoveForm';
import Title from '../../components/Title';

export default function () {
    const params = useParams();

    return (
        <div>
            <Title>Editar Modalidade</Title>

            <ProductionCategoryCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <ProductionCategoryRemoveForm id={params.id} />
        </div>
    );
}
