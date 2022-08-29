import React from 'react';

import ProjectCreateOrUpdateForm from '../../forms/Project/ProjectCreateOrUpdateForm';
import Title from '../../components/Title';

export default function () {
    return (
        <div>
            <Title>Adicionar Projeto</Title>

            <ProjectCreateOrUpdateForm />
        </div>
    );
}
