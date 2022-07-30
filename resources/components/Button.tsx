import React from 'react';

export default function Button(props) {
    const { isLoading } = props;

    return (
        <button type={props.type || 'submit'} className={`btn ${props.className}`} disabled={isLoading}>
            {isLoading ? (
                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ) : (
                <span>{props.children}</span>
            )}
        </button>
    );
}
