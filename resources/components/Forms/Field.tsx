import React from 'react';
import { Field as FormikField } from 'formik';
import { FastField as FormikFastField } from 'formik';

export default function (props) {
    const {
        name,
        label,
        type,
        autoComplete,
        placeholder,
        as,
        component,
        style,
        async,
        errors,
        touched,
        children,
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
        async: async,
        className: `form-control Field ${errors && touched ? 'is-invalid' : ''}`,
    };

    return (
        <div className="mb-4">
            <label htmlFor={name} className="form-label">
                {label}
            </label>
            {isFastField ? (
                <FormikFastField {...componentProps}>{children}</FormikFastField>
            ) : (
                <FormikField {...componentProps}>{children}</FormikField>
            )}
            {errors && touched && <div className="invalid-feedback">{errors}</div>}
        </div>
    );
}
