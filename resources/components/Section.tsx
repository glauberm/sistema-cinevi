import React from 'react';

export default function Section(props) {
    return (
        <section className="mb-5">
            <h2 className="h3 mb-4 fw-bold text-primary">{props.title}</h2>

            {props.children}
        </section>
    );
}
