import React from 'react';

import { paginate } from '../../requests/user';
import PaginatedItems from '../../components/Collections/PaginatedItems';

export default function (props) {
    const { linkToFn, selectFn, selected, isLoading } = props;

    return (
        <PaginatedItems
            paginateFn={paginate}
            linkToFn={linkToFn}
            selectFn={selectFn}
            selected={selected}
            isLoading={isLoading}
        >
            {(item) => <span>{item.name}</span>}
        </PaginatedItems>
    );
}
