import React from 'react';

import ProjectCreateOrUpdateForm from '../../forms/Project/ProjectCreateOrUpdateForm';
import Title from '../../components/Title';

export default function ProjectCreatePage() {
    return (
        <div>
            <Title>Adicionar Projeto</Title>

            <ProjectCreateOrUpdateForm />
        </div>
    );
}
