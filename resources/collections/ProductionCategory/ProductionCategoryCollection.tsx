import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/production-category';
import routes from '../../routes/production-category';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function () {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(productionCategory, key) => (
                <tr key={key}>
                    <td>
                        <Link to={routes.update.getPath(productionCategory.id)}>{productionCategory.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
