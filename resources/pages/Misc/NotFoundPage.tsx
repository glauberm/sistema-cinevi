import React from 'react';
import { Link } from 'react-router-dom';

import authentication from '../../routes/authentication';

export default function () {
    return (
        <div className="text-center NotFoundPage">
            <h1 className="display-1 fw-bolder mb-4 text-warning mb-5">Não encontrada</h1>

            <Link className="h3" to={authentication.profile.path}>
                Ir ao seu índice
            </Link>
        </div>
    );
}
