import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/project';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import DateField from '../../components/Forms/DateField';
import CheckboxField from '../../components/Forms/CheckboxField';
import SelectMultiple from '../../components/Forms/SelectMultiple';
import UserCollection from '../../collections/User/UserCollection';
import Select from '../../components/Forms/Select';
import ProductionCategoryCollection from '../../collections/ProductionCategory/ProductionCategoryCollection';
import Checkbox from '../../components/Forms/Checkbox';
import Section from '../../components/Section';
import CheckboxGroupField from '../../components/Forms/CheckboxGroupField';

const initialValues = {
    title: '',
    synopsis: '',
    owner: '',
    production_category: '',
    professor: '',
    genres: [],
    capture_format: '',
    capture_notes: '',
    venues: '',
    pre_production_date: '',
    production_date: '',
    post_production_date: '',
    has_attended_photography_discipline: false,
    has_attended_sound_discipline: false,
    has_attended_art_discipline: false,
    directors: [],
    producers: [],
    photography_directors: [],
    sound_directors: [],
    art_directors: [],
};

const validationSchema = Yup.object({
    title: Yup.string().required('Campo obrigatório'),
    synopsis: Yup.string().required('Campo obrigatório'),
    // owner: Yup.string().required('Campo obrigatório'),
    // production_category: '',
    // professor: '',
    // genres: [],
    capture_format: Yup.string().nullable(),
    capture_notes: Yup.string().nullable(),
    venues: Yup.string().nullable(),
    pre_production_date: Yup.string().nullable(),
    production_date: Yup.string().nullable(),
    post_production_date: Yup.string().nullable(),
    has_attended_photography_discipline: Yup.bool().required('Campo obrigatório'),
    has_attended_sound_discipline: Yup.bool().required('Campo obrigatório'),
    has_attended_art_discipline: Yup.bool().required('Campo obrigatório'),
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
            // if (showRequest === 'revision') {
            //     showRevision(id);
            // } else {
            show(notifications, setValues, setLoading, props.id);
            // }
        }
    }, []);

    return (
        <Formik enableReinitialize initialValues={values} validationSchema={validationSchema} onSubmit={onSubmit}>
            {({ values, errors, touched, setFieldValue }) => (
                <Form>
                    <Field
                        name="title"
                        label="Título"
                        type="text"
                        size="lg"
                        errors={errors.title}
                        touched={touched.title}
                    />
                    <Field
                        name="synopsis"
                        label="Sinopse"
                        as="textarea"
                        errors={errors.synopsis}
                        touched={touched.synopsis}
                    />
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
                                name="owner"
                                label="Professor Responsável"
                                value={values.professor && values.professor.name}
                                errors={errors.professor}
                                touched={touched.professor}
                                selected={values.professor}
                                onChange={(item) => setFieldValue('professor', item)}
                            >
                                {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                            </Select>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md">
                            <Select
                                name="production_category"
                                label="Modalidade"
                                value={values.production_category && values.production_category.title}
                                errors={errors.production_category}
                                touched={touched.production_category}
                                selected={values.production_category}
                                onChange={(item) => setFieldValue('production_category', item)}
                            >
                                {(selected, selectFn) => (
                                    <ProductionCategoryCollection selected={selected} selectFn={selectFn} />
                                )}
                            </Select>
                        </div>
                        <div className="col-md">
                            <div className="col-md">
                                <CheckboxGroupField
                                    name="genres"
                                    label="Gêneros"
                                    selected={values.genres}
                                    onChange={(value) => setFieldValue('genres', value)}
                                    items={[
                                        { label: 'Ficção', value: 'fiction' },
                                        { label: 'Documentário', value: 'documentary' },
                                        { label: 'Animação', value: 'animation' },
                                        { label: 'Experimental', value: 'experimental' },
                                        { label: 'Outros', value: 'other' },
                                    ]}
                                />
                            </div>
                        </div>
                    </div>

                    <Section title="Datas">
                        <div className="row">
                            <div className="col-md">
                                <DateField
                                    name="pre_production_date"
                                    label="Pré-produção"
                                    errors={errors.pre_production_date}
                                    touched={touched.pre_production_date}
                                    onChange={(value) => setFieldValue('pre_production_date', value)}
                                />
                            </div>
                            <div className="col-md">
                                <DateField
                                    name="production_date"
                                    label="Produção"
                                    errors={errors.production_date}
                                    touched={touched.production_date}
                                    onChange={(value) => setFieldValue('production_date', value)}
                                />
                            </div>
                            <div className="col-md">
                                <DateField
                                    name="post_production_date"
                                    label="Pós-produção"
                                    errors={errors.post_production_date}
                                    touched={touched.post_production_date}
                                    onChange={(value) => setFieldValue('post_production_date', value)}
                                />
                            </div>
                        </div>
                    </Section>

                    <Section title="Captação e Locações">
                        <div className="row">
                            <div className="col-md">
                                <Field
                                    type="text"
                                    name="capture_format"
                                    label="Captação"
                                    errors={errors.capture_format}
                                    touched={touched.capture_format}
                                />
                                <Field
                                    name="capture_notes"
                                    label="Detalhes da Captação"
                                    as="textarea"
                                    errors={errors.capture_notes}
                                    touched={touched.capture_notes}
                                />
                            </div>
                            <div className="col-md">
                                <Field
                                    name="venue"
                                    label="Locações"
                                    as="textarea"
                                    errors={errors.venue}
                                    touched={touched.venue}
                                />
                            </div>
                        </div>
                    </Section>

                    <Section title="Equipe">
                        <div className="row">
                            <div className="col-md">
                                <SelectMultiple
                                    name="directors"
                                    label="Diretores"
                                    multipleLabel={(user) => user.name}
                                    addLabel="Adicionar diretor"
                                    errors={errors.directors}
                                    touched={touched.directors}
                                    selected={values.directors}
                                    onChange={(user) => setFieldValue('directors', user)}
                                >
                                    {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                                </SelectMultiple>
                            </div>
                            <div className="col-md">
                                <SelectMultiple
                                    name="producers"
                                    label="Produtores"
                                    multipleLabel={(user) => user.name}
                                    addLabel="Adicionar produtor"
                                    errors={errors.producers}
                                    touched={touched.producers}
                                    selected={values.producers}
                                    onChange={(user) => setFieldValue('producers', user)}
                                >
                                    {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                                </SelectMultiple>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-md">
                                <SelectMultiple
                                    name="photography_directors"
                                    label="Diretores de fotografia"
                                    multipleLabel={(user) => user.name}
                                    addLabel="Adicionar diretor de fotografia"
                                    errors={errors.photography_directors}
                                    touched={touched.photography_directors}
                                    selected={values.photography_directors}
                                    onChange={(user) => setFieldValue('photography_directors', user)}
                                >
                                    {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                                </SelectMultiple>
                                <div className="mb-4">
                                    <CheckboxField
                                        name="has_attended_photography_discipline"
                                        label="Já cursaram a disciplina de Fotografia e Iluminação"
                                        size="sm"
                                        errors={errors.has_attended_photography_discipline}
                                        touched={touched.has_attended_photography_discipline}
                                    />
                                </div>
                            </div>
                            <div className="col-md">
                                <SelectMultiple
                                    name="sound_directors"
                                    label="Diretores de som"
                                    multipleLabel={(user) => user.name}
                                    addLabel="Adicionar diretor de som"
                                    errors={errors.sound_directors}
                                    touched={touched.sound_directors}
                                    selected={values.sound_directors}
                                    onChange={(user) => setFieldValue('sound_directors', user)}
                                >
                                    {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                                </SelectMultiple>
                                <div className="mb-4">
                                    <CheckboxField
                                        name="has_attended_sound_discipline"
                                        label="Já cursaram a disciplina de Técnica de Som em Cinema e Audiovisual"
                                        size="sm"
                                        errors={errors.has_attended_sound_discipline}
                                        touched={touched.has_attended_sound_discipline}
                                    />
                                </div>
                            </div>
                            <div className="col-md">
                                <SelectMultiple
                                    name="art_directors"
                                    label="Diretores de som"
                                    multipleLabel={(user) => user.name}
                                    addLabel="Adicionar diretor de arte"
                                    errors={errors.art_directors}
                                    touched={touched.art_directors}
                                    selected={values.art_directors}
                                    onChange={(user) => setFieldValue('art_directors', user)}
                                >
                                    {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                                </SelectMultiple>
                                <div className="mb-4">
                                    <CheckboxField
                                        name="has_attended_art_discipline"
                                        label="Já cursaram a disciplina de Design Visual"
                                        size="sm"
                                        errors={errors.has_attended_art_discipline}
                                        touched={touched.has_attended_art_discipline}
                                    />
                                </div>
                            </div>
                        </div>
                    </Section>

                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
