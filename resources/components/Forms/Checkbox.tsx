import React from 'react';

export default function Checkbox(props) {
    const { label, name, value, checked, disabled, size, onChange, readOnly } = props;

    return (
        <div className={`form-check mb-2 ${size === 'sm' ? 'form-check-sm' : ''}`}>
            <input
                id={name}
                name={name}
                type="checkbox"
                checked={checked === null ? Boolean(value) : checked}
                className="form-check-input"
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
