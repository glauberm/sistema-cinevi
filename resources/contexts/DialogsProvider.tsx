import React, { createContext, useEffect, useState } from 'react';

import Dialog from '../components/Dialog';

export const DialogsContext = createContext(undefined);

export default function DialogsProvider(props) {
    const [dialogs, setDialogs] = useState([]);

    useEffect(() => {
        if (dialogs.length > 0) {
            document.documentElement.classList.add('modal-open');
        } else {
            document.documentElement.classList.remove('modal-open');
        }
    }, [dialogs]);

    const add = (key, title, body, footer) => {
        const newDialog = { key: key, title: title, body: body, footer: footer };
        setDialogs([...dialogs, newDialog]);
    };

    const remove = (key: string) => {
        setDialogs(dialogs.filter((dialog) => dialog.key !== key));
    };

    const contextValues = { add: add, remove: remove };

    console.log(dialogs);

    return (
        <DialogsContext.Provider value={contextValues}>
            {props.children}

            {Boolean(dialogs.length) && (
                <>
                    <div className="DialogsProvider">
                        {dialogs.map(({ key, title, body, footer }) => (
                            <Dialog key={key} title={title} body={body} footer={footer} close={() => remove(key)} />
                        ))}
                    </div>
                    <div className="modal-backdrop fade show"></div>
                </>
            )}
        </DialogsContext.Provider>
    );
}
