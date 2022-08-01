import React from 'react';

import AuthenticationLoginPage from '../pages/Authentication/AuthenticationLoginPage';
import AuthenticationLogoutPage from '../pages/Authentication/AuthenticationLogoutPage';
import AuthenticationProfilePage from '../pages/Authentication/AuthenticationProfilePage';
import AuthenticationRegisterPage from '../pages/Authentication/AuthenticationRegisterPage';
import AuthenticationRequestResetPage from '../pages/Authentication/AuthenticationRequestResetPage';

export default {
    login: { path: '/entrada', element: <AuthenticationLoginPage /> },
    logout: { path: '/saida', element: <AuthenticationLogoutPage /> },
    register: { path: '/cadastro', element: <AuthenticationRegisterPage /> },
    profile: { path: '/', element: <AuthenticationProfilePage /> },
    requestReset: { path: '/recuperacao-de-senha', element: <AuthenticationRequestResetPage /> },
    // requestUpdateEmail: {
    //     path: '/solicitar-atualizar-email',
    //     element: <AuthenticationRequestUpdateEmailPage />,
    // },
    // resetPassword: { path: '/redefinir-senha', element: <AuthenticationResetPasswordPage /> },
    // updateEmail: { path: '/atualizar-email', element: <AuthenticationUpdateEmailPage /> },
    // updatePassword: { path: '/atualizar-senha', element: <AuthenticationUpdatePasswordPage /> },
};
