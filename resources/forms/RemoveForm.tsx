import React, { useContext } from 'react';

import { DialogsContext } from '../contexts/DialogsProvider';
import Button from '../components/Button';

export default function (props) {
    const { isLoading, onSubmit } = props;

    const dialogs = useContext(DialogsContext);
    const dialogKey = 'remove_form';

    const onSubmitFn = (event) => {
        event.preventDefault();
        onSubmit();
        dialogs.remove(dialogKey);
    };

    const onClickFn = () => {
        dialogs.add(
            dialogKey,
            'Confirmar remoção',
            <p>Tem certeza de que deseja remover este item? Essa ação não poderá ser desfeita.</p>,
            <form noValidate onSubmit={onSubmitFn}>
                <Button type="submit" className="btn-danger" isLoading={isLoading}>
                    Confirmar remoção
                </Button>
            </form>
        );
    };

    return (
        <div className="text-center">
            <Button type="button" onClick={onClickFn} className="btn-outline-danger" isLoading={isLoading}>
                Remover
            </Button>
        </div>
    );
}
