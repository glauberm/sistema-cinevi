import React from 'react';

import Field from './Field';
import Select from './Select';

export default function (props) {
    const { name, label, errors, touched } = props;

    return <Field name={name} label={label} component={Select} errors={errors} touched={touched} />;
}
