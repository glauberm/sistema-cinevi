import React from 'react';

import Button from '../Button';

export default function Pagination(props) {
    const { links, meta, paginate, isLoading } = props;

    return (
        <nav className="d-flex align-items-start justify-content-between">
            {meta && <small>{`Mostrando ${meta.from} a ${meta.to} de ${meta.total}`}</small>}

            {links && (
                <div>
                    <Button
                        type="button"
                        className="btn-secondary btn-sm mx-2"
                        disabled={!links.prev}
                        onClick={() => paginate(meta.current_page - 1)}
                        isLoading={isLoading}
                    >
                        Anterior
                    </Button>
                    <Button
                        type="button"
                        className="btn-secondary btn-sm mx-2"
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
