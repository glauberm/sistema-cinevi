import React from 'react';

export default function Checkbox(props) {
    const { label, name, value, errors, touched, checked, disabled, onChange, readOnly } = props;

    return (
        <div className="form-check mb-2">
            <input
                id={name}
                name={name}
                type="checkbox"
                checked={checked === null ? Boolean(value) : checked}
                className={`form-check-input ${errors && touched ? 'is-invalid' : ''}`}
                disabled={disabled}
                onChange={onChange}
                readOnly={readOnly}
            />
            <label htmlFor={name} className="form-check-label">
                {label}
            </label>
        </div>
    );
}

Checkbox.defaultProps = {
    value: '',
    checked: null,
};
