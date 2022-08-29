import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/project';
import routes from '../../routes/project';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(project, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(project.id)}>{project.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
