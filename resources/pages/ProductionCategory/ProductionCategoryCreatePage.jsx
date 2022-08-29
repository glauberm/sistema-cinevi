import React from 'react';

import ProductionCategoryCreateOrUpdateForm from '../../forms/ProductionCategory/ProductionCategoryCreateOrUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Adicionar Modalidade</Title>

            <ProductionCategoryCreateOrUpdateForm />
        </div>
    );
}
