import React from 'react';

import FinalCopyCreateOrUpdateForm from '../../forms/FinalCopy/FinalCopyCreateOrUpdateForm';
import Title from '../../components/Title';

export default function FinalCopyCreatePage() {
    return (
        <div>
            <Title>Adicionar Cópia Final</Title>

            <FinalCopyCreateOrUpdateForm />
        </div>
    );
}
