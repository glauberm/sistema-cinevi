import React from 'react';
import Select from 'react-select';

export default function (props) {
    const { isMulti, options } = props.field;

    return (
        <Select
            placeholder={Boolean(isMulti) ? 'Selecione opções' : 'Selecione uma opção'}
            options={options}
            isMulti={isMulti}
            noOptionsMessage={() => 'Nenhum resultado'}
            styles={{
                noOptionsMessage: (provided, state) => ({
                    ...provided,
                    paddingTop: '3rem',
                    paddingBottom: '3rem',
                }),
            }}
        />
    );
}
