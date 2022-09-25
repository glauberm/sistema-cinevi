import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/bookable';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import CheckboxField from '../../components/Forms/CheckboxField';
import Select from '../../components/Forms/Select';
import SelectMultiple from '../../components/Forms/SelectMultiple';
import BookableCategoryCollection from '../../collections/BookableCategoryCollection';
import UserCollection from '../../collections/UserCollection';

const initialValues = {
    identifier: '',
    name: '',
    bookable_category: '',
    inventory_number: '',
    serial_number: '',
    accessories: '',
    notes: '',
    users: [],
    is_under_maintenance: false,
    is_return_overdue: false,
};

const validationSchema = Yup.object({
    name: Yup.string().required('Campo obrigatório'),
    inventory_number: Yup.string().nullable(),
    serial_number: Yup.string().nullable(),
    accessories: Yup.string().nullable(),
    notes: Yup.string().nullable(),
    is_under_maintenance: Yup.bool().required('Campo obrigatório'),
    is_return_overdue: Yup.bool().required('Campo obrigatório'),
});

export default function BookableCreateOrUpdateForm(props) {
    const [isLoading, setLoading] = useState(false);
    const [values, setValues] = useState(initialValues);

    const notifications = useContext(NotificationsContext);
    const apiProvider = useContext(ApiContext);
    const navigate = useNavigate();

    const onSubmit = (values) => {
        if (props.id) {
            update(apiProvider.api, notifications, navigate, setLoading, props.id, values);
        } else {
            create(apiProvider.api, notifications, navigate, setLoading, values);
        }
    };

    useEffect(() => {
        if (props.id) {
            show(apiProvider.api, notifications, setValues, setLoading, props.id);
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <div className="row">
                        <div className="col-md-2">
                            <Field
                                name="identifier"
                                label="Código"
                                type="text"
                                size="lg"
                                errors={errors.identifier}
                                touched={touched.identifier}
                            />
                        </div>
                        <div className="col-md-10">
                            <Field
                                name="name"
                                label="Nome"
                                type="text"
                                size="lg"
                                errors={errors.name}
                                touched={touched.name}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Select
                                name="bookable_category"
                                label="Categoria"
                                value={values.bookable_category && values.bookable_category.title}
                                errors={errors.bookable_category}
                                touched={touched.bookable_category}
                                selected={values.bookable_category}
                                onChange={(item) => setFieldValue('bookable_category', item)}
                            >
                                {(selected, selectFn) => (
                                    <BookableCategoryCollection selected={selected} selectFn={selectFn} />
                                )}
                            </Select>
                        </div>
                        <div className="col-md">
                            <Field
                                name="inventory_number"
                                label="Número de patrimônio"
                                type="text"
                                errors={errors.inventory_number}
                                touched={touched.inventory_number}
                                messages={['Não obrigatório']}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="serial_number"
                                label="Número de série"
                                type="text"
                                errors={errors.serial_number}
                                touched={touched.serial_number}
                                messages={['Não obrigatório']}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Field
                                name="accessories"
                                label="Acessórios"
                                as="textarea"
                                errors={errors.accessories}
                                touched={touched.accessories}
                                messages={['Não obrigatório']}
                            />
                        </div>
                        <div className="col-md">
                            <Field
                                name="notes"
                                label="Observações"
                                as="textarea"
                                errors={errors.notes}
                                touched={touched.notes}
                                messages={['Não obrigatório']}
                            />
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <SelectMultiple
                                name="users"
                                label="Reserva limitada a"
                                multipleLabel={(user) => user.name}
                                addLabel="Adicionar usuário"
                                errors={errors.users}
                                touched={touched.users}
                                selected={values.users}
                                onChange={(users) => setFieldValue('users', users)}
                                messages={['Não obrigatório']}
                            >
                                {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                            </SelectMultiple>
                        </div>
                        <div className="col-md">
                            <label id="status-group" className="form-label">
                                Status
                            </label>
                            <div role="group" aria-labelledby="status-group" className="mb-4">
                                <CheckboxField
                                    name="is_under_maintenance"
                                    label="Em manutenção"
                                    errors={errors.is_under_maintenance}
                                    touched={touched.is_under_maintenance}
                                />
                                <CheckboxField
                                    name="is_return_overdue"
                                    label="Devolução Atrasada"
                                    errors={errors.is_return_overdue}
                                    touched={touched.is_return_overdue}
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
