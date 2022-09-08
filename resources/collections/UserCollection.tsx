import React, { useCallback, useContext, useEffect, useState } from 'react';
import { debounce } from 'lodash';

import { paginate } from '../requests/user';
import { ApiContext } from '../contexts/ApiProvider';
import { NotificationsContext } from '../contexts/NotificationsProvider';
import PaginatedItems from '../components/Collections/PaginatedItems';

export default function UserCollection(props) {
    const { linkToFn, selectFn, selected, professorsOnly } = props;

    const [data, setData] = useState(null);
    const [links, setLinks] = useState(null);
    const [meta, setMeta] = useState(null);
    const [isLoading, setLoading] = useState(false);

    const [filterByName, setFilterByName] = useState(null);
    const debouncedSetFilter = useCallback(debounce(setFilterByName, 300), []);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);

    const doPaginate = (page = 1) => {
        paginate(apiProvider.api, notifications, setData, setLinks, setMeta, setLoading, page, {
            urlParams: {
                name: filterByName,
                role: professorsOnly ? 'professor' : undefined,
            },
        });
    };

    const onChange = ({ target }) => {
        debouncedSetFilter(target.value);
    };

    useEffect(() => {
        doPaginate();
    }, []);

    useEffect(() => {
        doPaginate();
    }, [filterByName]);

    return (
        <div>
            <div className="mb-3">
                <label htmlFor="name" className="form-label">
                    <small>Filtrar</small>
                </label>
                <input id="name" name="name" type="text" className="form-control form-control-sm" onChange={onChange} />
            </div>
            <PaginatedItems
                data={data}
                links={links}
                meta={meta}
                paginate={doPaginate}
                linkToFn={linkToFn}
                selected={selected}
                selectFn={selectFn}
                isLoading={isLoading}
            >
                {(item) => <span>{item.name}</span>}
            </PaginatedItems>
        </div>
    );
}
