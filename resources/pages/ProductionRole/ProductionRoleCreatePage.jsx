import React from 'react';

import ProductionRoleCreateOrUpdateForm from '../../forms/ProductionRole/ProductionRoleCreateOrUpdateForm';
import Title from '../../components/Title';

export default function ProductionRoleCreatePage() {
    return (
        <div>
            <Title>Adicionar função</Title>

            <ProductionRoleCreateOrUpdateForm />
        </div>
    );
}
