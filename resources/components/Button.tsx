import React from 'react';

export default function Button(props) {
    return (
        <button
            name={props.name}
            type={props.type || 'submit'}
            className={`btn ${props.className}`}
            disabled={props.isLoading || props.disabled}
            onClick={props.onClick}
        >
            {props.isLoading ? (
                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ) : (
                <span>{props.children}</span>
            )}
        </button>
    );
}
