import React from 'react';

export default function Radio(props) {
    const { label, name, value, checked, disabled, onChange, readOnly } = props;

    return (
        <div className="field">
            <div className="control">
                <label htmlFor={name} className="radio">
                    <input
                        name={name}
                        type="radio"
                        checked={value ? Boolean(value) : checked}
                        disabled={disabled}
                        onChange={onChange}
                        readOnly={readOnly}
                    />
                    &nbsp;
                    {label}
                </label>
            </div>
        </div>
    );
}
