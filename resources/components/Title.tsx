import React from 'react';

export default function Title(props) {
    return (
        <h1 className="display-6 mb-4 fw-bold text-primary">
            {props.children}
            <hr />
        </h1>
    );
}
