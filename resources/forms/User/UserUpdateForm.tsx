import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { show, update } from '../../requests/user';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import CheckboxField from '../../components/Forms/CheckboxField';
import CheckboxGroupField from '../../components/Forms/CheckboxGroupField';

const initialValues = {
    name: '',
    email: '',
    phone: '',
    identifier: '',
    is_enabled: false,
    is_confirmed: false,
    roles: [],
};

const validationSchema = Yup.object({
    name: Yup.string().required('Campo obrigatório'),
    email: Yup.string().email('Endereço de email inválido').required('Campo obrigatório'),
    phone: Yup.string()
        .required('Campo obrigatório')
        .matches(/^\d+$/, 'Somente números')
        .min(10, 'No mínimo 10 dígitos, com DDD')
        .max(11, 'No máximo 11 dígitos, com DDD'),
    identifier: Yup.string()
        .required('Campo obrigatório')
        .matches(/^\d+$/, 'Somente números')
        .min(7, 'No mínimo 7 dígitos')
        .max(9, 'No máximo 9 dígitos'),
    is_enabled: Yup.bool().required('Campo obrigatório'),
    is_confirmed: Yup.bool().required('Campo obrigatório'),
    roles: Yup.array(),
});

export default function UserUpdateForm(props) {
    const [isLoading, setLoading] = useState(false);
    const [values, setValues] = useState(initialValues);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        update(apiProvider.api, notifications, navigate, setLoading, props.id, values);
    };

    useEffect(() => {
        show(apiProvider.api, notifications, setValues, setLoading, props.id);
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <div className="col-md">
                        <Field
                            name="name"
                            label="Nome"
                            type="text"
                            size="lg"
                            errors={errors.name}
                            touched={touched.name}
                        />
                    </div>

                    <div className="row">
                        <div className="col-md">
                            <Field
                                name="email"
                                label="Email"
                                type="email"
                                errors={errors.email}
                                touched={touched.email}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="identifier"
                                label="Matrícula ou SIAPE"
                                type="tel"
                                errors={errors.identifier}
                                touched={touched.identifier}
                                messages={['Somente números', 'Entre 7 e 9 dígitos']}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="phone"
                                label="Telefone"
                                type="tel"
                                errors={errors.phone}
                                touched={touched.phone}
                                messages={['Somente números', 'Entre 10 e 11 dígitos, com DDD']}
                            />
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-md">
                            <CheckboxGroupField
                                name="roles"
                                label="Papéis"
                                selected={values.roles}
                                onChange={(value) => setFieldValue('roles', value)}
                                items={[
                                    { label: 'Professor', value: 'professor' },
                                    { label: 'Departamento', value: 'department' },
                                    { label: 'Almoxarifado', value: 'warehouse' },
                                    { label: 'Administrador', value: 'admin' },
                                ]}
                            />
                        </div>
                        <div className="col-md">
                            <label htmlFor="status-group" id="status-group-label" className="form-label">
                                Status
                            </label>
                            <div role="group" id="status-group" aria-labelledby="status-group-label" className="mb-4">
                                <CheckboxField
                                    name="is_enabled"
                                    label="Ativo"
                                    errors={errors.is_enabled}
                                    touched={touched.is_enabled}
                                />
                                <CheckboxField
                                    name="is_confirmed"
                                    label="Confirmado"
                                    errors={errors.is_confirmed}
                                    touched={touched.is_confirmed}
                                />
                            </div>
                        </div>
                    </div>

                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
