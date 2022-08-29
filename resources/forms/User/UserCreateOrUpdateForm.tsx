import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { FieldArray, Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/user';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import CheckboxField from '../../components/Forms/CheckboxField';
import Checkbox from '../../components/Forms/Checkbox';

const initialValues = {
    name: '',
    email: '',
    password: '',
    phone: '',
    identifier: '',
    is_enabled: false,
    is_confirmed: false,
    roles: ['user'],
};

const validationSchema = Yup.object({
    name: Yup.string().required('Campo obrigatório'),
    email: Yup.string().email('Endereço de e-mail inválido').required('Campo obrigatório'),
    password: Yup.string().required('Campo obrigatório'),
    phone: Yup.string().required('Campo obrigatório'),
    identifier: Yup.string().required('Campo obrigatório'),
    is_enabled: Yup.bool().required('Campo obrigatório'),
    is_confirmed: Yup.bool().required('Campo obrigatório'),
    roles: Yup.array().min(1, 'Campo obrigatório'),
});

export default function (props) {
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

    const rolesOnChange = (target, value, roles, setFieldValue) => {
        if (Boolean(target.checked)) {
            setFieldValue('roles', [...new Set([...roles, value])]);
        } else {
            setFieldValue(
                'roles',
                roles.filter((role: string) => role !== value)
            );
        }
    };

    useEffect(() => {
        if (props.id) {
            // if (showRequest === 'revision') {
            //     showRevision(id);
            // } else {
            // show(notifications, setValues, setLoading, props.id);
            // }
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <div className="row">
                        <div className="col-md">
                            <Field name="name" label="Nome" type="text" errors={errors.name} touched={touched.name} />
                        </div>
                        <div className="col-md">
                            <Field
                                name="email"
                                label="Email"
                                type="email"
                                errors={errors.email}
                                touched={touched.email}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Field
                                name="phone"
                                label="Telefone"
                                type="tel"
                                errors={errors.phone}
                                touched={touched.phone}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="identifier"
                                label="Matrícula ou SIAPE"
                                type="tel"
                                errors={errors.identifier}
                                touched={touched.identifier}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <label id="status-group" className="form-label">
                                Status
                            </label>
                            <div role="group" aria-labelledby="status-group" className="mb-4">
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
                        <div className="col-md">
                            <label id="roles-group" className="form-label">
                                Papéis
                            </label>
                            <div role="group" aria-labelledby="roles-group" className="mb-4">
                                <Checkbox name="roles" label="Usuário" checked readOnly />
                                <Checkbox
                                    name="roles"
                                    label="Departamento"
                                    value="department"
                                    checked={values.roles.includes('department')}
                                    onChange={({ target }) =>
                                        rolesOnChange(target, 'department', values.roles, setFieldValue)
                                    }
                                />
                                <Checkbox
                                    name="roles"
                                    label="Almoxarifado"
                                    value="warehouse"
                                    checked={values.roles.includes('warehouse')}
                                    onChange={({ target }) =>
                                        rolesOnChange(target, 'warehouse', values.roles, setFieldValue)
                                    }
                                />
                                <Checkbox
                                    name="roles"
                                    label="Administrador"
                                    value="admin"
                                    checked={values.roles.includes('admin')}
                                    onChange={({ target }) =>
                                        rolesOnChange(target, 'admin', values.roles, setFieldValue)
                                    }
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
