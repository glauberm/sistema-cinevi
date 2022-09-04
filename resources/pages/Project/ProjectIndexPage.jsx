import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/project';
import Title from '../../components/Title';
import ProjectCollection from '../../collections/Project/ProjectCollection';

export default function () {
    return (
        <div>
            <Title>Projetos</Title>

            <ProjectCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
