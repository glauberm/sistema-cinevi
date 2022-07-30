import React from 'react';

export default function Select(props) {
    const { name, label, labelHidden, value, defaultValue, onChange, errors, touched, children, isLoading } = props;

    return (
        <div className="field">
            <label htmlFor={name} className={`label${labelHidden ? ' is-sr-only' : ''}`}>
                {label}
            </label>
            <div className="control">
                <div className="select">
                    <select
                        id={name}
                        name={name}
                        value={value || defaultValue}
                        onChange={onChange}
                        className={`input ${errors && touched ? 'is-danger' : ''} ${isLoading ? 'is-loading' : ''}`}
                    >
                        {children}
                    </select>
                </div>
                {errors && touched && <div className="help is-danger">{errors}</div>}
            </div>
        </div>
    );
}
