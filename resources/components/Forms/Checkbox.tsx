import React from 'react';

export default function Checkbox(props) {
    const { label, name, value, checked, disabled, onChange, readOnly } = props;

    return (
        <div className="form-check">
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
