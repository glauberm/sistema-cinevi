import React from 'react';

export default function Checkbox(props) {
    const { label, name, value, checked, disabled, onChange, readOnly } = props;

    return (
        <div className="field">
            <div className="control">
                <label htmlFor={name} className="checkbox">
                    <input
                        name={name}
                        type="checkbox"
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
