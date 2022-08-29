import React from 'react';
import { useParams } from 'react-router-dom';

import ProjectCreateOrUpdateForm from '../../forms/Project/ProjectCreateOrUpdateForm';
import ProjectRemoveForm from '../../forms/Project/ProjectRemoveForm';
import Title from '../../components/Title';

export default function () {
    const params = useParams();

    return (
        <div>
            <Title>Editar Projeto</Title>

            <ProjectCreateOrUpdateForm id={params.id} />

            <hr className="invisible my-5" />

            <ProjectRemoveForm id={params.id} />
        </div>
    );
}
