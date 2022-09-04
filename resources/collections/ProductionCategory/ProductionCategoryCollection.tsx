import React from 'react';

import { paginate } from '../../requests/production-category';
import PaginatedItems from '../../components/Collections/PaginatedItems';

export default function ProductionCategoryCollection(props) {
    const { linkToFn, selectFn, selected, isLoading } = props;

    return (
        <PaginatedItems
            paginateFn={paginate}
            linkToFn={linkToFn}
            selectFn={selectFn}
            selected={selected}
            isLoading={isLoading}
        >
            {(item) => <span>{item.title}</span>}
        </PaginatedItems>
    );
}
