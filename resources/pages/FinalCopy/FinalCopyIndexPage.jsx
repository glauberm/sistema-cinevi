import React from 'react';
import { Link } from 'react-router-dom';

import routes from '../../routes/final-copy';
import Title from '../../components/Title';
import FinalCopyCollection from '../../collections/FinalCopyCollection';

export default function FinalCopyIndexPage() {
    return (
        <div>
            <Title>Cópias Finais</Title>

            <FinalCopyCollection linkToFn={(item) => routes.update.getPath(item.id)} />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to={routes.create.path}>
                Adicionar
            </Link>
        </div>
    );
}
