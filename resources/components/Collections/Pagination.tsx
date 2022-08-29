import React from 'react';

import Button from '../Button';

export default function (props) {
    const { links, meta, paginate, isLoading } = props;

    return (
        <nav className="d-flex align-items-start justify-content-between">
            {meta && (
                <div className="my-1 me-1">
                    <small>{`Mostrando ${meta.from} a ${meta.to} de ${meta.total}`}</small>
                </div>
            )}

            {links && (
                <div className="d-flex flex-wrap justify-content-end">
                    <Button
                        type="button"
                        className="btn-secondary btn-sm my-1 mx-1"
                        disabled={!links.prev}
                        onClick={() => paginate(meta.current_page - 1)}
                        isLoading={isLoading}
                    >
                        Anterior
                    </Button>
                    <Button
                        type="button"
                        className="btn-secondary btn-sm my-1 mx-1"
                        disabled={!links.next}
                        onClick={() => paginate(meta.current_page + 1)}
                        isLoading={isLoading}
                    >
                        Próxima
                    </Button>
                </div>
            )}
        </nav>
    );
}
