import React from 'react';
import { Field as FormikField } from 'formik';
import { FastField as FormikFastField } from 'formik';

export default function Field(props) {
    const {
        name,
        label,
        labelHidden,
        type,
        autoComplete,
        placeholder,
        as,
        component,
        style,
        size,
        errors,
        touched,
        children,
        messages,
        isFastField,
    } = props;

    const componentProps = {
        id: name,
        name: name,
        type: type,
        autoComplete: autoComplete || 'off',
        placeholder: placeholder,
        as: as,
        component: component,
        style: style,
        className: `
            form-control Field
            ${size === 'lg' ? 'form-control-lg' : ''}
            ${errors && touched ? 'is-invalid' : ''}
        `,
    };

    return (
        <div className="mb-4">
            <label htmlFor={name} className={`form-label ${labelHidden ? 'visually-hidden-focusable' : ''}`}>
                {label}
            </label>

            {isFastField ? (
                <FormikFastField {...componentProps}>{children}</FormikFastField>
            ) : (
                <FormikField {...componentProps}>{children}</FormikField>
            )}

            {errors && touched && <div className="invalid-feedback">{errors}</div>}

            {messages &&
                messages.map((message, key) => (
                    <p key={key} className="text-muted lh-1 mb-2">
                        <small>{message}</small>
                    </p>
                ))}
        </div>
    );
}
