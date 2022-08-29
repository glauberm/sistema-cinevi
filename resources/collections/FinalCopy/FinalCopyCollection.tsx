import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/final-copy';
import routes from '../../routes/final-copy';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(finalCopy, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(finalCopy.id)}>{finalCopy.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
