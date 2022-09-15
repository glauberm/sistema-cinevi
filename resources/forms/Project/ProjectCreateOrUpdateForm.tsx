import React, { useState, useContext, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik } from 'formik';
import * as Yup from 'yup';

import { create, show, update } from '../../requests/project';
import { NotificationsContext } from '../../contexts/NotificationsProvider';
import { ApiContext } from '../../contexts/ApiProvider';
import Form from '../../components/Forms/Form';
import Field from '../../components/Forms/Field';
import Button from '../../components/Button';
import DateField from '../../components/Forms/DateField';
import CheckboxField from '../../components/Forms/CheckboxField';
import SelectMultiple from '../../components/Forms/SelectMultiple';
import UserCollection from '../../collections/UserCollection';
import Select from '../../components/Forms/Select';
import ProductionCategoryCollection from '../../collections/ProductionCategoryCollection';
import Section from '../../components/Section';
import CheckboxGroupField from '../../components/Forms/CheckboxGroupField';

const initialValues = {
    title: '',
    synopsis: '',
    owner: '',
    production_category: '',
    professor: '',
    genres: [],
    pre_production_date: '',
    production_date: '',
    post_production_date: '',
    capture_format: '',
    capture_notes: '',
    venues: '',
    directors: [],
    producers: [],
    photography_directors: [],
    sound_directors: [],
    art_directors: [],
    has_attended_photography_discipline: false,
    has_attended_sound_discipline: false,
    has_attended_art_discipline: false,
};

const validationSchema = Yup.object({
    title: Yup.string().required('Campo obrigatório'),
    synopsis: Yup.string().required('Campo obrigatório'),
    owner: Yup.object().shape({
        id: Yup.number().required('Campo obrigatório'),
    }),
    production_category: Yup.object().shape({
        id: Yup.number().required('Campo obrigatório'),
    }),
    professor: Yup.object().shape({
        id: Yup.number().required('Campo obrigatório'),
    }),
    genres: Yup.array().min(1, 'Campo obrigatório'),
    capture_format: Yup.string().nullable(),
    capture_notes: Yup.string().nullable(),
    venues: Yup.string().nullable(),
    pre_production_date: Yup.string().required('Campo obrigatório'),
    production_date: Yup.string().required('Campo obrigatório'),
    post_production_date: Yup.string().required('Campo obrigatório'),
    directors: Yup.array().min(1, 'Campo obrigatório'),
    producers: Yup.array().min(1, 'Campo obrigatório'),
    photography_directors: Yup.array().min(1, 'Campo obrigatório'),
    sound_directors: Yup.array().min(1, 'Campo obrigatório'),
    art_directors: Yup.array().min(1, 'Campo obrigatório'),
    has_attended_photography_discipline: Yup.bool().oneOf([true], 'Campo obrigatório'),
    has_attended_sound_discipline: Yup.bool().oneOf([true], 'Campo obrigatório'),
    has_attended_art_discipline: Yup.bool().oneOf([true], 'Campo obrigatório'),
});

export default function ProjectCreateOrUpdateForm(props) {
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
                                errors={errors.owner && errors.owner}
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
                                {(selected, selectFn) => (
                                    <UserCollection selected={selected} selectFn={selectFn} professorsOnly />
                                )}
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
                                    errors={errors.genres}
                                    touched={touched.genres}
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
                                    values={values.pre_production_date}
                                    errors={errors.pre_production_date}
                                    touched={touched.pre_production_date}
                                    onChange={(value) => setFieldValue('pre_production_date', value)}
                                />
                            </div>
                            <div className="col-md">
                                <DateField
                                    name="production_date"
                                    label="Produção"
                                    values={values.production_date}
                                    errors={errors.production_date}
                                    touched={touched.production_date}
                                    onChange={(value) => setFieldValue('production_date', value)}
                                />
                            </div>
                            <div className="col-md">
                                <DateField
                                    name="post_production_date"
                                    label="Pós-produção"
                                    values={values.post_production_date}
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
                                    name="capture_format"
                                    label="Captação"
                                    as="select"
                                    errors={errors.capture_format}
                                    touched={touched.capture_format}
                                    messages={['Não obrigatório']}
                                >
                                    <option value=""></option>
                                    <option value="video">Vídeo</option>
                                    <option value="film">Película</option>
                                    <option value="digital">Digital</option>
                                    <option value="other">Outra</option>
                                </Field>
                                <Field
                                    name="capture_notes"
                                    label="Detalhes da Captação"
                                    as="textarea"
                                    errors={errors.capture_notes}
                                    touched={touched.capture_notes}
                                    messages={['Não obrigatório']}
                                />
                            </div>
                            <div className="col-md">
                                <Field
                                    name="venue"
                                    label="Locações"
                                    as="textarea"
                                    errors={errors.venue}
                                    touched={touched.venue}
                                    messages={['Não obrigatório']}
                                />
                            </div>
                        </div>
                    </Section>

                    <Section title="Equipe">
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

                        <SelectMultiple
                            name="art_directors"
                            label="Diretores de arte"
                            multipleLabel={(user) => user.name}
                            addLabel="Adicionar diretor de arte"
                            errors={errors.art_directors}
                            touched={touched.art_directors}
                            selected={values.art_directors}
                            onChange={(user) => setFieldValue('art_directors', user)}
                        >
                            {(selected, selectFn) => <UserCollection selected={selected} selectFn={selectFn} />}
                        </SelectMultiple>

                        <CheckboxField
                            name="has_attended_photography_discipline"
                            label="Os diretores de fotografia já cursaram a disciplina de Fotografia e Iluminação"
                            errors={errors.has_attended_photography_discipline}
                            touched={touched.has_attended_photography_discipline}
                        />
                        <CheckboxField
                            name="has_attended_sound_discipline"
                            label="Os diretores de som já cursaram a disciplina de Técnica de Som em Cinema e Audiovisual"
                            errors={errors.has_attended_sound_discipline}
                            touched={touched.has_attended_sound_discipline}
                        />
                        <CheckboxField
                            name="has_attended_art_discipline"
                            label="Os diretores de arte já cursaram a disciplina de Design Visual"
                            errors={errors.has_attended_art_discipline}
                            touched={touched.has_attended_art_discipline}
                        />
                    </Section>

                    <Button type="submit" className="btn btn-lg btn-primary" isLoading={isLoading}>
                        {props.id ? 'Editar' : 'Criar'}
                    </Button>
                </Form>
            )}
        </Formik>
    );
}
