import React from 'react';
import { Form as FormikForm } from 'formik';

export default function Form(props) {
    return <FormikForm noValidate>{props.children}</FormikForm>;
}
