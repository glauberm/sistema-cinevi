import React from 'react';

import Radio from './Radio';

export default function PasswordRulesChecker({ password, passwordConfirmation }) {
    return (
        <div className="PasswordRulesChecker">
            <Radio readOnly label="Contém letras minúsculas" checked={new RegExp('^.*(?=.*[a-z])').test(password)} />
            <Radio readOnly label="Contém letras maiúsculas" checked={new RegExp('^.*(?=.*[A-Z])').test(password)} />
            <Radio readOnly label="Contém números" checked={new RegExp('^.*(?=.*[0-9])').test(password)} />
            <Radio readOnly label="Contém símbolos (!@#$%)" checked={new RegExp('^.*(?=.*[!@#$%])').test(password)} />
            <Radio readOnly label="Tem no mínimo 8 caracteres" checked={password.length > 7} />
            <Radio readOnly label="As senhas coincidem" checked={password && password === passwordConfirmation} />
        </div>
    );
}
