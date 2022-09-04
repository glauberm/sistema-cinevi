import React from 'react';
import { Link } from 'react-router-dom';

export default function Items(props) {
    const { data, children, selectFn, linkToFn, selected } = props;

    const isSelected = (item) => {
        return (
            selected !== null &&
            ((Array.isArray(selected) && selected.some((_item) => _item.id === item.id)) ||
                (!Array.isArray(selected) && item.id === selected.id))
        );
    };

    return (
        <div className="mb-2">
            {data.map((item, key) =>
                linkToFn !== null ? (
                    <Link key={key} to={linkToFn(item)} className="d-block w-100 p-2 text-start Items__item">
                        {children(item)}
                    </Link>
                ) : (
                    <button
                        key={key}
                        type="button"
                        onClick={() => selectFn(item)}
                        className={`
                            d-block w-100 p-2 text-start Items__item
                            ${isSelected(item) ? ' Items__item--selected' : ''}
                        `}
                    >
                        {children(item)}
                    </button>
                )
            )}
        </div>
    );
}

Items.defaultProps = {
    linkToFn: null,
    selectFn: null,
    selected: null,
};
