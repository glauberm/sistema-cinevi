import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/production-role';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    title: '',
    description: '',
};

const validationSchema = Yup.object({
    title: Yup.string().required('Campo obrigatório'),
    description: Yup.string().nullable(),
});

export default function ProductionRoleCreateOrUpdateForm(props) {
    const [isLoading, setLoading] = useState(false);
    const [values, setValues] = useState(initialValues);

    const notifications = useContext(NotificationsContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        if (props.id) {
            update(notifications, navigate, setLoading, props.id, values);
        } else {
            create(notifications, navigate, setLoading, values);
        }
    };

    useEffect(() => {
        if (props.id) {
            // if (showRequest === 'revision') {
            //     showRevision(id);
            // } else {
            show(notifications, setValues, setLoading, props.id);
            // }
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field
                        name="title"
                        label="Título da função"
                        type="text"
                        errors={errors.title}
                        touched={touched.title}
                    />
                    <Field
                        as="textarea"
                        name="description"
                        label="Descrição"
                        type="text"
                        errors={errors.description}
                        touched={touched.description}
                    />
                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
