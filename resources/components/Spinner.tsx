import React from 'react';

export default function Spinner(props) {
    return (
        <div className="d-flex justify-content-center m-5 p-5">
            <div className="spinner-border text-warning" role="status">
                <span className="visually-hidden">Carregando...</span>
            </div>
        </div>
    );
}
