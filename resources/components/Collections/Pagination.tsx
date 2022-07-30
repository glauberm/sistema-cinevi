import React from 'react';

export default function Pagination(props) {
    const { links, meta, paginate } = props;

    return (
        <nav className="d-flex align-items-start justify-content-between">
            {meta && <small>{`Mostrando ${meta.from} a ${meta.to} de ${meta.total}`}</small>}

            {links && (
                <div>
                    <button
                        type="button"
                        className="btn btn-secondary btn-sm mx-2"
                        disabled={!links.prev}
                        onClick={() => paginate(meta.current_page - 1)}
                    >
                        Anterior
                    </button>
                    <button
                        type="button"
                        className="btn btn-secondary btn-sm mx-2"
                        disabled={!links.next}
                        onClick={() => paginate(meta.current_page + 1)}
                    >
                        Próxima
                    </button>
                </div>
            )}
        </nav>
    );
}
