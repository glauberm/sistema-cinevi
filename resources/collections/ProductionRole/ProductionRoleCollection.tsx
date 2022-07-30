import React from 'react';
import { Link } from 'react-router-dom';

import { paginate } from '../../requests/production-role';
import PaginatedTable from '../../components/Collections/PaginatedTable';

export default function ProductionRoleCollection() {
    return (
        <PaginatedTable paginateFn={paginate}>
            {(row, key) => (
                <tr key={key}>
                    <td>
                        <Link to={`/funcoes/${row.id}`}>{row.title}</Link>
                    </td>
                </tr>
            )}
        </PaginatedTable>
    );
}
