import React from 'react';
import { useParams } from 'react-router-dom';

import ProductionRoleCreateOrUpdateForm from '../../forms/ProductionRole/ProductionRoleCreateOrUpdateForm';
import ProductionRoleRemoveForm from '../../forms/ProductionRole/ProductionRoleRemoveForm';
import Title from '../../components/Title';

export default function ProductionRoleUpdatePage() {
    const params = useParams();

    return (
        <div>
            <Title>Editar função</Title>

            <ProductionRoleCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <div className="text-center">
                <ProductionRoleRemoveForm id={params.id} />
            </div>
        </div>
    );
}
