import React, { useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { register } from '../../requests/authentication';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';

const initialValues = {
    name: '',
    email: '',
    email_confirmation: '',
    phone: '',
    identifier: '',
    password: '',
};

const validationSchema = Yup.object({
    name: Yup.string().required('Campo obrigatório'),
    email: Yup.string().required('Campo obrigatório').email('Endereço de email inválido'),
    email_confirmation: Yup.string()
        .oneOf([Yup.ref('email'), null], 'Os emails não coincidem')
        .required('Campo obrigatório'),
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
    password: Yup.string()
        .required('Campo obrigatório')
        .matches(/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/, 'Deve conter maiúsculas, minúsculas e números')
        .min(8, 'A senha deve ter no mínimo 8 caracteres'),
});

export default function AuthenticationRegisterForm(props) {
    const [isLoading, setLoading] = useState(false);
    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        register(apiProvider.api, notifications, navigate, setLoading, values);
    };

    return (
        <Formik initialValues={initialValues} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ errors, touched }) => (
                <Form>
                    <Field name="name" label="Nome completo" type="text" errors={errors.name} touched={touched.name} />
                    <div className="row">
                        <div className="col-lg">
                            <Field
                                name="identifier"
                                label="Matrícula ou SIAPE"
                                type="text"
                                errors={errors.identifier}
                                touched={touched.identifier}
                                messages={['Somente números', 'Entre 7 e 9 dígitos']}
                            />
                        </div>
                        <div className="col-lg">
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

                    <Field name="email" label="Email" type="email" errors={errors.email} touched={touched.email} />

                    <Field
                        name="email_confirmation"
                        label="Confirme o email"
                        type="email_confirmation"
                        errors={errors.email_confirmation}
                        touched={touched.email_confirmation}
                    />

                    <Field
                        name="password"
                        label="Senha"
                        type="password"
                        errors={errors.password}
                        touched={touched.password}
                        messages={['Maiúsculas, minúsculas e números', 'Mínimo 8 caracteres']}
                    />

                    <div className="d-grid gap-2">
                        <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                            Cadastrar
                        </Button>
                    </div>
                </Form>
            )}
        </Formik>
    );
}
