import React from 'react';
import { useParams } from 'react-router-dom';

import FinalCopyCreateOrUpdateForm from '../../forms/FinalCopy/FinalCopyCreateOrUpdateForm';
import FinalCopyRemoveForm from '../../forms/FinalCopy/FinalCopyRemoveForm';
import Title from '../../components/Title';

export default function FinalCopyUpdatePage() {
    const params = useParams();

    return (
        <div>
            <Title>Editar Cópia Final</Title>

            <FinalCopyCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <FinalCopyRemoveForm id={params.id} />
        </div>
    );
}
