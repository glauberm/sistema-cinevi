import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/booking';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import DateField from '../../components/Forms/DateField';
import Button from '../../components/Button';
import SelectMultiple from '../../components/Forms/SelectMultiple';
import BookableCollection from '../../collections/Bookable/BookableCollection';
import Select from '../../components/Forms/Select';
import UserCollection from '../../collections/User/UserCollection';
import ProjectCollection from '../../collections/Project/ProjectCollection';

const initialValues = {
    withdrawal_date: '',
    devolution_date: '',
    bookables: [],
};

const validationSchema = Yup.object({
    withdrawal_date: Yup.string().required('Campo obrigatório'),
    devolution_date: Yup.string().required('Campo obrigatório'),
    bookables: Yup.array().min(1, 'A reserva deve ter ao menos um reservável'),
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

    useEffect(() => {
        if (props.id) {
            show(notifications, setValues, setLoading, props.id);
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <div className="row">
                        <div className="col-md">
                            <Select
                                name="owner"
                                label="Responsável"
                                value={values.owner && values.owner.name}
                                errors={errors.owner}
                                touched={touched.owner}
                                selected={values.owner}
                                onChange={(item) => setFieldValue('owner', item)}
                            >
                                {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                            </Select>
                        </div>
                        <div className="col-md">
                            <Select
                                name="project"
                                label="Projeto"
                                value={values.project && values.project.title}
                                errors={errors.project}
                                touched={touched.project}
                                selected={values.project}
                                onChange={(item) => setFieldValue('project', item)}
                            >
                                {(selected, selectFn) => <ProjectCollection selected={selected} selectFn={selectFn} />}
                            </Select>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <DateField
                                name="withdrawal_date"
                                label="Data de Retirada"
                                values={values.withdrawal_date}
                                errors={errors.withdrawal_date}
                                touched={touched.withdrawal_date}
                                onChange={(value) => setFieldValue('withdrawal_date', value)}
                            />
                        </div>
                        <div className="col-md">
                            <DateField
                                name="devolution_date"
                                label="Data de Devolução"
                                values={values.devolution_date}
                                errors={errors.devolution_date}
                                touched={touched.devolution_date}
                                onChange={(value) => setFieldValue('devolution_date', value)}
                            />
                        </div>
                    </div>

                    <SelectMultiple
                        name="bookables"
                        label="Reserváveis"
                        multipleLabel={(bookable) => bookable.name}
                        addLabel="Adicionar reservável"
                        errors={errors.bookables}
                        touched={touched.bookables}
                        selected={values.bookables}
                        onChange={(bookables) => setFieldValue('bookables', bookables)}
                    >
                        {(selected, selectFn) => <BookableCollection selected={selected} selectFn={selectFn} />}
                    </SelectMultiple>

                    <hr className="invisible" />

                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
