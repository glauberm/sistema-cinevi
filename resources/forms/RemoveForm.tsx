import React from 'react';

import Button from '../components/Button';

export default function RemoveForm(props) {
    const { isLoading, onSubmit } = props;

    const onSubmitFn = (event) => {
        event.preventDefault();
        onSubmit();
    };

    return (
        <form noValidate onSubmit={onSubmitFn}>
            <Button type="submit" className="btn-outline-danger" isLoading={isLoading}>
                Remover
            </Button>
        </form>
    );
}
